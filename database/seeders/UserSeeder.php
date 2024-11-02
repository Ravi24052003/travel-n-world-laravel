<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name"=>"Admin",
            "company_name"=> "travelnworld",
            "phone"=> 7290087051,
            "email"=>"tnwadmin@gmail.com",
            "password"=>"TravelAdmin@007",
            "role"=>"admin",
            "isAuthorised"=>true
        ]);
    }
}
