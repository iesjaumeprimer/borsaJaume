<?php

use Illuminate\Database\Seeder;
use App\Entities\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create( [
            'name'=>'Administrador',
            'email'=>'jsegura@cipfpbatoi.es',
            'password'=> bcrypt('123456'),
            'rol' => 2,
            'active' => 1
        ] );
        User::create( [
            'name'=>'Informatica',
            'email'=>'igomis@cipfpbatoi.es',
            'password'=> bcrypt('123456'),
            'rol' => 3,
            'active' => 1
        ] );
    }
}
