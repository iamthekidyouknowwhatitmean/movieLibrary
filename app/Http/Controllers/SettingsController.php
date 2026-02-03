<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\SettingsRequest;
use App\Models\User;
use App\Traits\ApiResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    use ApiResponses;
    public function update(SettingsRequest $request)
    {
        $user = User::findOrFail(Auth::id());
        $attributeMap = [
            'data.attributes.firstName' => 'first_name',
            'data.attributes.lastName' => 'last_name',
            'data.attributes.location' => 'location',
            'data.attributes.website' => 'website',
            'data.attributes.bio' => 'bio',
            'data.attributes.email' => 'email',
        ];

        $attributesToUpdate = [];
        foreach($attributeMap as $key=>$attribute)
        {
            if($request->has($key))
            {
                $attributesToUpdate[$attribute] = $request->input($key);
            }
        }

        $user->update($attributesToUpdate);

        return $this->ok('Данные успешно обновлены!');
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $user = User::findOrFail(Auth::id());

        if(!Hash::check($request->input('currentPassword'), $user->password))
        {
            return $this->error('Текущий пароль неверен!', 422);
        }

        $user->update([
            'password' => Hash::make($request->input('newPassword'))
        ]);

        return $this->ok('Пароль успешно изменен!');
    }
}
