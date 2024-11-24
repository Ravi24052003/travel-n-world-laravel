<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class UserCompanySeeder extends Seeder
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
            "email"=>"admireholidays7@gmail.com",
            "password"=>"Admire@2024",
            "role"=>"admin",
            "is_authorised"=> true,
            "is_publicly_present"=> false,
            "is_verified"=> true
        ]);


        $users = json_decode(File::get(database_path("data/usersData.json")), true);
        
        $companies = json_decode(File::get(database_path("data/companiesData.json")), true);

        foreach ($users as $index => $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'company_name' => $userData['company_name'],
                'email' => $userData['email'],
                'phone' => $userData['phone'],
                'whatsapp' => $userData['whatsapp'],
                'facebook' => $userData['facebook'],
                'instagram' => $userData['instagram'],
                'youtube' => $userData['youtube'],
                'password' => "User@12345", 
                'is_authorised'=> $userData["is_authorised"],
                "is_publicly_present"=>$userData["is_publicly_present"] ,
                "is_verified"=> $userData["is_verified"]
            ]);

            if(!empty($companies[$index])){
            $companyData = $companies[$index];
            
            if($companyData['_id'] == $users[$index]['_id']){
                $user->company()->create([
                    'company_name' => $companyData['company_name'],
                    'company_address' => $companyData['company_address'],
                    'company_city' => $companyData['company_city'],
                    'pin_code' => $companyData['pin_code'],
                    'company_website' => $companyData['company_website']
                    ]);
            }
            
            }

          
    }



}

}
