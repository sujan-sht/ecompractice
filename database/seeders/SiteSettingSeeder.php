<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('site_settings')->insert([
            'title' => 'site title goes here',
            'address' => 'address goes here',
            'contact' => '9825362525',
            'email' => 'test@test.com',
            'footer' => 'footer goes here'
        ]);
    }
}
