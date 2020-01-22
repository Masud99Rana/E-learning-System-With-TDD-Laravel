<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Entities\Learning;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use Notifiable, Learning, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded =[];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Checks if user's email has been confirmed
     *
     * @return boolean
     */
    public function isConfirmed()
    {
        return $this->confirm_token == null;
    }

    /**
     * Confirm a user's email
     *
     * @return void
     */
    public function confirm() 
    {
        $this->confirm_token = null;
        $this->save();
    }

    /**
     * Check if current user is an administrator
     *
     * @return boolean
     */
    public function isAdmin()
    {
        return in_array($this->email, config('mrcasts.administrators'));
    }

    
    public function getRouteKeyName() {
        return 'username';
    }
}
