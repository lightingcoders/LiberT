<?php

namespace App\Http\Controllers\Services\BlockCypher;

use App\Jobs\Transactions\ProcessBitcoin;
use App\Jobs\Transactions\ProcessDash;
use App\Jobs\Transactions\ProcessDogecoin;
use App\Jobs\Transactions\ProcessLitecoin;
use App\Logic\Services\BlockCypher;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

class WebhookController extends Controller
{
    /**
     * BlockCypher instance
     *
     * @var BlockCypher
     */
    protected $blockcypher;

    /**
     * Guzzle request client
     *
     * @var Client
     */
    protected $client;

    /**
     * WebhookController constructor.
     *
     * @param BlockCypher $blockcypher
     */
    public function __construct(BlockCypher $blockcypher)
    {
        $this->blockcypher = $blockcypher;

        $this->client = new Client();
    }

    /**
     * @param Request $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handleBitcoin(Request $request)
    {
        $data = $request->all();

        $tx_data = collect($data);

        // Get all inputs
        while (isset($data['next_inputs']) && $data['next_inputs']) {
            $data = $this->request($data['next_inputs']);

            $inputs = collect($data['inputs'])
                ->push($tx_data->get('inputs'));

            $tx_data->put('inputs', $inputs->toArray());
        }

        // Get all outputs
        while (isset($data['next_outputs']) && $data['next_outputs']) {
            $data = $this->request($data['next_outputs']);

            $inputs = collect($data['outputs'])
                ->push($tx_data->get('outputs'));

            $tx_data->put('outputs', $inputs->toArray());
        }


        ProcessBitcoin::dispatch($tx_data->toArray());
    }

    /**
     * @param Request $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handleDogecoin(Request $request)
    {
        $data = $request->all();

        $tx_data = collect($data);

        // Get all inputs
        while (isset($data['next_inputs']) && $data['next_inputs']) {
            $data = $this->request($data['next_inputs']);

            $inputs = collect($data['inputs'])
                ->push($tx_data->get('inputs'));

            $tx_data->put('inputs', $inputs->toArray());
        }

        // Get all outputs
        while (isset($data['next_outputs']) && $data['next_outputs']) {
            $data = $this->request($data['next_outputs']);

            $outputs = collect($data['outputs'])
                ->push($tx_data->get('outputs'));

            $tx_data->put('outputs', $outputs->toArray());
        }


        ProcessDogecoin::dispatch($tx_data->toArray());
    }

    /**
     * @param Request $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handleDash(Request $request)
    {
        $data = $request->all();

        $tx_data = collect($data);

        // Get all inputs
        while (isset($data['next_inputs']) && $data['next_inputs']) {
            $data = $this->request($data['next_inputs']);

            $inputs = collect($data['inputs'])
                ->push($tx_data->get('inputs'));

            $tx_data->put('inputs', $inputs->toArray());
        }

        // Get all outputs
        while (isset($data['next_outputs']) && $data['next_outputs']) {
            $data = $this->request($data['next_outputs']);

            $outputs = collect($data['outputs'])
                ->push($tx_data->get('outputs'));

            $tx_data->put('outputs', $outputs->toArray());
        }


        ProcessDash::dispatch($tx_data->toArray());
    }

    /**
     * @param Request $request
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function handleLitecoin(Request $request)
    {
        $data = $request->all();

        $tx_data = collect($data);

        // Get all inputs
        while (isset($data['next_inputs']) && $data['next_inputs']) {
            $data = $this->request($data['next_inputs']);

            $inputs = collect($data['inputs'])
                ->push($tx_data->get('inputs'));

            $tx_data->put('inputs', $inputs->toArray());
        }

        // Get all outputs
        while (isset($data['next_outputs']) && $data['next_outputs']) {
            $data = $this->request($data['next_outputs']);

            $outputs = collect($data['outputs'])
                ->push($tx_data->get('outputs'));

            $tx_data->put('outputs', $outputs->toArray());
        }


        ProcessLitecoin::dispatch($tx_data->toArray());
    }

    /**
     * @param null $url
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Exception
     */
    public function request($url = null)
    {
        try {
            if ($url) {
                $response = $this->client->request(
                    'GET', $url
                );

                sleep(1);

                return json_decode($response->getBody(), true);
            }
        } catch (ClientException $e) {
            if ($e->hasResponse()) {
                $response = $e->getResponse();

                throw new \Exception(
                    $response->getBody()->getContents(),
                    $response->getStatusCode()
                );
            }
        }

        return null;
    }
}
