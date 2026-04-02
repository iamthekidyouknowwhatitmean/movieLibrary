<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\SettingsRequest;
use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    use ApiResponses;

    public function update(SettingsRequest $request)
    {
        Auth::user()->update($request->validated());

        return $this->ok('Данные успешно обновлены!');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        if(!Hash::check($request->input('currentPassword'), Auth::user()->password))
        {
            return $this->error('Текущий пароль неверен!', 422);
        }

        Auth::user()->update([
            'password' => Hash::make($request->input('newPassword'))
        ]);

        return $this->ok('Пароль успешно изменен!');
    }
}
