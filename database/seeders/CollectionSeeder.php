<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            DatabaseSeeder::class,
        ]);

        User::where('id', 1)->update([
            'name' => 'Admin',
            'email' => 'enkhtulga.tl@gmail.com',
            'password' => bcrypt('Enkhtulga@1'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}