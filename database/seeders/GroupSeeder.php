<?php

namespace Database\Seeders;

use App\Models\arisan_group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        arisan_group::create([
            'name' => 'arisan bulanan',
            'amount' => '10000',
            'start_date' => '2025-07-07',
            'duration' => '12 Bulan',
        ]);

        arisan_group::create([
            'name' => 'arisan harian',
            'amount' => '10000',
            'start_date' => '2025-07-07',
            'duration' => '12 Bulan',
        ]);
    }
}
