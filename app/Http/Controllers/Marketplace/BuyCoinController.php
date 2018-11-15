<?php

namespace App\Http\Controllers\Marketplace;

use App\Models\Offer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class BuyCoinController extends Controller
{
    /**
     * Show sell offers
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('marketplace.buy_coin.index', [
            'coins' => get_coins(),
        ]);
    }

    public function data(Request $request)
    {
        if ($request->ajax()) {
            $offers = Offer::has('user')
                ->where('type', 'sell')
                ->where('status', true);

            if($request->currency){
                $offers = $offers->where('currency', $request->currency);
            }

            if($request->payment_method){
                $offers = $offers->where('payment_method', $request->payment_method);
            }

            if($request->amount){
                $offers = $offers->where('min_amount', '<=', $request->amount)
                    ->where('max_amount', '>=', $request->amount);
            }

            if($request->coin){
                $offers = $offers->where('coin', $request->coin);
            }

            // Eager load with user
            $offers = $offers->with('user')->get();

            // Verify user's balance
            $offers = $offers->filter(function ($offer, $key) {
                $user = $offer->user;

                $balance = $user->getCoinAvailable($offer->coin);

                // Check Trusted Contacts
                if (!$offer->trust(Auth::user())) { return false; }

                $available = get_price(
                    $balance, $offer->coin, $offer->currency, false
                );

                $fee = calc_fee($offer->max_amount, $offer->coin);

                return ($offer->max_amount + $fee) <= $available;
            });

            return DataTables::of($offers)
                ->addColumn('seller', function ($data) {
                    return view('marketplace.buy_coin.partials.datatable.seller')
                        ->with(compact('data'));
                })
                ->editColumn('coin', function ($data) {
                    return get_coin($data->coin);
                })
                ->editColumn('payment_method', function ($data) {
                    return view('marketplace.buy_coin.partials.datatable.payment_method')
                        ->with(compact('data'));
                })
                ->addColumn('amount_range', function ($data) {
                    $min = money($data->min_amount, $data->currency, true);
                    $max = money($data->max_amount, $data->currency, true);

                    return "<b>{$min}</b>" . ' - ' . "<b>{$max}</b>";
                })
                ->addColumn('worth', function ($data) {
                    return (100 - $data->profit_margin) . '%';
                })
                ->addColumn('coin_rate', function ($data) {
                    return get_price(
                        $data->multiplier(), $data->coin, $data->currency
                    );
                })
                ->addColumn('action', function ($data) {
                    return view('marketplace.buy_coin.partials.datatable.action')
                        ->with(compact('data'));
                })
                ->rawColumns(['coin_rate', 'action', 'amount_range', 'payment_method', 'seller'])
                ->removeColumn('user_id', 'trusted_offer')
                ->make(true);
        } else {
            return abort(404);
        }
    }
}
