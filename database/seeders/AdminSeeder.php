<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $admin = Admin::updateOrCreate([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'phone' => '01026051966',
            'account_type' => 0,
            'password' => Hash::make('password'),
        ]);

        $token = $admin->createToken('authToken')->plainTextToken;
    }
}