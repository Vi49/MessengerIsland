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
        return $this->hasMany(Relationships::class, 'first_user_id', 'id')
            ->where('status', 'friend')->orderByDesc('relationships.id');
    }

    public function pending_friends()
    {
        return $this->hasMany(Relationships::class, 'second_user_id', 'id')
            ->where('status', 'requested')->orderByDesc('relationships.id');
    }

    public function blocked_friends()
    {
        return $this->hasMany(BlockRelationships::class, 'first_user_id', 'id')->orderByDesc('block_relationships.id');
    }
}
