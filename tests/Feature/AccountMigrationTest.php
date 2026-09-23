<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class AccountMigrationTest extends TestCase
{
    use DatabaseMigrations;

    public function test_existing_accounts_are_backfilled_without_changing_registration_dates(): void
    {
        $users = User::factory()->count(2)->create(['created_at' => now()->subMonth(), 'updated_at' => now()->subWeek()]);
        $migration = require database_path('migrations/2026_09_23_120000_add_api_and_plan_fields_to_users_table.php');
        $migration->down();
        $migration->up();
        foreach ($users as $original) {
            $user = $original->fresh();
            $this->assertSame('beta', $user->plan);
            $this->assertSame(0, $user->tokens_used);
            $this->assertNull($user->last_login_at);
            $this->assertTrue($original->created_at->equalTo($user->created_at));
            $this->assertTrue($original->updated_at->equalTo($user->updated_at));
            $this->assertMatchesRegularExpression('/^illuna_[a-f0-9]{64}$/', $user->api_key);
            $this->assertSame(hash('sha256', $user->api_key), $user->api_key_hash);
        }
        $this->assertNotSame($users[0]->fresh()->api_key, $users[1]->fresh()->api_key);
    }
}
