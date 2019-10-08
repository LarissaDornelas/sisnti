<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use App\Events\LoginFailed;
use App\Events\LoginErrorEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Admin;




use GuzzleHttp\Client;
use Psy\Exception\ErrorException;

class AuthController extends Controller
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
    protected $redirectTo = '/dashboard';
    protected $redirectAfterLogout = '/login';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLogin()
    {
        return view('auth/login');
    }

    public function validateLogin(Request $request)
    {
        $data = $request->all();

        $caracteres = [".", "-"];
        $data["username"] = str_replace($caracteres, '', $data["username"]);


        $client = new Client(['verify' => false]);

        $requestBody['user'] = $data["username"];
        $requestBody['password'] = $data["password"];
        $requestBody['attributes'] = ["cpf", "nomecompleto", "telefones", "email"];

        try {
            $response = $client->request(config('ldapi.requestMethod'), config('ldapi.authUrl'), [
                "auth" => [config('ldapi.user'), config('ldapi.password'), "Basic"],
                "body" => json_encode($requestBody),
                "headers" => [
                    "Content-type" => "application/json",
                ],
            ]);
        } catch (ClientException $ex) {
            $credentials["username"] = $data["username"];
            $credentials["password"] = $data["password"];

            event(new LoginFailed($credentials));
            return back()->withErrors(['credentials' => $ex->getResponse()->getBody()->getContents()]);
        } catch (RequestException $ex) {
            event(new LoginErrorEvent($ex->getMessage()));
            return back()->withErrors(['server' => $ex->getResponse()->getBody()->getContents()]);
        }
        $attributes = json_decode($response->getBody()->getContents());

        // if(empty($test)){

        //     $credentials["username"] = $data["username"];
        //     $credentials["password"] = $data["password"];

        //     event(new LoginFailed($credentials));
        //     return back()->withErrors(['credentials' => "Invalid credentials"]);
        // };


        $user = User::where('cpf', $data['username'])->first();

        if (is_null($user)) {




            $user = User::create([
                'username' => $attributes->cpf,
                'name' => ucwords(strtolower($attributes->nomecompleto)),
                'email' => $attributes->email,
                'cpf' => $attributes->cpf,
                'phone' => $attributes->telefones,

            ]);
        }


        Auth::login($user);
        $request->session()->put('admin', [
            (Admin::where('adminCpf', auth()->user()->username)->exists()) ? true : false
        ]);
        return redirect()->route('dashboard');
    }
}
