<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('phone_numbers', function (Blueprint $table) {
            $table->id();

            // Core Meta number identity
            $table->string('phone_number_id', 191)->unique(); // Meta Phone Number ID (FK source)
            $table->string('display_phone_number', 32)->index();

            // Association to WABA (string FK)
            $table->string('whatsapp_business_account_id', 191); // references waba_accounts.waba_id
            $table->string('waba_name', 191)->nullable();

            // Business/number attributes
            $table->string('verified_name', 191)->nullable();
            $table->string('code_verification_status', 50)->nullable(); // VERIFIED / NOT_VERIFIED etc.
            $table->string('quality_rating', 20)->nullable();           // GREEN/YELLOW/RED
            $table->string('platform_type', 50)->nullable();            // CLOUD_API / ON_PREMISE
            $table->string('throughput_level', 50)->nullable();         // e.g. TIER_1
            $table->timestamp('last_onboarded_time')->nullable();
            $table->json('webhook_configuration')->nullable();
            $table->boolean('is_official_business_account')->default(false);
            $table->string('messaging_limit_tier', 50)->nullable();     // 250 / 1K / 10K / Unlimited

            // Auth + lifecycle
            $table->text('token')->nullable();                          // number-level token
            $table->enum('status', ['active','inactive'])->default('inactive');

            $table->timestamps();

            // FKs / Indexes
            $table->index('whatsapp_business_account_id');

            // FK to unique(non-PK) column is allowed in MySQL
            $table->foreign('whatsapp_business_account_id')
                  ->references('waba_id')->on('waba_accounts')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::table('phone_numbers', function (Blueprint $table) {
            $table->dropForeign(['whatsapp_business_account_id']);
        });
        Schema::dropIfExists('phone_numbers');
    }
};
