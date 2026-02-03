<?php

namespace App\Http\Controllers;

use App\Http\Requests\SettingsRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
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
    }
}
