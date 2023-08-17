<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'full_name'=>'Super_Admin',
            'phone'=>'01000000000',
            'password'=>'super_admin',
            'type'=>'super_admin',
            'country_code'=>'02',
            'activation'=>'active',
            'otp_code'=>0000,
            'email'=>'Super_admin@gmail.com'
        ]);
    }
    }

