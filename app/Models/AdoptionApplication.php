<?php

namespace App\Models;

use App\Enums\AdoptionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdoptionApplication extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'animal_id', 'status', 'message'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    protected function casts(): array
    {
        return [
            'status' => AdoptionStatus::class,
        ];
    }
}
