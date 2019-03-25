<?php

use Illuminate\Database\Seeder;
use App\Entities\Alumno;

class AlumnosCiclosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $alumno = Alumno::find(6);
        $alumno->ciclos()->attach(3,['any'=>2015,'validado'=>1]);
        $alumno->ciclos()->attach(4,['any'=>2012,'validado'=>0]);
        $alumno = Alumno::find(7);
        $alumno->ciclos()->attach(3,['any'=>2015,'validado'=>1]);
}
}
