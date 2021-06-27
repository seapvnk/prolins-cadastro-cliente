<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

use App\Models\Profile;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    public $timestamps = false;

    protected $fillable = [
        "name", 
        "email", 
        "password"
    ];

    protected $hidden = ["password"];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function profile(): Profile
    {
        return Profile::find($this->profile_id);
    }

    public function attachItsProfile(Profile $userProfile): void
    {
        $this->profile_id = $userProfile->id;
    }

    public function setUpdatedAt($value)
    {
        // Do nothing.
    }
}