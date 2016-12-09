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
            'name' => 'Lady Maria',
            'username' => 'Maria',
            'question' => 'Where am i located',
            'answer' => 'Astal Clocktower',
            'password' => bcrypt('default'),
            'active' => 1
        ]);
        DB::table('users')->insert([
            'name' => 'Gehrman',
            'username' => 'Admin',
            'question' => 'What is my title ',
            'answer' => 'The first hunter',
            'password' => bcrypt('admin'),
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
        // DB::table('security_questions')->insert([
        //     'question' => 'What was the name of your elementary / primary school?'
        // ]);
        // DB::table('security_questions')->insert([
        //     'question' => 'In what city or town does your nearest sibling live?'
        // ]);
        // DB::table('security_questions')->insert([
        //     'question' => 'Who is your favorite actor, musician, or artist?'
        // ]);
        // DB::table('security_questions')->insert([
        //     'question' => 'What is your favorite movie?'
        // ]);
        // DB::table('security_questions')->insert([
        //     'question' => 'In what city or town does your nearest sibling live?'
        // ]);
        // DB::table('security_questions')->insert([
        //     'question' => 'In what city or town does your nearest sibling live?'
        // ]);
    }
}
