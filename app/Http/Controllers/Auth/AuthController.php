<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use ApiResponses;

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|min:8'
        ]);

        if(!Auth::attempt($request->only('email','password')))
        {
            return $this->error('Invalid credentials',401);
        }

        $user = Auth::user();;

        return $this->ok(
            'Authenticated',
            [
                'token' => $user->createToken(
                    'API token for ' . $user->email,
                    ['*'],
                    now()->addMonth())->plainTextToken
            ]
        );
    }

    public function logout(Request $request){
        $request->user()->currentAccessToken()->delete();

        return $this->ok('');
    }
}
