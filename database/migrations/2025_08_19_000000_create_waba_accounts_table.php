<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Create if not exists
        if (!Schema::hasTable('waba_accounts')) {
            Schema::create('waba_accounts', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
                $table->string('waba_id')->nullable();
                $table->string('app_id')->nullable();
                $table->text('app_secret')->nullable();
                $table->string('phone_number_id')->nullable();
                $table->text('access_token')->nullable(); // encrypted cast
                $table->string('verify_token')->nullable();
                $table->boolean('webhook_verified')->default(false);
                $table->string('default_phone_number_id')->nullable();
                $table->string('display_name')->nullable();
                $table->string('category')->nullable();
                $table->text('about')->nullable();
                $table->string('website')->nullable();
                $table->boolean('connected')->default(false);
                $table->timestamps();

                $table->unique(['user_id']); // one record per user (or global null)
            });
            return;
        }

        // Else, alter to ensure columns exist
        Schema::table('waba_accounts', function (Blueprint $table) {
            foreach ([
                'app_id' => 'string',
                'app_secret' => 'text',
                'verify_token' => 'string',
                'webhook_verified' => 'boolean',
                'default_phone_number_id' => 'string',
                'display_name' => 'string',
                'category' => 'string',
                'about' => 'text',
                'website' => 'string',
            ] as $col => $type) {
                if (!Schema::hasColumn('waba_accounts', $col)) {
                    $table->{$type}($col)->nullable();
                }
            }
            if (!Schema::hasColumn('waba_accounts', 'connected')) {
                $table->boolean('connected')->default(false);
            }
        });
    }

    public function down(): void
    {
        // Keep table (data is important). If you want to drop, uncomment:
        // Schema::dropIfExists('waba_accounts');
    }
};
