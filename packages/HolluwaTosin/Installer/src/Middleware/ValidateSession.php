<?php

namespace HolluwaTosin\Installer\Middleware;

use Closure;
use HolluwaTosin\Installer\PurchaseDetails;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Cache\Repository as Cache;

class ValidateSession extends Verification
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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param $type
     * @return mixed
     */
    public function handle($request, Closure $next, $type = null)
    {
        $key = $this->prefix . 'code';

        $validator = Validator::make([],[]);

        if($code = session()->get($key)){
            try{
                $details = $this->details($code);

                if(!($details instanceof PurchaseDetails)){
                    if(is_array($details) && isset($details['error'])){
                        $validator->getMessageBag()->add(
                            'verification', $details['message']
                        );
                    }else{
                        $validator->getMessageBag()->add(
                            'verification', 'Something unexpected went wrong!'
                        );
                    }

                    return redirect()->route('Installer::overview.index')
                        ->withErrors($validator);
                }else{
                    session()->put($key, $code);
                }
            }catch(\Exception $e){
                $validator->getMessageBag()->add(
                    'verification', $e->getMessage()
                );

                return redirect()->route('Installer::overview.index')
                    ->withErrors($validator);
            }
        }else{
            $validator->getMessageBag()->add(
                'verification', 'Please enter your verification code.'
            );

            return redirect()->route('Installer::overview.index')
                ->withErrors($validator);
        }


        return $next($request);
    }
}
