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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('breed_id')->constrained('breeds')->onDelete('cascade');
            $table->smallInteger('age_months');
            $table->smallInteger('genders'); // 0 for Male, 1 for Female etc.
            $table->integer('height');
            $table->string('color');
            $table->text('description');
            $table->text('medical_info')->nullable();
            $table->decimal('adoption_fee', 10, 2)->default(0);
            $table->integer('status');
            $table->string('qr_token')->unique();
            $table->timestamp('arrival_date');
            $table->integer('click_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animals');
    }
};
