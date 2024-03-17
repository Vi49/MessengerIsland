<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $guarded = false;

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


    public function friends()
    {
        return $this->hasMany(Friends::class, 'first_friend_id')
            ->where('status', 'friend')
            ->select('second_friend_id as friend_id');
    }

    public function inverseFriends()
    {
        return $this->hasMany(Friends::class, 'second_friend_id')
            ->where('status', 'friend')
            ->select('first_friend_id as friend_id');
    }

    public function allFriends()
    {
        return $this->friends()->union($this->inverseFriends());
    }
}
