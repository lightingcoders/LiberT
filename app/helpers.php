<?php
/**
 * ======================================================================================================
 * File Name: helpers.php
 * ======================================================================================================
 * Author: HolluwaTosin360
 * ------------------------------------------------------------------------------------------------------
 * Portfolio: http://codecanyon.net/user/holluwatosin360
 * ------------------------------------------------------------------------------------------------------
 * Date & Time: 8/21/2018 (6:41 PM)
 * ------------------------------------------------------------------------------------------------------
 *
 * Copyright (c) 2018. This project is released under the standard of CodeCanyon License.
 * You may NOT modify/redistribute this copy of the project. We reserve the right to take legal actions
 * if any part of the license is violated. Learn more: https://codecanyon.net/licenses/standard.
 *
 * ------------------------------------------------------------------------------------------------------
 */

use Akaunting\Money\Currency;
use App\Models\EmailComponent;

if (!function_exists('getLocale')) {
    /**
     * @return string
     */
    function getLocale()
    {
        return str_replace('_', '-', app()->getLocale());
    }
}

if (!function_exists('removeSnakeCase')) {
    /**
     * @param string $name
     * @return string
     */
    function removeSnakeCase($name)
    {
        return ucwords(str_replace('_', ' ', $name));
    }
}

if (!function_exists('updateUrlQuery')) {
    /**
     * @param \Illuminate\Http\Request $request
     * @param array $query
     * @return mixed
     */
    function updateUrlQuery($request, $query)
    {
        $newQueries = array_merge($request->query(), $query);

        return $request->fullUrlWithQuery($newQueries);
    }
}

if (!function_exists('get_coins')) {
    /**
     * @return mixed
     */
    function get_coins()
    {
        return [
            'btc' => 'Bitcoin',
            'dash' => 'Dash',
            'ltc' => 'Litecoin',
        ];
    }
}

if (!function_exists('get_tx_preferences')) {
    /**
     * @return mixed
     */
    function get_tx_preferences()
    {
        return [
            'low' => 'Low',
            'medium' => 'Medium',
            'high' => 'High',
        ];
    }
}


if (!function_exists('displayUserRole')) {
    /**
     * @param $roles
     * @return string
     */
    function displayUserRoles($roles)
    {
        $html = "";

        foreach ($roles as $role) {
            switch ($role) {
                case 'admin':
                    $label = 'danger';
                    break;
                case 'super_moderator':
                    $label = 'warning';
                    break;
                case 'moderator':
                    $label = 'secondary';
                    break;
                default:
                    $label = 'primary';
                    break;
            }

            $html .= "<span class='badge badge-{$label}'>";
            $html .= removeSnakeCase($role);
            $html .= "</span> ";
        }

        return $html;
    }
}

if (!function_exists('getProfileAvatar')) {
    /**
     * @param \App\Models\User|null $user
     * @return string
     */
    function getProfileAvatar($user = null)
    {
        $link = asset('images/objects/default-avatar.png');

        if ($user->profile && $user->profile->picture) {
            $link = $user->profile->picture;
        }

        return $link;
    }
}

if (!function_exists('getAvatarPath')) {
    /**
     * @param $user
     * @param $name
     * @return string
     */
    function getAvatarPath($user, $name)
    {
        return storage_path("users/{$user->id}/picture/{$name}");
    }
}


if (!function_exists('getPresenceClass')) {
    /**
     * @param \App\Models\User|null $user
     * @return string
     */
    function getPresenceClass($user = null)
    {

        switch ($user->presence) {
            case 'online':
                $class = 'avatar-online';
                break;
            case 'away':
                $class = 'avatar-away';
                break;
            default:
                $class = 'avatar-off';

        }

        return $class;
    }
}

if (!function_exists('get_php_timezones')) {
    /**
     * @return array
     */
    function get_php_timezones()
    {
        $timezones = DateTimeZone::ALL;

        $identifier = DateTimeZone::listIdentifiers($timezones);

        return array_combine($identifier, $identifier);
    }
}


if (!function_exists('getSmsChannel')) {
    /**
     * @return mixed
     */
    function getSmsChannel()
    {
        $provider = config()->get('notifications.defaults.sms');

        return config()->get('notifications.sms')[$provider]['channel'];
    }
}

if (!function_exists('errorResponse')) {

    /**
     * @param \Illuminate\Http\Request $request
     * @param $message
     * @param int $status
     * @param string $ajax_type
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    function error_response($request, $message, $status = 403, $ajax_type = 'json')
    {
        $response = redirect()->back();

        if (!$request->ajax()) {
            toastr()->error($message);
        } else {
            switch ($ajax_type) {
                case 'json':
                    $response = response()->json($message, $status);
                    break;
                default:
                    $response = response($message, $status);
                    break;
            }
        }

        return $response;
    }
}

if (!function_exists('successResponse')) {

    /**
     * @param \Illuminate\Http\Request $request
     * @param $message
     * @param int $status
     * @param string $ajax_type
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    function success_response($request, $message, $status = 200, $ajax_type = 'json')
    {
        $response = redirect()->back();

        if (!$request->ajax()) {
            toastr()->success($message);
        } else {
            switch ($ajax_type) {
                case 'json':
                    $response = response()->json($message, $status);
                    break;
                default:
                    $response = response($message, $status);
                    break;
            }
        }

        return $response;
    }
}


if (!function_exists('get_mail_drivers')) {
    /**
     * @return array
     */
    function get_mail_drivers()
    {
        return [
            "smtp" => 'SMTP',
            "sendmail" => 'Sendmail',
            "mailgun" => 'Mailgun',
            "sparkpost" => 'SparkPost',
            "ses" => 'Amazon SES'
        ];
    }
}

if (!function_exists('get_sms_providers')) {
    /**
     * @return array
     */
    function get_sms_providers()
    {
        return [
            "nexmo" => 'Nexmo',
            "africastalking" => 'AfricasTalking'
        ];
    }
}

if (!function_exists('get_broadcast_drivers')) {
    /**
     * @return array
     */
    function get_broadcast_drivers()
    {
        return [
            "redis" => 'Redis',
            "pusher" => 'Pusher'
        ];
    }
}

if (!function_exists('emailComponent')) {
    /**
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Model
     */
    function emailComponent($name = 'default')
    {
        return EmailComponent::firstOrCreate([
            'name' => $name
        ], []);
    }
}

if (!function_exists('base_to_coin')) {
    /**
     * @param $number
     * @return float|int
     */
    function base_to_coin($number)
    {
        $value = $number / pow(10, 8);

        return sprintf('%f', $value);
    }
}

if (!function_exists('coin_to_base')) {
    /**
     * @param $number
     * @return float|int
     */
    function coin_to_base($number)
    {
        return round($number * pow(10, 8));
    }
}

if (!function_exists('get_prices')) {
    /**
     * @return array
     */
    function get_prices()
    {
        if (!Cache::has('coin.prices')) {
            $coins = collect(get_coins())->keys()->transform(function ($value) {
                return strtoupper($value);
            })->implode(',');

            $prices = [];

            $currencies = collect(Currency::getCurrencies())->mapWithKeys(function ($value, $key) {
                return [$key => $value['name']];
            })->sort()->keys()->transform(function ($value) {
                return strtoupper($value);
            });

            $currencies->chunk(25)->each(function ($value) use ($coins, &$prices) {
                $currencies = $value->implode(',');

                $response = file_get_contents("https://min-api.cryptocompare.com/data/pricemulti?fsyms={$coins}&tsyms={$currencies}");

                $prices = array_merge_recursive($prices, json_decode($response, true));
            });

            // TODO: Remove before release
            if (app()->environment() === 'local') {
                Cache::put('coin.prices', $prices, now()->addMinutes(60 * 24));
            } else {
                Cache::put('coin.prices', $prices, now()->addSeconds(10));
            }
        } else {
            $prices = Cache::get('coin.prices');
        }

        return $prices;
    }
}

if (!function_exists('get_price')) {
    /**
     * @param $amount
     * @param $coin
     * @param string $currency
     * @return \Akaunting\Money\Money
     */
    function get_price($amount, $coin, $currency = 'USD', $format = true)
    {
        $prices = get_prices();

        $multiplier = $prices[strtoupper($coin)][strtoupper($currency)];

        $price = $amount * $multiplier;

        if ($format) {
            $price = money($price, $currency, true);
        }

        return $price;
    }
}


if (!function_exists('get_coin')) {
    /**
     * @param string $coin
     * @return mixed
     */
    function get_coin($coin = 'btc')
    {
        $coins = get_coins();

        return $coins[$coin];
    }
}


if (!function_exists('get_iso_currencies')) {
    /**
     * @return array
     */
    function get_iso_currencies()
    {
        $accepted = collect(get_prices())->collapse()
            ->keys()->all();

        $currency = collect(Currency::getCurrencies())->mapWithKeys(function ($value, $key) {
            return [$key => $value['name']];
        })->filter(function ($value, $key) use ($accepted) {
            return in_array($key, $accepted);
        });

        return $currency->sort()->all();
    }
}

if (!function_exists('get_qr_code')) {
    /**
     * @param $text
     * @param int $width
     * @param int $height
     * @return string
     */
    function get_qr_code($text, $width = 200, $height = 200)
    {
        return "https://chart.googleapis.com/chart?cht=qr&chs={$width}x{$height}&chld=M|0&chl={$text}";
    }
}


if (!function_exists('getBlockchainAdapter')) {
    /**
     * @param string $coin
     * @return mixed
     */
    function getBlockchainAdapter($coin = 'btc')
    {
        $adapter = null;

        switch ($coin) {
            case 'btc':
            case 'bitcoin':
                $adapter = new \App\Logic\Classes\BitcoinAdapter();
                break;

            case 'doge':
            case 'dogecoin':
                $adapter = new \App\Logic\Classes\DogecoinAdapter();
                break;

            case 'dash':
                $adapter = new \App\Logic\Classes\DashAdapter();
                break;

            case 'ltc':
            case 'litecoin':
                $adapter = new \App\Logic\Classes\LitecoinAdapter();
                break;
        }

        return $adapter;
    }
}

if (!function_exists('getAddressModel')) {
    /**
     * @param string $coin
     * @return mixed
     */
    function getAddressModel($coin = 'btc')
    {
        $model = null;

        switch ($coin) {
            case 'btc':
            case 'bitcoin':
                $model = \App\Models\BitcoinAddress::whereNull('user_id');
                break;

            case 'doge':
            case 'dogecoin':
                $model = \App\Models\DogecoinAddress::whereNull('user_id');
                break;

            case 'dash':
                $model = \App\Models\DashAddress::whereNull('user_id');
                break;

            case 'ltc':
            case 'litecoin':
                $model = \App\Models\LitecoinAddress::whereNull('user_id');
                break;
        }

        return $model;
    }
}

if (!function_exists('get_tags')) {
    /**
     * @return \Illuminate\Support\Collection
     */
    function get_tags()
    {
        return \App\Models\Tag::all()->pluck('name', 'name');
    }
}

if (!function_exists('get_payment_methods')) {
    /**
     * @return array
     */
    function get_payment_methods()
    {
        $payment_methods = array();

        $categories = \App\Models\PaymentMethodCategory::all();

        foreach ($categories as $category) {
            $payment_methods[$category->name] = $category->payment_methods()
                ->get()->pluck('name', 'name');
        }

        return $payment_methods;
    }
}

if (!function_exists('share_link')) {
    /**
     * @param $type
     * @param $url
     * @param $text
     * @return string
     */
    function share_link($type, $url, $text)
    {
        $link = '#';

        $text = urlencode($text);

        switch ($type) {
            case 'facebook':
                $link = "http://www.facebook.com/sharer/sharer.php?u={$url}";
                break;

            case 'linkedin':
                $link = "https://www.linkedin.com/shareArticle?mini=true&url={$url}&title={$text}";
                break;

            case 'twitter':
                $link = "http://twitter.com/share?url={$url}&text={$text}";
                break;
        }


        return $link;
    }
}


if (!function_exists('get_trade_fee')) {
    /**
     * Get trading fee
     *
     * @param $coin
     * @return mixed
     */
    function get_trade_fee($coin = 'btc')
    {
        return config()->get('settings.' . strtolower($coin) . '.trade_fee', 1);
    }
}

if (!function_exists('calc_fee')) {

    /**
     * Calculate trading fee
     *
     * @param $amount
     * @param string $coin
     * @return float|int
     */
    function calc_fee($amount, $coin = 'btc')
    {
        $trade_fee = get_trade_fee($coin);

        return ($trade_fee * $amount) / 100;
    }
}


