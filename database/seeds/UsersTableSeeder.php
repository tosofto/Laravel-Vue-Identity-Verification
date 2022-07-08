<?php
use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'email' => 'AlexRossitha99@gmail.com',
            'first_name' => 'Alex',
            'last_name' => "Rossi",
            'role' => 'admin',
            'password' => Hash::make('IvanP.9899'),
            'gender' => 'male',
            'picture' => '...',
            'id_number' => '...',
            'serial_number' => '...',
            'validity_period' => '...',
            'company' => '...',
            'region' => '...',
            'verification_result' => 'nonactivated',
            'health_status' => 'normal',
            'remark_information' => '...'
        ]);

        User::create([
            'email' => 'SergeyLee199885@gmail.com',
            'first_name' => 'Sergey',
            'last_name' => "Lee",
            'role' => 'practitioner',
            'password' => Hash::make('IvanP.9899'),            
            'gender' => 'male',
            'picture' => '...',
            'id_number' => '...',
            'serial_number' => '...',
            'validity_period' => '...',
            'company' => '...',
            'region' => '...',
            'verification_result' => 'nonactivated',
            'health_status' => 'normal',
            'remark_information' => '...'
        ]);

        User::create([
            'email' => 'IvanPetrovich199899@gmail.com',
            'first_name' => 'Ivan',
            'last_name' => 'Petrovich',
            'role' => 'practitioner',
            'password' => Hash::make('IvanP.9899'),            
            'gender' => 'male',
            'picture' => '...',
            'id_number' => '...',
            'serial_number' => '...',
            'validity_period' => '...',
            'company' => '...',
            'region' => '...',
            'verification_result' => 'nonactivated',
            'health_status' => 'normal',
            'remark_information' => '...'
        ]);
    }
}
