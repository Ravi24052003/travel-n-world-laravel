<?php

namespace Database\Seeders;

use App\Models\Lead;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        

        // User::factory()->create([
        //     "name"=>"admin",
        //     "email"=>"admireadmin@gmail.com",
        //     "password"=>"Admire@12345",
        //     "role"=>"admin"
        // ]);

        $this->call([UserCompanySeeder::class]);
    }
}
