<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $hidden = ['email_verified_at', 'created_at','updated_at', 'password', 'remember_token',];

    const SENDER = 'Sender';
    const BIKER = 'Biker';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function parcelsOfSenders(){
        return $this->hasMany(Parcel::class, 'sender_id');
    }

    public function parcelsOfBikers(){
        return $this->hasMany(Parcel::class, 'biker_id');
    }

    public function isSender(){
        return $this->type == self::SENDER;
    }

    public function isBiker(){
        return $this->type == self::BIKER;
    }
}
