<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VolunteerTask extends Model
{
    protected $fillable = ['title', 'description', 'date', 'time', 'status', 'is_urgent', 'assigned_to'];

    protected function casts(): array
    {
        return [
            'is_urgent' => 'boolean',
        ];
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
