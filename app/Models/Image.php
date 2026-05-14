<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = ['animal_id', 'file_name', 'original_file_name', 'file_type'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function animalImages()
    {
        return $this->hasMany(AnimalImage::class);
    }
}
