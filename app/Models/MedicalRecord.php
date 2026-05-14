<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    protected $fillable = ['animal_id', 'treatment_type', 'description', 'cost', 'treatment_date'];

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}
