<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelAddress extends Model
{
    use HasFactory;

    protected $guarded = [];

    // protected $hidden = ['parcel_id', 'id', 'created_at', 'updated_at'];

    public function parcel(){
        return $this->belongsTo(Parcel::class);
    }
}
