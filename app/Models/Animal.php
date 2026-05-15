<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'breed_id', 'age_months', 'genders', 'height', 'color', 
        'description', 'medical_info', 'adoption_fee', 'status', 
        'qr_token', 'arrival_date', 'click_count'
    ];

    protected function casts(): array
    {
        return [
            'status' => \App\Enums\AnimalStatus::class,
            'arrival_date' => 'datetime',
        ];
    }

    public function breed()
    {
        return $this->belongsTo(Breed::class);
    }

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function animalImages()
    {
        return $this->hasMany(AnimalImage::class);
    }

    public function adoptionApplications()
    {
        return $this->hasMany(AdoptionApplication::class);
    }

    public function fundraisers()
    {
        return $this->hasMany(Fundraiser::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'animal_likes');
    }
}
