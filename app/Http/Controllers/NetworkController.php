<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NetworkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function following()
    {
        return response()->json([
            'following' => Auth::user()->following
        ]);
    }

    public function followers()
    {
        return response()->json([
            'followers' => Auth::user()->followers
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeFollowing(User $following)
    {
        Auth::user()->following()->syncWithoutDetaching([
            'following_id' => $following->id
        ]);
    }

    public function storeFollower(User $follower)
    {
        Auth::user()->followers()->syncWithoutDetaching([
            'following_id' => $follower->id
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyFollowing(User $following)
    {
        Auth::user()->following()->detach([
            'following_id' => $following->id
        ]);
    }

    public function destroyFollower(User $follower)
    {
        Auth::user()->followers()->detach([
            'following_id' => $follower->id
        ]);
    }
}
