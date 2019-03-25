<?php

use Illuminate\Database\Seeder;

class AlumnosCiclosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Alumnosciclo::create( [
            'id'=>1,
            'id_alumno'=>6,
            'id_ciclo'=>3,
            'any'=>2015,
            'validado'=>1
            ] );

        Alumnosciclo::create( [
            'id'=>1,
            'id_alumno'=>6,
            'id_ciclo'=>3,
            'any'=>2015,
            'validado'=>1
            ] );

        Alumnosciclo::create( [
            'id'=>2,
            'id_alumno'=>6,
            'id_ciclo'=>5,
            'any'=>2012,
            'validado'=>0
            ] );

        Alumnosciclo::create( [
            'id'=>3,
            'id_alumno'=>7,
            'id_ciclo'=>3,
            'any'=>2015,
            'validado'=>1
            ] );

    }
}
