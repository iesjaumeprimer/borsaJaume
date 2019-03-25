<?php

use Illuminate\Database\Seeder;
use App\Entities\Empresa;

class EmpresasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Empresa::create( [
            'id'=>3,
            'cif'=>'111111111',
            'nombre'=>'Empresa 1',
            'domicilio'=>'Carrer La serreta ,6\n03802 Alcoi',
            'localidad'=>'Alcoi',
            'contacto'=>'Pep Cantó',
            'telefono'=>'123 123 123',
            'web'=>'http://we.rwe.es',
            'descripcion'=>NULL
            ] );
                        
            Empresa::create( [
            'id'=>4,
            'cif'=>'222222222',
            'nombre'=>'Empresa 2',
            'domicilio'=>'Carrer Societat Unió Musical, 8\n03802 Alcoi',
            'localidad'=>'Alcoi',
            'contacto'=>'Marta Pérez',
            'telefono'=>'234224234',
            'web'=>'http://asdas.es',
            'descripcion'=>NULL
            ] );
                        
            Empresa::create( [
            'id'=>5,
            'cif'=>'333333333',
            'nombre'=>'Empresa  3',
            'domicilio'=>'Carrer La Costera, 3\n46002 - Xàtiva',
            'localidad'=>'Xàtiva',
            'contacto'=>'Rosa Carbonell',
            'telefono'=>'123 123 123',
            'web'=>'qweqw.es',
            'descripcion'=>NULL
            ] );                        
    }
}
