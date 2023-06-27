<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parcel extends Model
{
    use HasFactory;

    /**
     * statuses
     */
    const PENDING = 'Pending';
    const ON_THE_WAY = 'On the Way';
    const PICKED = 'Picked';
    const DELIVERED = 'Delivered';

    // protected $hidden = ['biker_id', 'sender_id'];

    // public function pickup()
    // {
    //     return $this->hasOne(ParcelAddress::class)->where('type', '=', 'pickup');
    // }

    // public function delivery()
    // {
    //     return $this->hasOne(ParcelAddress::class)->where('type', '=', 'delivery');
    // }

    public function biker()
    {
        return $this->belongsTo(User::class, 'biker_id', 'id');
    }
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id', 'id');
    }

    public function parcelAddress(){
        return $this->hasOne(ParcelAddress::class);
    }

    public function isPicked(){
        return $this->status == self::PICKED;
    }

}
