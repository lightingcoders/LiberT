<?php

namespace App\Models;

use App\Notifications\Verification\EmailVerification;
use Dirape\Token\DirapeToken;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;
use Lunaweb\EmailVerification\Traits\CanVerifyEmail;
use Lunaweb\EmailVerification\Contracts\CanVerifyEmail as CanVerifyEmailContract;
use Spatie\Permission\Traits\HasRoles;
use willvincent\Rateable\Rateable;
use willvincent\Rateable\Rating;

class User extends Authenticatable implements CanVerifyEmailContract
{
    use Notifiable, CanVerifyEmail, HasRoles, SoftDeletes, DirapeToken, Rateable;

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
        'type' => 'RandomNumber', 'size' => 6, 'special_chr' => false
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'phone', 'timezone', 'verified', 'verified_phone', 'currency'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token'
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    /**
     * Send the email verification notification.
     *
     * @param  string $token The verification mail reset token.
     * @param  int $expiration The verification mail expiration date.
     * @return void
     */
    public function sendEmailVerificationNotification($token, $expiration)
    {
        $this->notify(new EmailVerification($token, $expiration));
    }

    /**
     * Determine priority among user roles
     *
     * @return mixed
     */
    public function priority()
    {
        return $this->roles()->orderBy('priority', 'desc')->first()->priority;
    }

    /**
     * Get all contacts saved by the instance
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function contacts()
    {
        return $this->belongsToMany('App\Models\User', 'user_contact', 'user_id', 'contact_id')
            ->withPivot('state');
    }

    /**
     * Get all users who saved the instance as a contact
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany('App\Models\User', 'user_contact', 'contact_id', 'user_id')
            ->withPivot('state');
    }

    /**
     * Get wallet balance
     *
     * @param string $coin
     * @return mixed
     */
    public function getCoinBalance($coin = 'btc')
    {
        $balance = $this->getAddressModel($coin)
            ->latest()->where('balance', '>', 0)
            ->sum('balance');

        return base_to_coin($balance);
    }

    /**
     * Get wallet balance
     *
     * @param string $coin
     * @return mixed
     */
    public function getCoinAvailable($coin = 'btc')
    {
        $balance = $this->getCoinBalance($coin);

        Trade::where('coin', $coin)
            ->whereIn('status', ['active', 'dispute'])
            ->has('user')->has('partner')
            ->where(function ($query) {
                $query->where([
                    ['type', '=', 'buy'], ['partner_id', '=', $this->id],
                ])->orWhere([
                    ['type', '=', 'sell'], ['user_id', '=', $this->id],
                ]);
            })->get()->each(function ($trade) use (&$escrow) {
                $escrow += $trade->coinValue() + $trade->calcFee();
            });

        $available = ($balance - $escrow);

        $locked = config()->get('settings.' . $coin . '.locked_balance');

        return ($available > 0 && $available > $locked) ?
            ($available - $locked) : $available;
    }

    /**
     * Get user's profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne('App\Models\Profile', 'user_id', 'id');
    }

    /**
     * Return profile avatar
     *
     * @return mixed|null|string
     */
    public function profile_avatar()
    {
        $link = asset('images/objects/default-avatar.png');

        if ($this->profile && $this->profile->picture) {
            $link = $this->profile->picture;
        }

        return $link;
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function offers()
    {
        return $this->hasMany('App\Models\Offer', 'user_id', 'id');
    }

    /**
     * Ger profile or create new
     *
     * @return Profile
     */
    public function getProfile()
    {
        if (!$this->profile) {
            $profile = new Profile();
        } else {
            $profile = $this->profile;
        }

        return $profile;
    }

    /**
     * Get notification settings
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notification_settings()
    {
        return $this->hasMany('App\Models\NotificationSetting', 'user_id', 'id');
    }

    /**
     * Get notification settings or create new
     *
     * @return mixed
     */
    public function getNotificationSettings()
    {
        $settings = $this->notification_settings()->get();

        if (!$settings->count()) {
            $default = config('notifications.settings.default');

            $settings = $this->notification_settings()->createMany($default);
        }

        return $settings;
    }

    /**
     * Get address model
     *
     * @param string $coin
     * @return \Illuminate\Database\Eloquent\Relations\HasMany|null
     */
    public function getAddressModel($coin = 'btc')
    {
        $model = null;

        switch ($coin) {
            case 'btc':
            case 'bitcoin':
                $model = $this->bitcoin_addresses();
                break;

            case 'doge':
            case 'dogecoin':
                $model = $this->dogecoin_addresses();
                break;

            case 'dash':
                $model = $this->dash_addresses();
                break;

            case 'ltc':
            case 'litecoin':
                $model = $this->litecoin_addresses();
                break;
        }

        return $model;
    }

    /**
     * Get transaction model
     *
     * @param string $coin
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough|null
     */
    public function getTransactionModel($coin = 'btc')
    {
        $model = null;

        switch ($coin) {
            case 'btc':
            case 'bitcoin':
                $model = $this->bitcoin_transactions();
                break;

            case 'doge':
            case 'dogecoin':
                $model = $this->dogecoin_transactions();
                break;

            case 'dash':
                $model = $this->dash_transactions();
                break;

            case 'ltc':
            case 'litecoin':
                $model = $this->litecoin_transactions();
                break;
        }

        return $model;
    }

    /**
     * Get settings
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function setting()
    {
        return $this->hasOne('App\Models\UserSetting', 'user_id', 'id');
    }

    /**
     * Get user setting or create new
     *
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Relations\HasOne|null|object
     */
    public function getSetting()
    {
        $setting = $this->setting()->first();

        if (!$setting) {
            $setting = $this->setting()->create();
        }

        return $setting;
    }

    /**
     * Route notifications for the Nexmo channel.
     *
     * @param  \Illuminate\Notifications\Notification $notification
     * @return string
     */
    public function routeNotificationForNexmo($notification)
    {
        return preg_replace('/\D+/', '', $this->phone);
    }

    /**
     * Route notifications for the AfricasTalking channel.
     *
     * @param  \Illuminate\Notifications\Notification $notification
     * @return string
     */
    public function routeNotificationForSms($notification)
    {
        return $this->phone;
    }

    /**
     * Generate expiring token for user
     *
     * @param int $minutes
     * @return mixed
     * @throws \Exception
     */
    public function generateToken($minutes = 5)
    {
        $token = $this->token;

        if ($this->token_expiry <= now()) {
            $this->setToken();
            $this->token_expiry = now()->addMinutes($minutes);
            $this->save();
        }

        return $token;
    }

    /**
     * Get Moderation Activities
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function moderation_activities()
    {
        return $this->hasMany('App\Models\ModerationActivity', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bitcoin_addresses()
    {
        return $this->hasMany('App\Models\BitcoinAddress', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function bitcoin_transactions()
    {
        return $this->hasManyThrough(
            'App\Models\BitcoinTransaction',
            'App\Models\BitcoinAddress',
            'user_id', 'address_id',
            'id', 'id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function litecoin_addresses()
    {
        return $this->hasMany('App\Models\LitecoinAddress', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function litecoin_transactions()
    {
        return $this->hasManyThrough(
            'App\Models\LitecoinTransaction',
            'App\Models\LitecoinAddress',
            'user_id', 'address_id',
            'id', 'id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function ethereum_addresses()
    {
        return $this->hasMany('App\Models\EthereumAddress', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function ethereum_transactions()
    {
        return $this->hasManyThrough(
            'App\Models\EthereumTransaction',
            'App\Models\EthereumAddress',
            'user_id', 'address_id',
            'id', 'id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dogecoin_addresses()
    {
        return $this->hasMany('App\Models\DogecoinAddress', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function dogecoin_transactions()
    {
        return $this->hasManyThrough(
            'App\Models\DogecoinTransaction',
            'App\Models\DogecoinAddress',
            'user_id', 'address_id',
            'id', 'id'
        );
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function dash_addresses()
    {
        return $this->hasMany('App\Models\DashAddress', 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function dash_transactions()
    {
        return $this->hasManyThrough(
            'App\Models\DashTransaction',
            'App\Models\DashAddress',
            'user_id', 'address_id',
            'id', 'id'
        );
    }

    /**
     * Show all trades initiated by user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function trades()
    {
        return $this->hasMany('App\Models\Trade', 'user_id', 'id');
    }


    /**
     * Count all successful trades
     *
     * @return int
     */
    public function countSuccessfulTrades()
    {
        return Trade::where('status', 'successful')
            ->has('user')->has('partner')
            ->where(function ($query) {
                $query->where('user_id', $this->id);
                $query->orWhere('partner_id', $this->id);
            })->count();
    }
}
