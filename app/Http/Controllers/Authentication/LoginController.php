<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use PragmaRX\Google2FA\Google2FA;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * An instance of google 2fa generator
     *
     * @var Google2FA
     */
    protected $google2fa;

    /**
     * Create a new controller instance.
     *
     * @param Google2FA $google2fa
     * @return void
     */
    public function __construct(Google2FA $google2fa)
    {
        $this->middleware('guest')
            ->except('logout');

        $this->google2fa = $google2fa;
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        return view('authentication.login');
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    protected function validateLogin(Request $request)
    {
        $rules = [
            $this->username() => 'required|string',
            'password' => 'required|string'
        ];

        $user = User::where('name', $request->name)
            ->first();

        if ($user && (bool)$user->getSetting()->user_login_2fa) {

            $rules = array_merge($rules, [
                'token' => [
                    'required', function ($attribute, $value, $fail) use ($user) {
                        if ($value !== null) {
                            $valid = $this->google2fa->verifyKey(
                                $user->google2fa_secret, $value
                            );

                            if (!$valid) {
                                $fail(__('You have entered an invalid token!'));
                            }
                        } else {
                            $fail(__('Two factor authentication is required!'));
                        }
                    },
                ]
            ]);

        }

        if (config()->get('services.nocaptcha.enable')) {
            $rules = array_merge($rules, [
                'g-recaptcha-response' => 'required|captcha'
            ]);
        }

        $this->validate($request, $rules, [
            'token.required' => __('Please enter your 2FA token!')
        ]);
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $messages = [
            $this->username() => [trans('auth.failed')],
        ];

        if ($request->has('token')) {
            $messages = [
                'token' => [__('Check your password and try again.')]
            ];
        }

        throw ValidationException::withMessages($messages);
    }

    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request $request
     * @return bool
     */
    protected function attemptLogin(Request $request)
    {
        $credentials = array_merge([
            'status' => 'active'
        ], $this->credentials($request));

        return $this->guard()->attempt(
            $credentials, $request->filled('remember')
        );
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'name';
    }


    public function check2FA(Request $request)
    {
        if ($request->ajax()) {
            $this->validate($request, [
                'name' => 'required|exists:users,name'
            ]);

            $user = User::where('name', $request->name)->first();

            $status = (bool)$user->getSetting()->user_login_2fa;

            return response()->json(['status' => $status]);
        } else {
            return abort(404);
        }
    }
}
