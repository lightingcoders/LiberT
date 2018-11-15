<?php
/**
 * Created by PhpStorm.
 * User: HolluwaTosin
 * Date: 6/9/2018
 * Time: 10:21 AM
 */

namespace HolluwaTosin\Installer\Middleware;

use Closure;
use HolluwaTosin\Installer\PurchaseDetails;
use Illuminate\Cache\Repository as Cache;
use Illuminate\Support\Facades\File;

class CanVerify extends Verification
{
    /**
     * CanVerify constructor.
     * 
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        parent::__construct($cache);
    }

    /**
     * Handle an incoming request.
     *
     * @param null|string $type
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $type = null)
    {
        $purchaseDetails = null;

        if ($code = $this->getVerificationCode()) {
            $purchaseDetails = $this->details($code);
        }

        if(!$this->installed()){
            return redirect()->route('Installer::overview.index');
        }

        if ($purchaseDetails instanceof PurchaseDetails) {
            return abort(404);
        }

        return $next($request);
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
}
