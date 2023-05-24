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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('full_name');
            $table->enum('gender', ['M', 'F']);
            $table->timestampTz('date_of_birth');
            $table->string('role');
            $table->string('id_lecturer')->unique()->nullable();
            $table->string('highest_education')->nullable();
            $table->integer('teaching_experience')->nullable();
            $table->text('education_history')->nullable();
            $table->string('contact_address')->nullable();
            $table->text('short_bio')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
