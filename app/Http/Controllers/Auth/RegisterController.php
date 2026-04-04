<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\Welcome;
use App\Traits\ApiResponses;

class RegisterController extends Controller
{
    use ApiResponses;

    public function store(RegisterUserRequest $request)
    {
        $user = User::create($request->validated());

        Mail::to($user->email)->queue(new Welcome());

        return $this->ok('Регистрация прошла успешно');
    }
}
