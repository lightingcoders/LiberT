<?php

namespace HolluwaTosin\Installer\Controllers;

use HolluwaTosin\Installer\Middleware\Verification;
use HolluwaTosin\Installer\PurchaseDetails;
use Illuminate\Routing\Controller;
use Illuminate\Cache\Repository as Cache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class VerifyController extends Controller
{
    /**
     * @var Verification
     */
    protected $verification;

    /**
     * InstallController constructor.
     *
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->verification = new Verification($cache);
    }

    /**
     * Display the verify overview page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('installer::verify.index');
    }

    /**
     * Verify code
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'verification' => 'required|min:10',
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator);
        }

        $code = $request->get('verification');

        try{
            $details = $this->verification->register($code);

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

                return redirect()->back()->withErrors($validator);
            }else{
                $this->verification->setVerificationCode($code);
            }
        }catch(\Exception $e){
            $validator->getMessageBag()->add('verification', $e->getMessage());

            return redirect()->back()->withErrors($validator);
        }

        return redirect()->to('/');
    }

}
