<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionsController extends Controller
{
    public function showSubscriptionForm() {
        return view('subscribe');
    }

    public function subscribe() {
        return auth()->user()
                ->newSubscription(
                    request('plan'), request('plan')// want to see in our db, plan in our
                )->create(
                    request('stripeToken')
                );
    }

    public function change() {
        $this->validate(request(), [
            'plan' => 'required'
        ]);
        $user = auth()->user();
        $userPlan = $user->subscriptions->first()->stripe_plan;

        // dd(request('plan'));

        if (request('plan') === $userPlan) {
            return redirect()->back();
        }

        // $user->subscription($userPlan)->swap(request('plan'));
        $user->subscription('plan_Gb0GmVMyoXL6eb')->swap('plan_GaxMcSdIPel0Xv');
        // name field subscriptions table swap( stripe_plan field)
        return redirect()->back();
    }

// plan_GaxMcSdIPel0Xv
// plan_Gb0GmVMyoXL6eb
}
