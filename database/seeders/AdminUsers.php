<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Webpatser\Uuid\Uuid;

class AdminUsers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'uuid'     => Uuid::generate()->string,
                'name'     => 'Lungelo Makhaya',
                'email'    => 'imadecode@gmail.com',
                'password' => Hash::make('password12345')
            ],
            [
                'uuid'     => Uuid::generate()->string,
                'name'     => 'John Doe',
                'email'    => 'john@gmail.com',
                'password' => Hash::make('password12345')
            ],
            [
                'uuid'     => Uuid::generate()->string,
                'name'     => 'Bruce Wayne',
                'email'    => 'bruce@gmail.com',
                'password' => Hash::make('password12345')
            ],
            [
                'uuid'     => Uuid::generate()->string,
                'name'     => 'Peter Paker',
                'email'    => 'peter@gmail.com',
                'password' => Hash::make('password12345')
            ],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert([
                'uuid'     => $user['uuid'],
                'name'     => $user['name'],
                'email'    => $user['email'],
                'password' => $user['password']
            ]);
        }
    }
}
