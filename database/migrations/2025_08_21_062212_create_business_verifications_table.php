<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('business_verifications', function (Blueprint $table) {
            $table->id();

            // One record per WABA (enforce uniqueness)
            $table->string('whatsapp_business_account_id', 191)->unique(); // FK to waba_accounts.waba_id

            $table->string('name', 191);
            $table->string('verification_status', 50); // VERIFIED / PENDING / UNVERIFIED
            $table->timestamp('updated_at')->useCurrent(); // they only asked updated_at; keep Laravel-ish

            // FK
            $table->foreign('whatsapp_business_account_id')
                  ->references('waba_id')->on('waba_accounts')
                  ->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::table('business_verifications', function (Blueprint $table) {
            $table->dropForeign(['whatsapp_business_account_id']);
        });
        Schema::dropIfExists('business_verifications');
    }
};
