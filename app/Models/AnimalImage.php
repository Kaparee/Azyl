<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AnimalImage extends Model
{
    protected $fillable = ['animal_id', 'image_id', 'sort_order'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    public function image()
    {
        return $this->belongsTo(Image::class);
    }
}
