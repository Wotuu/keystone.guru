<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Psr\Log\LogLevel;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

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
     */
    protected string $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    protected function attemptLogin(Request $request): bool
    {
        try {
            return $this->guard()->attempt(
                $this->credentials($request), $request->boolean('remember')
            );
        } catch (RuntimeException $exception) {
            $all = $request->all();
            unset($all['password']);
            logger()->log(LogLevel::ERROR, $exception->getMessage(), $all);

            throw $exception;
        }
    }


    /**
     * The user has been authenticated.
     */
    protected function authenticated(Request $request, mixed $user)
    {
        $this->redirectTo = $request->get('redirect', '/');
    }

    /**
     * Get the failed login response instance.
     *
     *
     * @throws ValidationException
     */
    protected function sendFailedLoginResponse(Request $request): never
    {
        throw ValidationException::withMessages([
            $this->username() => [trans('auth.failed')],
        ])->redirectTo(route('login', ['redirect' => $request->get('redirect', '/')]));
    }
}
