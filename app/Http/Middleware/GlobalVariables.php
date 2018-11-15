<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class GlobalVariables
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $this->shareViewData();
        return $next($request);
    }

    /**
     * Share important view data
     */
    public function shareViewData()
    {
        View::share([
            'wallet' => [
                'btc' => $this->getWalletData('btc'),
                'dash' => $this->getWalletData('dash'),
                'ltc' => $this->getWalletData('ltc'),
            ],
        ]);
    }

    /**
     * Get wallet data
     *
     * @param string $coin
     * @return array|null
     */
    public function getWalletData($coin = 'btc')
    {
        $address = Auth::user()->getAddressModel($coin)
            ->latest()->first();

        $available = Auth::user()->getCoinAvailable($coin);
        $balance = Auth::user()->getCoinBalance($coin);

        $details = [
            'total_available' => $available,
            'total_available_price' => get_price(
                $available, $coin, Auth::user()->currency
            ),

            'total_balance' => $balance,
            'total_balance_price' => get_price(
                $balance, $coin, Auth::user()->currency
            ),
        ];

        if ($address !== null) {
            $details = array_merge([
                'latest_address_qr_code' => get_qr_code(
                    $address->address, 200, 200
                ),
                'latest_address' => $address->address
            ], $details);
        }

        return $details;
    }
}
