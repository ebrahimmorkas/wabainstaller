<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('message_templates', function (Blueprint $table) {
            $table->id();

            // Attach to WABA via string FK
            $table->string('waba_id', 191); // FK to waba_accounts.waba_id

            $table->string('name', 191);
            $table->string('category', 50)->nullable();   // MARKETING / UTILITY / AUTHENTICATION
            $table->string('language', 10)->nullable();   // e.g., en_US
            $table->string('quality_score', 20)->nullable();
            $table->string('status', 50)->nullable();     // APPROVED / REJECTED / PENDING

            $table->json('components')->nullable();       // parsed components array
            $table->json('component_data')->nullable();   // full raw template JSON

            $table->timestamps();

            // Prevent dupes for same WABA
            $table->unique(['waba_id', 'name', 'language']);

            $table->foreign('waba_id')
                  ->references('waba_id')->on('waba_accounts')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::table('message_templates', function (Blueprint $table) {
            $table->dropForeign(['waba_id']);
        });
        Schema::dropIfExists('message_templates');
    }
};
