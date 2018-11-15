<?php

namespace App\Models;

use Dirape\Token\DirapeToken;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use willvincent\Rateable\Rateable;

class Trade extends Model
{
    use DirapeToken;

    /**
     * The attributes that stores confirmation token
     *
     * @var string
     */
    protected $DT_Column = 'token';

    /**
     * Defines the token generation settings
     *
     * @var array
     */
    protected $DT_settings = [
        'type' => 'DT_UniqueStr', 'size' => 10, 'special_chr' => false
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function offer()
    {
        return $this->belongsTo('App\Models\Offer', 'offer_id', 'id');
    }

    /**
     * User who starts the trade
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * User who owns the offer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function partner()
    {
        return $this->belongsTo('App\Models\User', 'partner_id', 'id');
    }

    /**
     * Get address model
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne|null
     */
    public function getAddressModel()
    {
        $model = null;

        $coin = $this->coin;

        switch ($coin) {
            case 'btc':
            case 'bitcoin':
                $model = $this->bitcoin_address();
                break;

            case 'doge':
            case 'dogecoin':
                $model = $this->dogecoin_address();
                break;

            case 'dash':
                $model = $this->dash_address();
                break;

            case 'ltc':
            case 'litecoin':
                $model = $this->litecoin_address();
                break;
        }

        return $model;
    }

    /**
     * Grant access to view trade
     *
     * @param User $user
     * @return bool
     */
    public function grantAccess(User $user)
    {
        return $this->user->id == $user->id ||
            $this->partner->id == $user->id ||
            $user->can('resolve trade dispute');
    }

    /**
     * Determine the party of a user in a trade
     *
     * @param User $user
     * @param null $check
     * @return bool|string
     */
    public function party(User $user, $check = null)
    {
        if ($check !== null) {
            if (!is_array($check)) {
                $check = array($check);
            }

            $check = array_map('strtolower', $check);
        }

        $party = 'moderator';

        if ($this->partner->id == $user->id) {
            $party = ($this->type == 'sell') ? 'buyer' : 'seller';
        } elseif ($this->user->id == $user->id) {
            $party = ($this->type == 'sell') ? 'seller' : 'buyer';
        }

        return ($check !== null) ?
            in_array($party, $check) : $party;
    }

    /**
     * Get seller
     *
     * @return User|mixed|null
     */
    public function seller()
    {
        $model = null;

        if ($this->type == 'buy') {
            $model = $this->partner;
        } else {
            $model = $this->user;
        }

        return $model;
    }

    /**
     * Get buyer
     *
     * @return User|mixed|null
     */
    public function buyer()
    {
        $model = null;

        if ($this->type == 'buy') {
            $model = $this->user;
        } else {
            $model = $this->partner;
        }

        return $model;
    }

    /**
     * Generate wallet address
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function generateAddress()
    {
        if (!$this->getAddressModel()->first()) {
            $adapter = getBlockchainAdapter($this->coin);

            $address = collect($adapter->generateAddress());

            $this->getAddressModel()->create($address->only([
                'private', 'public', 'address', 'wif'
            ])->toArray());
        }
    }

    /**
     * Get amount involved in trade
     *
     * @param bool $format
     * @return \Akaunting\Money\Money|mixed
     */
    public function amount($format = true)
    {
        $amount = $this->amount;

        if ($format) {
            $amount = money($amount, $this->currency, true);
        }

        return $amount;
    }

    /**
     * Get coin rate
     *
     * @param bool $format
     * @return \Akaunting\Money\Money|float|mixed
     */
    public function rate($format = true)
    {
        $rate = $this->rate;

        if ($format) {
            $rate = money($rate, $this->currency, true);
        }

        return $rate;
    }

    /**
     * Determine coin value
     *
     * @return float
     */
    public function coinValue()
    {
        return round($this->amount / $this->rate, 8);
    }

    /**
     * Calculate Fee
     *
     * @return float|int
     */
    public function calcFee()
    {
        return round(calc_fee($this->coinValue(), $this->coin), 8);
    }

    /**
     * Get outputs
     *
     * @return array
     */
    public function getOutputs()
    {
        $outputs = [];

        $wallet = $this->buyer()->getAddressModel($this->coin)
            ->latest()->first();

        $outputs[] = [
            'address' => $wallet->address,
            'amount' => coin_to_base($this->coinValue())
        ];

        // Escrow
        $wallet = $this->getAddressModel()->latest()->first();

        $outputs[] = [
            'address' => $wallet->address,
            'amount' => coin_to_base($this->calcFee())
        ];

        return $outputs;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function bitcoin_address()
    {
        return $this->hasOne('App\Models\BitcoinAddress', 'trade_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dogecoin_address()
    {
        return $this->hasOne('App\Models\DogecoinAddress', 'trade_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function dash_address()
    {
        return $this->hasOne('App\Models\DashAddress', 'trade_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function litecoin_address()
    {
        return $this->hasOne('App\Models\LitecoinAddress', 'trade_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chats()
    {
        return $this->hasMany('App\Models\TradeChat', 'trade_id', 'id');
    }

    /**
     * Group chat by date
     *
     * @return \Illuminate\Database\Eloquent\Collection|mixed
     */
    public function chatsByDate()
    {
        $chats = $this->chats()->with(
            [
                'user' => function ($query) {
                    $query->select(['id', 'name', 'presence', 'last_seen']);
                },
                'user.profile' => function ($query) {
                    $query->select(['id', 'user_id', 'picture']);
                }
            ]
        )->get();

        if ($chats !== null) {
            $chats = $chats->groupBy(function ($item) {
                return $item->created_at->format('Y-m-d');
            })->map(function ($chats) {
                return $chats->reduce(function ($carry, $chat) {
                    if (count($carry) && $chat->user_id == $carry[count($carry) - 1]->user_id) {
                        $created_at = $chat->created_at;

                        $content = collect($carry[count($carry) - 1]->content)
                            ->push([
                                'content' => $chat->content,
                                'created_at' => $created_at->format('Y-m-d H:i:s'),
                                'type' => $chat->type,
                            ])
                            ->toArray();

                        $carry[count($carry) - 1]->content = $content;
                    } else {
                        $created_at = $chat->created_at;

                        $chat->content = array(
                            [
                                'content' => $chat->content,
                                'created_at' => $created_at->format('Y-m-d H:i:s'),
                                'type' => $chat->type,
                            ]
                        );

                        $carry->push($chat);
                    }
                    return $carry;
                }, collect());
            });
        }


        return $chats;
    }
}
