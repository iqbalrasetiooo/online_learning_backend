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
        Schema::table('profiles', function (Blueprint $table) {
            $table->string('id_lecturer')->unique()->nullable();
            $table->string('highest_education')->nullable();
            $table->integer('teaching_experience')->nullable();
            $table->text('education_history')->nullable();
            $table->string('contact_address')->nullable();
            $table->text('short_bio')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function (Blueprint $table) {
            //
        });
    }
};
