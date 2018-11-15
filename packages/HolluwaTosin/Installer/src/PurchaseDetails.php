<?php

namespace HolluwaTosin\Installer;

use Carbon\Carbon;

class PurchaseDetails
{
    /**
     * Name of Item..
     *
     * @var string
     */
    protected $item_name;

    /**
     * Item ID
     *
     * @var string
     */
    protected $item_id;

    /**
     * Purchase Date
     *
     * @var Carbon
     */
    protected $created_at;

    /**
     * Buyer's name
     *
     * @var string
     */
    protected $buyer;

    /**
     * Type of license
     *
     * @var string
     */
    protected $license;

    /**
     * PurchaseDetails constructor.
     * @param $license_details
     */
    public function __construct($license_details)
    {
        if($license_details = json_decode($license_details)){
            $this->item_name = $license_details->item_name;
            $this->item_id = $license_details->item_id;
            $this->created_at = $license_details->created_at;
            $this->buyer = $license_details->buyer;
            $this->license = $license_details->licence;
        }
    }

    /**
     * Get Item Name
     *
     * @return string
     */
    public function getItemName()
    {
        return $this->item_name;
    }

    /**
     * Get Item ID
     *
     * @return int
     */
    public function getItemId()
    {
        return (int) $this->item_id;
    }

    /**
     * Get purchase date
     *
     * @return Carbon
     */
    public function getPurchaseDate()
    {
        return Carbon::parse($this->created_at);
    }

    /**
     * Get buyer name
     *
     * @return string
     */
    public function getBuyer()
    {
        return $this->buyer;
    }

    /**
     * Get license object
     *
     * @return string
     */
    public function getLicense()
    {
        return $this->license;
    }

    /**
     * Check if licence is Extended
     *
     * @return bool
     */
    public function isExtendedLicense()
    {
        return ($this->license == 'Extended License');
    }

    /**
     * Check if licence is Regular
     *
     * @return bool
     */
    public function isRegularLicense()
    {
        return ($this->license == 'Regular License');
    }
}
