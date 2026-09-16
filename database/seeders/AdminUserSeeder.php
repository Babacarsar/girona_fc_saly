<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $email = env('ADMIN_EMAIL');
        $password = env('ADMIN_PASSWORD');

        if (! $email || ! $password) {
            $this->command?->warn('ADMIN_EMAIL / ADMIN_PASSWORD not set — skipping admin user seed.');

            return;
        }

        $user = User::firstOrNew(['email' => $email]);
        $user->name = $user->name ?: 'Administrateur';

        if (! $user->exists || ! Hash::check($password, $user->password)) {
            $user->password = Hash::make($password);
        }

        $user->save();
    }
}
