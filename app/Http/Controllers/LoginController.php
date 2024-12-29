<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Password;
use App\Models\User;
use App\Models\RecentLogs;
use Illuminate\Http\Response;
use App\Http\Requests\Auth\LoginRequest;
use Jenssegers\Agent\Agent;
use Illuminate\Support\Facades\Cache;

//CIPHER:
use App\Http\Controllers\AESCipher;

class LoginController extends Controller
{
    /**
     * Display login page.
     *
     * @return Renderable
     */
    public function show()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {

        try {
            $request->authenticate();
           
            $aes = new AESCipher;
            $request->session()->regenerate();

            $user = User::where(['id' => Auth::user()->id])->first();
            $authToken = $user->createToken(\Str::random(50))->plainTextToken;
            $request->session()->put('token', $authToken);

            RecentLogs::create([
                'name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'phone' => request()->header('User-Agent'),
                'browser' => (new Agent())->browser(),
                'device' => (new Agent())->device(),
                'platform' => (new Agent())->platform(),
                'ip_address' => request()->ip()
            ]);

            return response()->json([], Response::HTTP_OK);

        } catch (ValidationException $e) {
            return response()->json([
                'Message' => $e->getMessage(),
            ],  Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout(Request $request)
    {

        if (Auth::check()) {
            Cache::forget('user-online-' . Auth::id());
        }
        
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([], Response::HTTP_OK);
    }
}
