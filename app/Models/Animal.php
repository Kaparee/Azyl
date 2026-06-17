<?php

namespace App\Models;

use App\Enums\AnimalStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'breed_id', 'age_months', 'genders', 'height', 'color',
        'description', 'medical_info', 'adoption_fee', 'status',
        'qr_token', 'arrival_date',
        'traits', 'housing_conditions', 'experience_required', 'daily_time_required',
        'is_child_friendly', 'accepts_cats', 'accepts_dogs', 'requires_responsible_caregiver',
        'caregiver_id', 'contact_phone', 'visiting_hours'
    ];

    protected function casts(): array
    {
        return [
            'status' => AnimalStatus::class,
            'arrival_date' => 'date',
            'traits' => 'array',
            'is_child_friendly' => 'boolean',
            'accepts_cats' => 'boolean',
            'accepts_dogs' => 'boolean',
            'requires_responsible_caregiver' => 'boolean',
        ];
    }

    public function caregiver()
    {
        return $this->belongsTo(User::class, 'caregiver_id');
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

    public function recentClicks()
    {
        return $this->hasMany(AnimalClick::class)->where('clicked_at', '>=', now()->subDays(30));
    }
}
