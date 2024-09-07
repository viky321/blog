<?php

namespace App\Http\Controllers;

use random;
use App\Models\User;
use Dotenv\Util\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{
    protected $redirectPath = "/";
    protected $redirectAfterLogout = "/login";

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }


         // Login failed
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect($this->redirectAfterLogout);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect('/');
    }

    public function redirectToProvider($service, Request $request)
    {
        $config = $this->getOAuthConfig($service, $request);
        config(['services.oauth' => $config]);

        return Socialite::driver($service)->redirect();
    }

    public function handleProviderCallback($service, Request $request)
    {
        $config = $this->getOAuthConfig($service, $request);
        config(['services.oauth' => $config]);

        $socialUser = Socialite::driver($service)->stateless()->user();
        $user = User::updateOrCreate([
            'email' => $socialUser->getEmail(),
        ], [
            'name' => $socialUser->getName(),
            'password' => bcrypt(Str::random(24)),
        ]);

        Auth::login($user, true);

        return redirect()->intended('/');
    }

    /**
     * Get the OAuth configuration for the given service.
     *
     * @param string $service
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function getOAuthConfig($service, Request $request)
    {
        return [
            'client_id' => $request->get('client_id', env('OAUTH_CLIENT_ID')),
            'client_secret' => $request->get('client_secret', env('OAUTH_CLIENT_SECRET')),
            'redirect' => $request->get('redirect', url("/auth/{$service}/callback")),
        ];
    }

}
