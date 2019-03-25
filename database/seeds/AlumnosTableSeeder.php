<?php

use Illuminate\Database\Seeder;

class AlumnosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Alumno::create( [
            'id'=>6,
            'nombre'=>'Alumno 1',
            'apellidos'=>'apellido 1',
            'domicilio'=>'Carrer La Sardina, 2\n03801 - Alcoi',
            'telefono'=>'123123123',
            'info'=>1,
            'bolsa'=>1,
            'cv_enlace'=>'http://linkedin.es/alumno1'
            ] );

        Alumno::create( [
            'id'=>7,
            'nombre'=>'Alumno 2',
            'apellidos'=>'apellido 2',
            'domicilio'=>'Carrer Del Ajo, 13\n03801 - Alcoi',
            'telefono'=>'123123123',
            'info'=>1,
            'bolsa'=>1,
            'cv_enlace'=>'http://linkedin.es/alumno2'
            ] );

    }
}
