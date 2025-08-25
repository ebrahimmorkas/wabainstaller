<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('phone_number_profiles', function (Blueprint $table) {
            $table->id();

            // Link to phone_numbers via string key
            $table->string('phone_number_id', 191)->unique(); // one-to-one per number

            $table->text('about')->nullable();
            $table->text('address')->nullable();
            $table->text('description')->nullable();
            $table->string('email', 191)->nullable();
            $table->text('profile_picture_url')->nullable();
            $table->json('websites')->nullable();             // array of URLs
            $table->string('vertical', 100)->nullable();

            $table->timestamps();

            $table->foreign('phone_number_id')
                  ->references('phone_number_id')->on('phone_numbers')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::table('phone_number_profiles', function (Blueprint $table) {
            $table->dropForeign(['phone_number_id']);
        });
        Schema::dropIfExists('phone_number_profiles');
    }
};
