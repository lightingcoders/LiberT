<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LitecoinAddress extends Model
{
    use SecurityLayer;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }

    /**
     * Get transactions
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany('App\Models\LitecoinTransaction', 'address_id', 'id');
    }
}
