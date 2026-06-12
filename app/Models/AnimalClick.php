<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalClick extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'animal_id',
        'clicked_at',
    ];

    protected $casts = [
        'clicked_at' => 'datetime',
    ];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
