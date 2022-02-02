<?php

use App\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('123456');
        
        Setting::create([
            'logo' => 'site/assets/images/general/logo.png',
            'favicon' => 'site/assets/images/general/favicon.png',
            'company_name' => 'Betalaptops',
            'official_email' => 'info@betalaptops.com',
            'currency' => '₦',
        ]); 

        //Create default admin
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'role' => 'admin',
            'phone' => '08180010243',
            'avatar' => 'site/assets/images/avatars/1.png',
            'email_verified_at' => '00-00-0000 00:00:00',
         

            'password' => $password
        ]);
    }
}
