<?php

use App\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::get();
        if( is_null($user) ) {
            $user = new User([
                'name' => 'Leandro Leiva',
                'email' => 'admin@mail.com',
                'password' => bcrypt('123123'),
            ]);
            $user->save();
        }
    }
}
