<?php

use Illuminate\Database\Seeder;

use App\User;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->username = 'Bones';
        $user->question = 'Some Nights';
        $user->answer = 'Fun';
        $user->password = bcrypt('somebones');
        $user->save();
    
        $admin = new User();
        $admin->username = 'Admin';
        $admin->question = 'Who runs things in here';
        $admin->answer = 'Cream';
        $admin->password = bcrypt('1800thasherlock');
        $admin->save();
    }
}
