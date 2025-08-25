<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('waba_accounts', function (Blueprint $table) {
            $table->id();
            $table->string('waba_id', 191)->unique();          // <- FK target for others
            $table->text('access_token');
            $table->string('name', 191)->nullable();           // Friendly label
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('waba_accounts');
    }
};
