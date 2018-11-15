<?php
/**
 * ======================================================================================================
 * File Name: BitcoinAdapter.php
 * ======================================================================================================
 * Author: HolluwaTosin360
 * ------------------------------------------------------------------------------------------------------
 * Portfolio: http://codecanyon.net/user/holluwatosin360
 * ------------------------------------------------------------------------------------------------------
 * Date & Time: 9/29/2018 (2:08 PM)
 * ------------------------------------------------------------------------------------------------------
 *
 * Copyright (c) 2018. This project is released under the standard of CodeCanyon License.
 * You may NOT modify/redistribute this copy of the project. We reserve the right to take legal actions
 * if any part of the license is violated. Learn more: https://codecanyon.net/licenses/standard.
 *
 * ------------------------------------------------------------------------------------------------------
 */

namespace App\Logic\Classes;


use App\Logic\Classes\Traits\Adapter;
use App\Logic\Services\BlockCypher;
use App\Models\BitcoinAddress;
use App\Models\BitcoinTransaction;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;

class BitcoinAdapter
{
    use Adapter;

    /**
     * Default wallet name
     *
     * @var string
     */
    protected $coin = 'btc';

    /**
     * BlockCypher instance
     *
     * @var array
     */
    protected $blockcypher;

    /**
     * BitcoinAdapter constructor.
     */
    public function __construct()
    {
        $this->blockcypher = new BlockCypher($this->coin);
    }

    /**
     * Update input balance
     *
     * @param $addresses
     * @param $main_address
     * @param $balance
     * @param $cost
     */
    public function updateInputBalance($addresses, $main_address, $balance, $cost)
    {
        // Set older addresses to zero balance
        $addresses->where('id', '!=', $main_address->id)
            ->each(function ($address) {
                $address->update(['balance' => 0]);
            });

        // Set the recent address to actual balance
        $main_address->update([
            'balance' => $balance - $cost
        ]);
    }

    /**
     * Update output balance
     *
     * @param $output
     * @param int $amount
     */
    public function updateOutputBalance($output, $amount = 0)
    {
        if (is_array($output)) {
            collect($output)->pluck('amount', 'address')
                ->each(function ($amount, $address) {
                    BitcoinAddress::where('address', $address)
                        ->increment('balance', $amount);
                });
        } else {
            BitcoinAddress::where('address', $output)
                ->increment('balance', $amount);
        }
    }

    /**
     * @return string
     */
    private function getWebhookUrl()
    {
        $base_url = request()->getBaseUrl();

        //TODO: Test Purpose. Please Remove before production
        if (app()->environment() === 'local') {
            URL::forceRootUrl(config('app.url'));
        }

        $webhook = route('blockcypher.hook.btc');

        //TODO: Test Purpose. Please Remove before production
        if (app()->environment() === 'local') {
            URL::forceRootUrl($base_url);
        }

        return $webhook;
    }
}
