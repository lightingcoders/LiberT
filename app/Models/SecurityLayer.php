<?php
/**
 * ======================================================================================================
 * File Name: AddressSecurityLayer.php
 * ======================================================================================================
 * Author: HolluwaTosin360
 * ------------------------------------------------------------------------------------------------------
 * Portfolio: http://codecanyon.net/user/holluwatosin360
 * ------------------------------------------------------------------------------------------------------
 * Date & Time: 10/19/2018 (1:56 PM)
 * ------------------------------------------------------------------------------------------------------
 *
 * Copyright (c) 2018. This project is released under the standard of CodeCanyon License.
 * You may NOT modify/redistribute this copy of the project. We reserve the right to take legal actions
 * if any part of the license is violated. Learn more: https://codecanyon.net/licenses/standard.
 *
 * ------------------------------------------------------------------------------------------------------
 */

namespace App\Models;


trait SecurityLayer
{

    /**
     * Set public attribute
     *
     * @param $value
     */
    public function setPublicAttribute($value)
    {
        $this->attributes['public'] = encrypt($value);
    }

    /**
     * Get public attribute
     *
     * @param $value
     * @return mixed
     */
    public function getPublicAttribute($value)
    {
        return decrypt($value);
    }

    /**
     * Set private attribute
     *
     * @param $value
     */
    public function setPrivateAttribute($value)
    {
        $this->attributes['private'] = encrypt($value);
    }

    /**
     * Get private attribute
     *
     * @param $value
     * @return mixed
     */
    public function getPrivateAttribute($value)
    {
        return decrypt($value);
    }

    /**
     * Set wif attribute
     *
     * @param $value
     */
    public function setWifAttribute($value)
    {
        $this->attributes['wif'] = encrypt($value);
    }

    /**
     * Get wif attribute
     *
     * @param $value
     * @return mixed
     */
    public function getWifAttribute($value)
    {
        return decrypt($value);
    }
}
