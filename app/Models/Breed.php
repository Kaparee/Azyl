<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Breed extends Model
{
    protected $fillable = ['name', 'species_id'];

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
}
