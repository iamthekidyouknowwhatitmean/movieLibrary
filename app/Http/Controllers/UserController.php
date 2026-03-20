<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(User $user)
    {
        return $user;
    }

    public function watched(User $user)
    {
        return $user->watched;
    }

    public function likes(User $user)
    {
        return $user->likes;
    }

    public function watchlist(User $user)
    {
        return $user->watchlist;
    }

    public function following(User $user)
    {
        return $user->following;
    }

    public function followers(User $user)
    {
        return $user->followers;
    }

    public function reviews(User $user)
    {
        return $user->reviews;
    }

    public function activities(User $user)
    {
        return $user->activities;
    }
}
