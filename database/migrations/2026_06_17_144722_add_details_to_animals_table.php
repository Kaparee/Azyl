<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->json('traits')->nullable();
            $table->string('housing_conditions')->nullable();
            $table->string('experience_required')->nullable();
            $table->string('daily_time_required')->nullable();
            $table->boolean('is_child_friendly')->default(false);
            $table->boolean('accepts_cats')->default(false);
            $table->boolean('accepts_dogs')->default(false);
            $table->boolean('requires_responsible_caregiver')->default(false);
            $table->string('contact_name')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('visiting_hours')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropColumn([
                'traits',
                'housing_conditions',
                'experience_required',
                'daily_time_required',
                'is_child_friendly',
                'accepts_cats',
                'accepts_dogs',
                'requires_responsible_caregiver',
                'contact_name',
                'contact_phone',
                'contact_email',
                'visiting_hours',
            ]);
        });
    }
};
