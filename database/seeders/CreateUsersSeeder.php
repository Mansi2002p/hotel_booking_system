<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'first_name' => 'Admin',
                'last_name'  => 'Hotel',
                'email'      => 'admin@example.com',
                'role'       => 'admin',
                'moblieno'   => '123456789',
                'address'    => '123 Admin Street',
                'zipcode'    => '12345',
                'city'       => 'AdminCity',
                'state'      => 'AdminState',
                'country'    => 'India',
                'password'   => bcrypt('12345678'),
            ],
            [
                'first_name' => 'Sona',
                'last_name'  => 'Peter',
                'email'      => 'sona@gmail.com',
                'role'       => 'hotel_owner',
                'moblieno'   => '852963741',
                'address'    => '456 Hotel Street',
                'zipcode'    => '54321',
                'city'       => 'HotelCity',
                'state'      => 'HotelState',
                'country'    => 'India',
                'password'   => bcrypt('123456'),
            ],
            [
                'first_name' => 'John',
                'last_name'  => 'Doe',
                'email'      => 'john@gmail.com',
                'role'       => 'customer',
                'moblieno'   => '852963741',
                'address'    => '789 Customer Lane',
                'zipcode'    => '67890',
                'city'       => 'CustomerCity',
                'state'      => 'CustomerState',
                'country'    => 'India',
                'password'   => bcrypt('123456'),
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']], // check by email to avoid duplicates
                $userData
            );
        }
    }
}
