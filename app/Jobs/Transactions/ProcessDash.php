<?php

namespace App\Jobs\Transactions;

use App\Logic\Classes\DashAdapter;
use App\Models\DashAddress;
use App\Models\DashTransaction;
use App\Notifications\Transactions\IncomingConfirmed;
use App\Notifications\Transactions\IncomingUnconfirmed;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class ProcessDash implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Transaction Data
     *
     * @var array
     */
    public $transaction;

    /**
     * @var
     */
    protected $settings;

    /**
     * @var DashAdapter
     */
    protected $helper;

    /**
     * Create a new job instance.
     *
     * @param $transaction
     * @return void
     */
    public function __construct($transaction)
    {
        $this->transaction = $transaction;
        $this->settings = config('settings');
    }

    /**
     * Execute the job.
     *
     * @param $adapter
     * @return void
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handle(DashAdapter $adapter)
    {
        $data = collect($this->transaction);

        // Get output addresses
        $outputs = collect($data->get('outputs'));
        $output_addresses = $outputs->pluck('addresses')
            ->flatten()->unique();

        // Get input addresses
        $inputs = collect($data->get('inputs'));
        $input_addresses = $inputs->pluck('addresses')
            ->flatten()->unique();

        // Get array of output_addresses => values
        $values = $this->getOutputValues($outputs);

        // Filter out outgoing addresses
        $outgoing = $output_addresses->diff($input_addresses);

        $this->updateInputAddresses(
            $data, $input_addresses, $adapter
        );

        // Store incoming transactions
        $this->storeTransactions($data, $outgoing, $values, $adapter);

        // Update transaction
        $this->updateTransactionIfExists($data);
    }


    /**
     * @param Collection $data
     */
    public function updateTransactionIfExists($data)
    {
        $transactions = DashTransaction::where(
            'hash', $data->get('hash')
        )->get();

        foreach ($transactions as $transaction) {
            $transaction->update($data->only([
                'fees', 'confirmations', 'preference'
            ])->toArray());
        }
    }

    /**
     * @param Collection $data
     * @param Collection $outputs
     * @param array $values
     * @param DashAdapter $adapter
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function storeTransactions($data, $outputs, $values, $adapter)
    {
        if ($outputs->count()) {
            foreach ($outputs as $output) {
                $address = DashAddress::where(
                    'address', $output
                )->first();

                if($address){
                    $transaction = $address->transactions()->where(
                        'hash', $data->get('hash')
                    )->first();

                    $confirmations = (int) $data->get('confirmations');

                    if (!$transaction) {
                        $address->transactions()->create([
                            'type' => 'incoming',
                            'preference' => $data->get('preference'),
                            'value' => $values[$output],
                            'received' => Carbon::parse($data->get('received')),
                            'fees' => $data->get('fees'),
                            'confirmations' => $data->get('confirmations'),
                            'hash' => $data->get('hash'),
                        ]);

                        if($confirmations < (int) $this->settings['min_tx_confirmations']){
                            if($user = $address->user){
                                $user->notify(new IncomingUnconfirmed(
                                    'dash', $values[$output]
                                ));
                            }
                        }
                    }else{
                        if($transaction->confirmations != $confirmations){
                            if ($confirmations >= (int) $this->settings['min_tx_confirmations']) {
                                if($user = $address->user){
                                    $user->notify(new IncomingConfirmed(
                                        'dash', $values[$output]
                                    ));
                                }

                                $this->updateBalance($output, $adapter);
                            }
                        }
                    }

                }
            }
        }
    }

    /**
     * @param string $address
     * @param DashAdapter $adapter
     * @throws
     */
    protected function updateBalance($address, $adapter)
    {
        $dash_address = DashAddress::where(
            'address', $address
        )->first();

        if($dash_address){
            $balance = collect(
                $adapter->getBalance($address)
            );

            $dash_address->update($balance->only([
                'total_sent', 'total_received', 'balance'
            ])->toArray());
        }
    }

    /**
     * @param Collection $outputs
     * @return array
     */
    protected function getOutputValues($outputs)
    {
        $values = [];

        $outputs->each(function ($output) use (&$values) {
            foreach ($output['addresses'] as $address) {
                $values[$address] = $output['value'];
            }
        });

        return $values;
    }

    protected function updateInputAddresses($data, $input_addresses, $adapter)
    {
        $confirmations = (int) $data->get('confirmations');

        if($confirmations >= 1){
            foreach ($input_addresses as $address){
                $this->updateBalance($address, $adapter);
            }
        }
    }
}
