<?php

use App\Setting;
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
        Setting::create([
            'logo' => 'site/assets/images/general/logo.png',
            'favicon' => 'site/assets/images/general/favicon.png',
            'company_name' => 'Betalaptops',
            'official_email' => 'info@betalaptops.com',
            'currency' => '₦',
        ]); 

        User::create([
            'name'
            'username'
            'role' => 'admin'
            'phone')->nullable(
            $table->integer('upline')->nullable(
            $table->integer('parent_id')->nullable(
            $table->integer('sponsor_id')->nullable(
            $table->integer('direct_downlines')->nullable(
            $table->integer('level')->nullable(
            $table->integer('two')->nullable(
            $table->integer('three')->nullable(
            $table->integer('four')->nullable(
            $table->integer('five')->nullable(
            $table->integer('six')->nullable(
            'avatar')->nullable(
        
            'email')->unique(
            $table->timestamp('email_verified_at')->nullable(
            'enrolled_by')->nullable(

            'password'
        ]);
    }
}
