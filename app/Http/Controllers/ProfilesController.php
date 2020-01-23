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

    public function updateCard() {
        $this->validate(request(), [
            'stripeToken' => 'required'
        ]);
        $token = request('stripeToken');
        $user = auth()->user();

        $user->updateCard($token);
        return response()->json('ok');
    }
}
