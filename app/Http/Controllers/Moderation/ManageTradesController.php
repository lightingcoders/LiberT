<?php

namespace App\Http\Controllers\Moderation;

use App\Models\Trade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class ManageTradesController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('moderation.manage_trades.index', [
            'escrow_wallet' => $this->getEscrowWalletData(),
            'coins' => get_coins()
        ]);
    }

    public function payout(Request $request)
    {

        $this->validate($request, [
            'token' => [
                'nullable', 'required_without:password',
                function ($attribute, $value, $fail) {
                    if ($value !== null) {
                        if(!Auth::user()->getSetting()->outgoing_transfer_2fa){
                            $fail(__('Two factor not set! Use password instead!'));
                        }else{
                            $valid = $this->google2fa->verifyKey(
                                Auth::user()->google2fa_secret, $value
                            );

                            if (!$valid) {
                                $fail(__('You have entered an invalid token!'));
                            }
                        }
                    }
                },
            ],

            'password' => [
                'nullable', 'required_without:token',
                function ($attribute, $value, $fail) {
                    if ($value !== null) {
                        if(!Auth::user()->getSetting()->outgoing_transfer_2fa){
                            if (!Hash::check($value, Auth::user()->password)) {
                                $fail(__('You have entered an invalid password!'));
                            }
                        }else{
                            $fail(__('You need to enter your 2FA token instead!'));
                        }
                    }
                },
            ],

            'coin' => [
                'required', Rule::in(array_keys(get_coins()))
            ]
        ]);

        $addresses = getAddressModel($request->coin)
            ->latest()->where('balance', '>', 0)
            ->get();

        if($addresses->count()){
            // Get Adapter for this coin
            $adapter = getBlockchainAdapter($request->coin);

            if(!$addresses->contains('address', $request->address)){
                $tx = $adapter->send(
                    $addresses, $request->address, -1
                );

                if(isset($tx['hash'])){
                    $message = __('Your transaction was successful!');

                    return success_response($request, $message);
                }else{
                    $message = __('Oops! Something went wrong... Try again later');

                    return error_response($request, $message);
                }
            }else{
                $message = __('You cannot send to the same escrow address!');

                return error_response($request, $message);
            }
        }else{
            $message = __('You do not have any unspent escrow balance!');

            return error_response($request, $message);
        }
    }

    /**
     * Get wallet data
     *
     * @return array|null
     */
    public function getEscrowWalletData()
    {
        $wallets = collect([]);

        foreach (get_coins() as $key => $name){
            $value = getAddressModel($key)
                ->latest()->where('balance', '>', 0)
                ->sum('balance');

            $balance = base_to_coin($value);

            $details = [
                'total_available_price' => get_price(
                    $balance, $key, config()->get('settings.default_currency')
                ),
                'total_available' => $balance,
            ];

            $wallets->put($key, $details);
        }


        return $wallets;
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function data(Request $request)
    {
        if ($request->ajax()) {
            $trades = Trade::has('user')->has('partner')
                ->select();

            if($request->coin){
                $trades = $trades->where('coin', $request->coin);
            }

            if($request->status){
                $trades = $trades->where('status', $request->status);
            }

            $trades = $trades->get();

            return DataTables::of($trades)
                ->editColumn('type', function ($data) {
                    return strtoupper($data->type);
                })
                ->editColumn('status', function ($data) {
                    $status = ucfirst($data->status);

                    switch ($data->status) {
                        case 'active':
                            $html = "<span class='badge badge-info'>{$status}</span>";
                            break;
                        case 'successful':
                            $html = "<span class='badge badge-success'>{$status}</span>";
                            break;
                        case 'cancelled':
                            $html = "<span class='badge badge-danger'>{$status}</span>";
                            break;
                        case 'dispute':
                            $html = "<span class='badge badge-warning'>{$status}</span>";
                            break;
                        default:
                            $html = "<span class='badge badge-secondary'>{$status}</span>";
                    }

                    return $html;
                })
                ->editColumn('coin', function ($data) {
                    return get_coin($data->coin);
                })
                ->editColumn('amount', function ($data) {
                    return money($data->amount, $data->currency, true);
                })
                ->editColumn('rate', function ($data) {
                    return money($data->rate, $data->currency, true);
                })
                ->addColumn('coin_value', function ($data) {
                    return $data->coinValue() . strtoupper($data->coin);
                })
                ->addColumn('buyer', function ($data) {
                    return view('home.trades.partials.datatable.buyer')
                        ->with(compact('data'));
                })
                ->addColumn('seller', function ($data) {
                    return view('home.trades.partials.datatable.seller')
                        ->with(compact('data'));
                })
                ->addColumn('trade', function ($data) {
                    return \HTML::link(route('home.trades.index', [
                        'token' => $data->token
                    ]), $data->token);
                })
                ->addColumn('offer', function ($data) {
                    if ($offer = $data->offer) {
                        return \HTML::link(route('home.offers.index', [
                            'token' => $offer->token
                        ]), $offer->token);
                    }
                })
                ->removeColumn('dispute_by', 'dispute_comment')
                ->rawColumns(['status', 'buyer', 'seller'])
                ->make(true);
        } else {
            return abort(404);
        }

    }
}
