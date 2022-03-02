<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $userdefaul = new User();
        $userdefaul->name = 'admin';
        $userdefaul->email = 'admin@admin.com';
        $userdefaul->password = Hash::make('12345678');
        $userdefaul->save();
    }
}
