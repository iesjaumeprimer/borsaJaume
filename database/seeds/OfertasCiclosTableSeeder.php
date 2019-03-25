<?php

use Illuminate\Database\Seeder;

class OfertasCiclosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ofertasciclo::create( [
            'id'=>4,
            'id_oferta'=>1,
            'id_ciclo'=>3,
            'any_fin'=>NULL
            ] );            
                        
            Ofertasciclo::create( [
            'id'=>5,
            'id_oferta'=>1,
            'id_ciclo'=>4,
            'any_fin'=>NULL
            ] );
            
            
                        
            Ofertasciclo::create( [
            'id'=>6,
            'id_oferta'=>1,
            'id_ciclo'=>12,
            'any_fin'=>NULL
            ] );
            
            
                        
            Ofertasciclo::create( [
            'id'=>13,
            'id_oferta'=>2,
            'id_ciclo'=>3,
            'any_fin'=>NULL
            ] );
            
            
                        
            Ofertasciclo::create( [
            'id'=>14,
            'id_oferta'=>2,
            'id_ciclo'=>8,
            'any_fin'=>NULL
            ] );
            
            
                        
            Ofertasciclo::create( [
            'id'=>17,
            'id_oferta'=>2,
            'id_ciclo'=>30,
            'any_fin'=>NULL
            ] );
            
            
                        
            Ofertasciclo::create( [
            'id'=>18,
            'id_oferta'=>3,
            'id_ciclo'=>3,
            'any_fin'=>NULL
            ] );
            
            
                        
            Ofertasciclo::create( [
            'id'=>19,
            'id_oferta'=>4,
            'id_ciclo'=>8,
            'any_fin'=>NULL
            ] );
            
            
                        
            Ofertasciclo::create( [
            'id'=>20,
            'id_oferta'=>4,
            'id_ciclo'=>16,
            'any_fin'=>NULL
            ] );
            
            
                        
            Ofertasciclo::create( [
            'id'=>21,
            'id_oferta'=>5,
            'id_ciclo'=>3,
            'any_fin'=>NULL
            ] );
            
            
                        
            Ofertasciclo::create( [
            'id'=>24,
            'id_oferta'=>5,
            'id_ciclo'=>2,
            'any_fin'=>NULL
            ] );
            
    }
}
