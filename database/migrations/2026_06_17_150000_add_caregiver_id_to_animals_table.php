<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->foreignId('caregiver_id')->nullable()->constrained('users')->nullOnDelete();
            $table->dropColumn(['contact_name', 'contact_email']);
        });
    }

    public function down(): void
    {
        Schema::table('animals', function (Blueprint $table) {
            $table->dropForeign(['caregiver_id']);
            $table->dropColumn('caregiver_id');
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
        });
    }
};
