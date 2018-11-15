<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Coin Specific Settings
    |--------------------------------------------------------------------------
    |
    | You may define your settings like trade fee, for each coin based on your
    | interest
    |
    */

    'btc' => [
        'trade_fee' => env('SET_BTC_TRADE_FEE', 1),
        'locked_balance' => env('SET_BTC_LOCKED_BALANCE'),
    ],

    'ltc' => [
        'trade_fee' => env('SET_LTC_TRADE_FEE', 1),
        'locked_balance' => env('SET_LTC_LOCKED_BALANCE'),
    ],

    'doge' => [
        'trade_fee' => env('SET_DOGE_TRADE_FEE', 1),
        'locked_balance' => env('SET_DOGE_LOCKED_BALANCE'),
    ],

    'dash' => [
        'trade_fee' => env('SET_DASH_TRADE_FEE', 1),
        'locked_balance' => env('SET_DASH_LOCKED_BALANCE'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Currency Settings
    |--------------------------------------------------------------------------
    |
    | This sets the default currency parameters to use for processing
    | offers and trades.
    |
    */

    'default_currency' => env('SET_DEFAULT_CURRENCY', 'USD'),

    /*
   |--------------------------------------------------------------------------
   | Blockchain Settings
   |--------------------------------------------------------------------------
   |
   | You may state parameters such as the number of confirmations required to
   | update coin balance, the transaction preference which is used to determine
   | miner's fee
   |
   */
    'tx_preference' => env('SET_TX_PREFERENCE', 'medium'),

    'min_tx_confirmations' => env('SET_MIN_TX_CONFIRMATIONS', 3),

];
