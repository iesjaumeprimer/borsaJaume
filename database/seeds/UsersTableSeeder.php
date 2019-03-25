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
            'id'=>1,
            'name'=>'Administrador',
            'email'=>'jsegura@cipfpbatoi.es',
            'password'=> bcrypt('123456'),
            'rol' => 2,
            'active' => 1
        ] );
        User::create( [
            'id'=>2,
            'name'=>'Informatica',
            'email'=>'igomis@cipfpbatoi.es',
            'password'=> bcrypt('123456'),
            'rol' => 3,
            'active' => 1
        ] );
        User::create( [
            'id'=>3,
            'name'=>'Empresa prueba 1',
            'email'=>'empresa1@cipfpbatoi.es',
            'password'=> bcrypt('123456'),
            'rol' => 5,
            'active' => 1
        ] );
        User::create( [
            'id'=>4,
            'name'=>'Empresa prueba 2',
            'email'=>'empresa2@cipfpbatoi.es',
            'password'=> bcrypt('123456'),
            'rol' => 5,
            'active' => 1
        ] );
        User::create( [
            'id'=>5,
            'name'=>'Empresa prueba 3',
            'email'=>'empresa3@cipfpbatoi.es',
            'password'=> bcrypt('123456'),
            'rol' => 5,
            'active' => 1
        ] );
        User::create( [
            'id'=>6,
            'name'=>'Alumno prueba 1',
            'email'=>'alumno1@cipfpbatoi.es',
            'password'=> bcrypt('123456'),
            'rol' => 7,
            'active' => 1
        ] );
        User::create( [
            'id'=>7,
            'name'=>'Alumno prueba 2',
            'email'=>'alumno2@cipfpbatoi.es',
            'password'=> bcrypt('123456'),
            'rol' => 7,
            'active' => 1
        ] );
    }
}
