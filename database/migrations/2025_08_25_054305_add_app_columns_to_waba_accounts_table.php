<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('waba_accounts', function (Blueprint $table) {
            if (! Schema::hasColumn('waba_accounts', 'app_id')) {
                $table->string('app_id', 100)->nullable()->after('name');
            }
            if (! Schema::hasColumn('waba_accounts', 'app_secret')) {
                $table->string('app_secret', 191)->nullable()->after('app_id');
            }
        });
    }
    public function down(): void {
        Schema::table('waba_accounts', function (Blueprint $table) {
            if (Schema::hasColumn('waba_accounts', 'app_secret')) $table->dropColumn('app_secret');
            if (Schema::hasColumn('waba_accounts', 'app_id'))     $table->dropColumn('app_id');
        });
    }
};
