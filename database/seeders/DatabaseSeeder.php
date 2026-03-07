<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Rsu;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $rsus = [
            ['rsu_uid' => 'RSU-1', 'latitude' => 0.0, 'longitude' => 0.0, 'tx_power' => 20],
            ['rsu_uid' => 'RSU-2', 'latitude' => 90.0, 'longitude' => 0.0, 'tx_power' => 20],
            ['rsu_uid' => 'RSU-3', 'latitude' => 0.0, 'longitude' => 90.0, 'tx_power' => 20],
            ['rsu_uid' => 'RSU-4', 'latitude' => 90.0, 'longitude' => 90.0, 'tx_power' => 20],
        ];
        
        foreach ($rsus as $rsu) {
            Rsu::firstOrCreate(['rsu_uid' => $rsu['rsu_uid']], $rsu);
        }
    }
}
