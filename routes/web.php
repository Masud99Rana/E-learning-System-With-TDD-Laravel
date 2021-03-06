<?php

use Illuminate\Support\Facades\Redis;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/redis', function () { 
// key: value // string
// key: value // list
// key: value // set
    

	//=>  key: value // string
	// Redis::set('friend', 'Maksudur');
	// dd(Redis::get('friend'));


	//=> key: value // list
	// Redis::lpush('frameworks', ['vuejs', 'laravel']);
	// dd(Redis::lrange('frameworks',0,-1)); //for all
	// dd(Redis::lrange('frameworks',0,0)); // index start 0 to end 1;


	// key: value // set (set unique value/ set never allow to duplicate value)
	// Redis::sadd('design', ['css3','html']);
	// dd(Redis::smembers('design'));


	Redis::flushall();
});


Route::get('/rr', function () {

    $user = \App\User::find(1);
    $user->createAsStripeCustomer();
    // return view('welcome');
});
Route::get('register/confirm', 'ConfirmEmailController@index')->name('confirm-email');
Route::get('/logout', function() { auth()->logout(); return redirect('/'); });

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');


Route::get('/', 'FrontendController@welcome');
Route::get('/series', 'FrontendController@showAllseries')->name('all-series');
Route::get('/series/{series}', 'FrontendController@series')->name('series');

Route::middleware('auth')->group(function() {

	Route::get('/profile/{user}', 'ProfilesController@index')->name('profile');
	Route::post('/card/update', 'ProfilesController@updateCard');
	
	Route::get('/subscribe', 'SubscriptionsController@showSubscriptionForm');
	Route::post('/subscribe', 'SubscriptionsController@subscribe')->name('subscription.create'); 
	Route::post('/subscription/change', 'SubscriptionsController@change')->name('subscriptions.change');   

	Route::post('/series/complete-lesson/{lesson}', 'WatchSeriesController@completeLesson');

    Route::get('/watch-series/{series}', 'WatchSeriesController@index')->name('series.learning');
    Route::get('/series/{series}/lesson/{lesson}', 'WatchSeriesController@showLesson')->name('series.watch');
});
