<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerTask extends Model
{
    protected $fillable = ['title', 'description', 'date', 'time', 'status', 'assigned_to'];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
