<?php

use Illuminate\Database\Seeder;
use App\Entities\Responsable;

class ResponsablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Responsable::create( [
            'id'=>1,
            'nombre'=>'Ignasi',
            'apellidos'=>'Gomis Mullor',
            'email'=>'igomis@gmail.com'
        ] );



        Responsable::create( [
            'id'=>2,
            'nombre'=>'Juan',
            'apellidos'=>'Segura Vasco',
            'email'=>'jsegura@gmail.com'
        ] );
    }
}
