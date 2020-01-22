<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class ProfilesController extends Controller
{
    public function index(User $user) {
        return view('profile')
                ->withUser($user)
                ->withSeries($user->seriesBeingWatched());
    }
}
