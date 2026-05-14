<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fundraiser extends Model
{
    protected $fillable = [
        'animal_id', 'title', 'description', 'target_amount', 
        'collected_amount', 'qr_token', 'status', 'end_date'
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
