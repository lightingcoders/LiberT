<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Cryptocompare\Price;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use PragmaRX\Google2FA\Google2FA;
use Yajra\DataTables\Facades\DataTables;

class WalletController extends Controller
{

    /**
     * An instance of google 2fa generator
     *
     * @var Google2FA
     */
    protected $google2fa;

    /**
     * Create a new controller instance.
     *
     * @param Google2FA $google2fa
     * @return void
     */
    public function __construct(Google2FA $google2fa)
    {
        $this->google2fa = $google2fa;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('wallet.index');
    }



    /**
     * @param Request $request
     * @param string $coin
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function generateAddress(Request $request, $coin = 'btc')
    {
        if ($request->ajax()) {
            $coin_address = Auth::user()->getAddressModel($coin)->latest()->first();

            $adapter = getBlockchainAdapter($coin);

            $transactions_count = ($coin_address)? $coin_address->transactions()->count(): 0;

            if (!$coin_address || ($transactions_count)) {

                $address = collect($adapter->generateAddress());

                Auth::user()->getAddressModel($coin)->create($address->only([
                    'private', 'public', 'address', 'wif'
                ])->toArray());

                $message = __('A new address has been created successfully!');

                return success_response($request, $message);
            } else {
                $message = __('Your previous address does not have any record of transaction!');

                return error_response($request, $message);
            }

        } else {
            return abort(403);
        }
    }

    /**
     * @param Request $request
     * @param string $coin
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send(Request $request, $coin = 'btc')
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
        ]);


        if(Auth::user()->getCoinAvailable($coin) >= $request->amount){
            // Get all addresses with UTXOs
            $addresses = Auth::user()->getAddressModel($coin)
                ->latest()->where('balance', '>', 0)->get();

            // Get Adapter for this coin
            $adapter = getBlockchainAdapter($coin);

            if(!$addresses->contains('address', $request->address)){
                $amount = coin_to_base($request->amount);

                $tx = $adapter->send(
                    $addresses, $request->address, $amount
                );

                if(isset($tx['hash'])){
                    $message = __('Your transaction was successful!');

                    return success_response($request, $message);
                }else{
                    $message = __('Oops! Something went wrong... Try again later');

                    return error_response($request, $message);
                }
            }else{
                $message = __('You cannot send to yourself!');

                return error_response($request, $message);
            }

        }else{
            $message = __('Your balance is insufficient!');

            return error_response($request, $message);
        }
    }

    /**
     * Get address data
     *
     * @param Request $request
     * @param string $coin
     * @throws \Exception
     */
    public function addressData(Request $request, $coin = 'btc')
    {
        if ($request->ajax()) {
            $addresses = Auth::user()->getAddressModel($coin)
                ->latest()->get();

            return DataTables::of($addresses)
                ->editColumn('total_sent', function ($data) {
                    return base_to_coin($data->total_sent);
                })
                ->editColumn('balance', function ($data) {
                    return base_to_coin($data->balance);
                })
                ->editColumn('total_received', function ($data) {
                    return base_to_coin($data->total_received);
                })
                ->removeColumn('private', 'wif')
                ->make(true);
        } else {
            return abort(403);
        }
    }

    /**
     * Get transaction data
     *
     * @param Request $request
     * @param string $coin
     * @throws \Exception
     */
    public function transactionData(Request $request, $coin = 'btc')
    {
        if ($request->ajax()) {
            $transactions = Auth::user()->getTransactionModel($coin)
                ->latest()->get();

            return DataTables::of($transactions)
                ->addColumn('type', function ($data) {
                    if ($data->type == 'incoming') {
                        return __("Incoming");
                    } else {
                        return __("Outgoing");
                    }
                })
                ->addColumn('address', function ($data) {
                    if ($data->type == 'incoming') {
                        return $data->address->address;
                    } else {
                        return $data->output_address;
                    }
                })
                ->editColumn('received', function ($data) {
                    if ($date = Carbon::parse($data->received)) {
                        return $date->toFormattedDateString();
                    }
                })
                ->editColumn('value', function ($data) {
                    return base_to_coin($data->value);
                })
                ->make(true);
        } else {
            return abort(403);
        }
    }
}
