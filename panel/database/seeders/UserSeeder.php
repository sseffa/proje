<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
            DB::table('users')->insert([
                'first_name' => "kullanıcı",
                'last_name' => "kullanıcı",
                'username' => "kullanici" . $i,
                'email' => "kullanici" . $i . '@kullanici.com',
                'type' => 'user',
                'password' => Hash::make('12345678'),
            ]);
        }
    }
}
