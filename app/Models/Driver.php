<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Inverse of oneHas Relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Drivers have multiple trips
    public function trips()
    {
        return $this->hasMany(Trip::class);
    }

}
