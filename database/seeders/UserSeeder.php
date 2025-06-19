<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Foundation\Auth\User as AuthUser;
use User as GlobalUser;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Bendahara',
            'email' => 'bendahara@gmail.com',
            'password' => bcrypt('123456'),
            'role' => 'bendahara'
        ]);

        User::create([
            'name' => 'Ketua Yayasan',
            'email' => 'ketua@gmail.com',
            'password' => bcrypt('654321'),
            'role' => 'ketua'
        ]);
    }
}
