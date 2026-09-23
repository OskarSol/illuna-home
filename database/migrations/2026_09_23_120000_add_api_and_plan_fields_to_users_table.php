<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Registration time is already recorded in users.created_at.
        Schema::table('users', function (Blueprint $table) {
            $table->timestamp('last_login_at')->nullable();
            $table->text('api_key')->nullable();
            $table->char('api_key_hash', 64)->nullable()->unique();
            $table->timestamp('api_key_created_at')->nullable();
            $table->string('plan', 32)->default('beta');
            $table->unsignedBigInteger('tokens_used')->default(0);
        });

        // Upgrade existing accounts without rewriting their original timestamps.
        DB::table('users')->select('id')->orderBy('id')->chunkById(200, function ($users): void {
            foreach ($users as $user) {
                $key = 'illuna_'.bin2hex(random_bytes(32));
                DB::table('users')->where('id', $user->id)->update([
                    'api_key' => Crypt::encryptString($key),
                    'api_key_hash' => hash('sha256', $key),
                    'api_key_created_at' => now(),
                ]);
            }
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique(['api_key_hash']);
            $table->dropColumn(['last_login_at', 'api_key', 'api_key_hash', 'api_key_created_at', 'plan', 'tokens_used']);
        });
    }
};
