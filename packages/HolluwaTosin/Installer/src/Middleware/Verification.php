<?php
/**
 * ======================================================================================================
 * File Name: Verification.php
 * ======================================================================================================
 * Author: HolluwaTosin360
 * ------------------------------------------------------------------------------------------------------
 * Portfolio: http://codecanyon.net/user/holluwatosin360
 * ------------------------------------------------------------------------------------------------------
 * Date & Time: 10/20/2018 (10:15 PM)
 * ------------------------------------------------------------------------------------------------------
 *
 * Copyright (c) 2018. This project is released under the standard of CodeCanyon License.
 * You may NOT modify/redistribute this copy of the project. We reserve the right to take legal actions
 * if any part of the license is violated. Learn more: https://codecanyon.net/licenses/standard.
 *
 * ------------------------------------------------------------------------------------------------------
 */

namespace HolluwaTosin\Installer\Middleware;

use Closure;
use GuzzleHttp\Exception\ClientException;
use HolluwaTosin\Installer\PurchaseDetails;
use Illuminate\Cache\Repository as Cache;
use Illuminate\Support\Facades\File;

class Verification extends BaseVerifier
{
    /**
     * The URIs that should be excluded from License verification.
     * This is necessary for Install & Verify Routes.
     *
     * @var array
     */
    protected $except = [
        'install*', 'verify*',
    ];

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * Verification constructor.
     *
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        parent::__construct();

        $this->cache = $cache;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param   string|null
     * @return mixed
     */
    public function handle($request, Closure $next, $type = null)
    {
        if (!$this->inExceptArray($request)) {
            if (!$this->installed()) {
                return redirect()->route('Installer::overview.index');
            } elseif ($code = $this->getVerificationCode()) {

                $details = $this->details($code);

                if (!is_object($details)) {

                    if (is_array($details) && isset($details['error'])) {
                        return redirect()->route('Installer::overview.index')
                            ->with('message', ['content' => $details['message']]);
                    } else {
                        return redirect()->route('Installer::verify.index');
                    }

                }

                if ($type !== null) {
                    if (!$this->checkLicense($details, $type)) {
                        return abort(403);
                    }
                }


                view()->share(['purchaseDetails' => $details]);

            } else {
                return redirect()->route('Installer::verify.index');
            }
        }

        return $next($request);
    }

    /**
     * Validate middleware license
     *
     * @param PurchaseDetails $details
     * @param $type
     * @return bool
     */
    public function checkLicense(PurchaseDetails $details, $type)
    {
        return ($details->isRegularLicense() && $type == 'regular')
            || ($details->isExtendedLicense() && $type == 'extended');
    }

    /**
     * Check if script not installed
     *
     * @return bool
     */
    public function installed()
    {
        return CanInstall::installed();
    }

    /**
     * Check the details of a licenses
     *
     * @param $verificationCode
     * @return array|PurchaseDetails
     */
    public function details($verificationCode)
    {
        if (!$this->cache->has($this->prefix . 'purchaseDetails')) {
            try {
                $response = $this->client->get(
                    $this->endpoint, $this->options($verificationCode, true)
                );

                $statusCode = $response->getStatusCode();

                if ($statusCode == 200) {
                    $licenseDetails = (string)$response->getBody();

                    $this->cache->put(
                        $this->prefix . 'purchaseDetails', $licenseDetails, now()->addDay()
                    );

                    return new PurchaseDetails($licenseDetails);
                } else {
                    return $this->errorMessage($response);
                }
            } catch (ClientException $e) {
                return $this->errorMessage($e->getResponse());
            }
        } else {
            $licenseDetails = $this->cache->get($this->prefix . 'purchaseDetails');

            return new PurchaseDetails($licenseDetails);
        }
    }

    /**
     * Register a license
     *
     * @param $verificationCode
     * @return array|PurchaseDetails
     */
    public function register($verificationCode)
    {
        if (!$this->cache->has($this->prefix . 'purchaseDetails')) {
            try {
                $response = $this->client->post(
                    $this->endpoint, $this->options($verificationCode)
                );

                $statusCode = $response->getStatusCode();

                if ($statusCode == 200) {
                    $licenseDetails = (string)$response->getBody();

                    $this->cache->put(
                        $this->prefix . 'purchaseDetails', $licenseDetails, now()->addDay()
                    );

                    return new PurchaseDetails($licenseDetails);
                } else {
                    return $this->errorMessage($response);
                }
            } catch (ClientException $e) {
                return $this->errorMessage($e->getResponse());
            }
        } else {
            $licenseDetails = $this->cache->get($this->prefix . 'purchaseDetails');

            return new PurchaseDetails($licenseDetails);
        }
    }

    /**
     * Determine if the request has a URI that should be excluded.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function inExceptArray($request)
    {
        foreach ($this->except as $except) {
            if ($except !== '/') {
                $except = trim($except, '/');
            }

            if ($request->fullUrlIs($except) || $request->is($except)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get verification code
     *
     * @return mixed
     */
    public function getVerificationCode()
    {
        return $this->cache->get($this->prefix . 'code');
    }

    /**
     * @param $code
     */
    public function setVerificationCode($code)
    {
        $this->cache->forever($this->prefix . 'code', $code);
    }
}
