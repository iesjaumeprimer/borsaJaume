<?php

use Illuminate\Database\Seeder;
use App\Entities\Oferta;

class OfertasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Oferta::create( [
            'id'=>1,
            'id_empresa'=>5,
            'descripcion'=>'estar de sol a sol picando',
            'puesto'=>'picar piedra',
            'tipo_contrato'=>'indefinido',
            'activa'=>1,
            'contacto'=>'Rosa Carbonell',
            'telefono'=>'123 123 123',
            'email'=>'empresa3@qw.es',
            'validada'=>0,
            'any'=>2012,
            'archivada'=>0
            ] );
            
            
                        
            Oferta::create( [
            'id'=>2,
            'id_empresa'=>5,
            'descripcion'=>'trabajar haciendo fotocopias',
            'puesto'=>'ayudante de dirección',
            'tipo_contrato'=>'parcial',
            'activa'=>1,
            'contacto'=>'Rosa Carbonell',
            'telefono'=>'123 123 123',
            'email'=>'empresa3@qw.es',
            'validada'=>1,
            'any'=>NULL,
            'archivada'=>1
            ] );
            
            
                        
            Oferta::create( [
            'id'=>3,
            'id_empresa'=>5,
            'descripcion'=>'pasear al perro',
            'puesto'=>'paseante',
            'tipo_contrato'=>'por obra o servicio',
            'activa'=>1,
            'contacto'=>'Rosa Carbonell',
            'telefono'=>'123 123 123',
            'email'=>'empresa3@qw.es',
            'validada'=>0,
            'any'=>2000,
            'archivada'=>0
            ] );
            
            
                        
            Oferta::create( [
            'id'=>4,
            'id_empresa'=>5,
            'descripcion'=>'coger el teléfono',
            'puesto'=>'ecepcionista',
            'tipo_contrato'=>'Parcial',
            'activa'=>1,
            'contacto'=>'Rosa Carbonell',
            'telefono'=>'123 123 123',
            'email'=>'empresa3@qw.es',
            'validada'=>1,
            'any'=>2012,
            'archivada'=>0
            ] );
            
            
                        
            Oferta::create( [
            'id'=>5,
            'id_empresa'=>4,
            'descripcion'=>'Programar webs de clientes',
            'puesto'=>'Programador web',
            'tipo_contrato'=>'Por horas',
            'activa'=>1,
            'contacto'=>'Joan Petit',
            'telefono'=>'123123123',
            'email'=>'empresa2@qw.es',
            'validada'=>1,
            'any'=>NULL,
            'archivada'=>0
            ] );
    }
}
