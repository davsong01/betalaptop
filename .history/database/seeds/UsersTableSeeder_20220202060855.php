<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = Setting::create([
            'logo' => 'site/assets/images/general/logo.png',
            'favicon' => 'site/assets/images/general/favicon.png',
            'company_name' => 'Betalaptops',
            'official_email' => 'hello@betalaptop.com',
            'currency' => '₦',
            'form_payment' => 1000,
            'forward_payment' => 5.99,
            'weekly_payment' => 0,
        ]); 
    }
}
