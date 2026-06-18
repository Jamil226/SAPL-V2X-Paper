<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Rsu;
use App\Models\User;
use App\Models\Vehicle;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── 1. RSUs ────────────────────────────────────────────────────────────
        // Four corners of a 90 × 90 m urban intersection grid (sim units).
        // RSU-1 = SW, RSU-2 = SE, RSU-3 = NW, RSU-4 = NE.
        $rsus = [
            ['rsu_uid' => 'RSU-1', 'latitude' =>  0.0, 'longitude' =>  0.0, 'tx_power' => 20],
            ['rsu_uid' => 'RSU-2', 'latitude' => 90.0, 'longitude' =>  0.0, 'tx_power' => 20],
            ['rsu_uid' => 'RSU-3', 'latitude' =>  0.0, 'longitude' => 90.0, 'tx_power' => 20],
            ['rsu_uid' => 'RSU-4', 'latitude' => 90.0, 'longitude' => 90.0, 'tx_power' => 20],
        ];
        foreach ($rsus as $rsu) {
            Rsu::firstOrCreate(['rsu_uid' => $rsu['rsu_uid']], $rsu);
        }

        // ── 2. Known admin / demo users (predictable credentials for testing) ──
        $knownUsers = [
            [
                'name'              => 'Admin User',
                'email'             => 'admin@sapl-v2x.test',
                'password'          => Hash::make('Admin1234!'),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
            ],
            [
                'name'              => 'Demo Operator',
                'email'             => 'demo@sapl-v2x.test',
                'password'          => Hash::make('Demo1234!'),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
            ],
            [
                'name'              => 'Researcher One',
                'email'             => 'researcher@sapl-v2x.test',
                'password'          => Hash::make('Research1234!'),
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
            ],
        ];
        foreach ($knownUsers as $u) {
            User::firstOrCreate(['email' => $u['email']], $u);
        }

        // ── 3. Faker-generated users (10 additional) ─────────────────────────
        User::factory(10)->create();

        // ── 4. Pre-registered demo vehicles ──────────────────────────────────
        $vehicles = [
            [
                'vehicle_uid' => 'VEH-DEMO-001',
                'secret_key'  => bin2hex(random_bytes(32)),
                'group_key'   => 'STATIC_GROUP_KEY_FOR_SIMULATION',
                'is_active'   => true,
            ],
            [
                'vehicle_uid' => 'VEH-DEMO-002',
                'secret_key'  => bin2hex(random_bytes(32)),
                'group_key'   => 'STATIC_GROUP_KEY_FOR_SIMULATION',
                'is_active'   => true,
            ],
            [
                'vehicle_uid' => 'VEH-DEMO-003',
                'secret_key'  => bin2hex(random_bytes(32)),
                'group_key'   => 'STATIC_GROUP_KEY_FOR_SIMULATION',
                'is_active'   => false, // inactive — useful for testing rejection
            ],
        ];
        foreach ($vehicles as $v) {
            Vehicle::firstOrCreate(['vehicle_uid' => $v['vehicle_uid']], $v);
        }
    }
}