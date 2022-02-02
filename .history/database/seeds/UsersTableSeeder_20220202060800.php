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
            'logo' => 'images/site/default_logo.png',
            'favicon' => 'images/site/default_favicon.png',
            'company_name' => 'Monates',
            'official_email' => 'hello@monates.com',
            'currency' => '₦',
            'form_payment' => 1000,
            'forward_payment' => 5.99,
            'weekly_payment' => 0,
        ]); 
    }
}
