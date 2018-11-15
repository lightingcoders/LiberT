<?php
/**
 * ======================================================================================================
 * File Name: Adapter.php
 * ======================================================================================================
 * Author: HolluwaTosin360
 * ------------------------------------------------------------------------------------------------------
 * Portfolio: http://codecanyon.net/user/holluwatosin360
 * ------------------------------------------------------------------------------------------------------
 * Date & Time: 10/17/2018 (11:58 AM)
 * ------------------------------------------------------------------------------------------------------
 *
 * Copyright (c) 2018. This project is released under the standard of CodeCanyon License.
 * You may NOT modify/redistribute this copy of the project. We reserve the right to take legal actions
 * if any part of the license is violated. Learn more: https://codecanyon.net/licenses/standard.
 *
 * ------------------------------------------------------------------------------------------------------
 */

namespace App\Logic\Classes\Traits;


use Carbon\Carbon;
use Illuminate\Support\Collection;

trait Adapter
{
    /**
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function generateAddress()
    {
        $address = $this->blockcypher->generateAddress();

        $this->blockcypher->createWebhook(
            $address['address'], $this->getWebhookUrl()
        );

        return $address;
    }

    /**
     * @param Collection $addresses
     * @param $output
     * @param $amount
     * @return mixed
     * @throws \Exception
     */
    public function send($addresses, $output, $amount)
    {
        $balance = $addresses->sum('balance');

        // Prepare Input Addresses
        $inputs = $this->prepareInputs(
            $addresses->pluck('address')->toArray()
        );

        // Collect all pair of public and private keys
        $input_keys = [
            'public' => $addresses->pluck('public', 'address')
                ->toArray(),
            'private' => $addresses->pluck('private', 'address')
                ->toArray(),
        ];

        // Get the recent/main address.
        $main_address = $addresses->first();

        // Relay the transaction details to the blockchain
        $transaction = $this->blockcypher->createTransaction(
            $inputs, $input_keys,
            $this->prepareOutput($output, $amount),
            $main_address->address
        );

        // Determine $cost = $fees + $amount;
        $cost = ($amount >= 0) ? $transaction['fees'] + $amount : $balance;

        // Set all input address balance to zero while the main address
        // is updated with the actual balance
        $this->updateInputBalance(
            $addresses, $main_address, $balance, $cost
        );

        // Increment the balance of all output addresses if the occur on
        // the same database
        $total = ($amount >= 0)? $amount: $balance - $transaction['fees'];
        $this->updateOutputBalance($output, $total);

        // Log a transaction record for this output address
        $this->storeTransaction(
            collect($transaction), $main_address, $output, $amount
        );

        return $transaction;
    }

    /**
     * @param Collection $addresses
     * @param $outputs
     * @return mixed
     * @throws \Exception
     */
    public function sendMultiple($addresses, $outputs)
    {
        $balance = $addresses->sum('balance');

        // Prepare Inputs
        $inputs = $this->prepareInputs(
            $addresses->pluck('address')->toArray()
        );

        // Collect all pair of public and private keys
        $input_keys = array(
            'public' => $addresses->pluck('public', 'address')
                ->toArray(),
            'private' => $addresses->pluck('private', 'address')
                ->toArray(),
        );

        // Get the recent/main address.
        $main_address = $addresses->first();

        // Relay the transaction details to the blockchain
        $transaction = $this->blockcypher->createTransaction(
            $inputs, $input_keys,
            $this->prepareOutput($outputs),
            $main_address->address
        );

        // Determine $cost = $fees + $amount;
        $amount = collect($outputs)->sum('amount');

        // Determine $cost = $fees + $amount;
        $cost = $transaction['fees'] + $amount;

        // Set all input address balance to zero while the main address
        // is updated with the actual balance
        $this->updateInputBalance(
            $addresses, $main_address, $balance, $cost
        );

        // Increment the balance of all output addresses if the occur on
        // the same database
        $this->updateOutputBalance($outputs);

        // Log a transaction record for all the output addresses
        foreach ($outputs as $output) {
            $this->storeTransaction(
                collect($transaction), $main_address,
                $output['address'], $output['amount']
            );
        }

        return $transaction;
    }

    /**
     * @param $addresses
     * @return array
     */
    public function prepareInputs($addresses)
    {
        $inputs = array();

        foreach ($addresses as $address) {
            $inputs[] = [
                'addresses' => array($address)
            ];
        }

        return $inputs;
    }


    /**
     * @param Collection $data
     * @param mixed $address
     * @param string $output
     * @param integer|float $value
     * @return
     */
    protected function storeTransaction($data, $address, $output, $value)
    {
        return $address->transactions()->create([
            'type' => 'outgoing',
            'preference' => $data->get('preference'),
            'output_address' => $output,
            'received' => Carbon::now(),
            'fees' => $data->get('fees'),
            'confirmations' => $data->get('confirmations'),
            'hash' => $data->get('hash'),
            'value' => $value,
        ]);
    }


    /**
     * @param $outputs
     * @param $amount
     * @return array
     */
    public function prepareOutput($outputs, $amount = 0)
    {
        $output = array();

        if (!is_array($outputs)) {
            $output[] = [
                'addresses' => array($outputs),
                'value' => $amount
            ];
        } else {
            foreach ($outputs as $out) {
                $output[] = [
                    'addresses' => array($out['address']),
                    'value' => $out['amount']
                ];
            }
        }

        return $output;
    }


    /**
     * @param $address
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBalance($address)
    {
        return $this->blockcypher->getBalance($address);
    }
}
