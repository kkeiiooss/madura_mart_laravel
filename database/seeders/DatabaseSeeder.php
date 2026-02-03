<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin Madura Mart',
            'email' => 'admin@maduramart.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'alamat' => 'Jl. Madura No. 1',
            'no_telepon' => '081234567890',
            'foto' => 'https://via.placeholder.com/150',
        ]);

        $this->call([
            DummyDataSeeder::class,
        ]);
    }
}
