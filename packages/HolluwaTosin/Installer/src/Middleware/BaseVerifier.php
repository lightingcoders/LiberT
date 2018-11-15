<?php
/**
 * ======================================================================================================
 * File Name: BaseVerifier.php
 * ======================================================================================================
 * Author: HolluwaTosin360
 * ------------------------------------------------------------------------------------------------------
 * Portfolio: http://codecanyon.net/user/holluwatosin360
 * ------------------------------------------------------------------------------------------------------
 * Date & Time: 10/20/2018 (10:17 PM)
 * ------------------------------------------------------------------------------------------------------
 *
 * Copyright (c) 2018. This project is released under the standard of CodeCanyon License.
 * You may NOT modify/redistribute this copy of the project. We reserve the right to take legal actions
 * if any part of the license is violated. Learn more: https://codecanyon.net/licenses/standard.
 *
 * ------------------------------------------------------------------------------------------------------
 */

namespace HolluwaTosin\Installer\Middleware;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\URL;

class BaseVerifier
{
    /**
     * Guzzle client instance
     *
     * @var Client
     */
    protected $client;

    /**
     * Validation server's API End point
     *
     * @var \Illuminate\Config\Repository|mixed
     */
    protected $endpoint;

    /**
     * Access Token for validation on the server
     *
     * @var \Illuminate\Config\Repository|mixed
     */
    protected $accessToken;

    /**
     * The current base url
     *
     * @var string
     */
    protected $baseUrl;

    /**
     * The key used to store verification code in
     * the cache system
     *
     * @var string
     */
    public $prefix = 'verification.';

    /**
     * BaseVerifier constructor.
     *
     */
    public function __construct()
    {
        $this->baseUrl = URL::to('/');
        $this->accessToken = config('installer.access_token');
        $this->endpoint = config('installer.license_endpoint');

        $this->client = new Client([
            'headers' => ['Referer' => $this->baseUrl]
        ]);
    }

    /**
     * Prepare the options for api requests
     *
     * @param $verificationCode
     * @param bool $query
     * @return array
     */
    public function options($verificationCode, $query = false)
    {
        $key = ($query) ? 'query' :
            'form_params';

        $options = [
            $key => [
                'access_token' => $this->accessToken,
                'verification_code' => $verificationCode,
                'url' => $this->baseUrl,
            ]
        ];

        return $options;
    }

    /**
     * Prepare error message
     *
     * @param $response
     * @return array
     */
    public function errorMessage($response)
    {
        $status_code = $response->getStatusCode();

        if ($status_code == 400) {
            return ['error' => $status_code, 'message' => __('An unexpected error occurred! Please contact the author of this script')];
        } elseif ($status_code == 401) {
            return ['error' => $status_code, 'message' => __('Your verification code seems to be invalid. Please try again!')];
        } elseif ($status_code == 404) {
            return ['error' => $status_code, 'message' => __('An unexpected error occurred! Your license details could not be found!')];
        } elseif ($status_code == 403) {
            return ['error' => $status_code, 'message' => __('Your license verification code is already registered with another domain.')];
        }

        return ['error' => $status_code, 'message' => __('Opps! Something went wrong!')];
    }
}
