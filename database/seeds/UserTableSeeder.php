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
        DB::table('users')->insert([
            'name' => 'Lucian Marksman',
            'username' => 'Lucian',
            'question' => 'Who am i in this game',
            'answer' => bcrypt('The Marksman'),
            'password' => bcrypt('njhorizon'),
            'active' => 1
        ]);
        DB::table('users')->insert([
            'name' => 'Sheriff Kench',
            'username' => 'Jazzy',
            'question' => 'I shot the sheriff',
            'answer' => bcrypt('did you tho'),
            'password' => bcrypt('njhorizon'),
            'active' => 1
        ]);
         DB::table('roles')->insert([
            'name' => 'Admin',
            'display_name' => 'Administrator',
            'description' => 'The main admin of the app'
        ]);
        DB::table('role_user')->insert([
            'user_id' => 2,
            'role_id' => 1,
        ]);
        DB::table('categories')->insert([
            'name' => 'Art'
        ]);
        DB::table('categories')->insert([
            'name' => 'Abstract'
        ]);
        DB::table('categories')->insert([
            'name' => 'Cars'
        ]);
        DB::table('categories')->insert([
            'name' => 'Black and White'
        ]);
        DB::table('categories')->insert([
            'name' => 'Comedy'
        ]);
        DB::table('categories')->insert([
            'name' => 'Designs'
        ]);
        DB::table('categories')->insert([
            'name' => 'Drawings'
        ]);
        DB::table('categories')->insert([
            'name' => 'Gaming'
        ]);
        DB::table('categories')->insert([
            'name' => 'Logos'
        ]);
        DB::table('categories')->insert([
            'name' => 'Music'
        ]);
        DB::table('categories')->insert([
            'name' => 'Nature'
        ]);
        DB::table('categories')->insert([
            'name' => 'Landscape'
        ]);
        DB::table('categories')->insert([
            'name' => 'Politics'
        ]);
        DB::table('categories')->insert([
            'name' => 'Other'
        ]);
        DB::table('categories')->insert([
            'name' => 'Pets'
        ]);
        DB::table('categories')->insert([
            'name' => 'Quotes'
        ]);
        DB::table('categories')->insert([
            'name' => 'Memes'
        ]);
        DB::table('categories')->insert([
            'name' => 'Sports'
        ]);
        DB::table('categories')->insert([
            'name' => 'Technology'
        ]);
        DB::table('categories')->insert([
            'name' => 'Wildlife'
        ]);
    }
}
