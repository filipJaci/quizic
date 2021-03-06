<?php

namespace Quizic;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

// USED FOR USER VALIDATION
use Tymon\JWTAuth\Contracts\JWTSubject;
// USED FOR UPDATING PASSWORD
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'remember_token',
        'password',
    ];

    /**
     * Hash before creation user password.
     *
     * @param  string  $value
     * @return void
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    // SETS DEFAULT ROLE VALUE
    protected $attributes = [
        'role' => 1,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // USED FOR USER AUTHENTICATION
    public function getJWTIdentifier(){
        return $this->getKey();
    }

    public function getJWTCustomClaims(){
        return [];
    }

    public function fetchUsers($request){
        return $this->paginate($request->per_page);
    }

    public function updatePassword($passwordNew){
        // HASH NEW PASSWORD
        $passwordNew1 = Hash::make($passwordNew);
        // SET NEW PASSWORD
        $this->password = $passwordNew;
        // SAVE TO DB
        $this->save();
    }

}
