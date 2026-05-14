<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = ['fundraiser_id', 'user_id', 'amount'];

    public function fundraiser()
    {
        return $this->belongsTo(Fundraiser::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
