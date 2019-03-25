<?php

use Illuminate\Database\Seeder;
use App\Entities\Oferta;

class OfertasCiclosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $oferta = Oferta::find(1);
        $oferta->ciclos()->attach(3);
        $oferta->ciclos()->attach(4);
        $oferta->ciclos()->attach(12);
        $oferta = Oferta::find(2);
        $oferta->ciclos()->attach(8);
        $oferta->ciclos()->attach(30);
        $oferta = Oferta::find(3);
        $oferta->ciclos()->attach(3);
        $oferta = Oferta::find(4);
        $oferta->ciclos()->attach(8);
        $oferta->ciclos()->attach(16);
        $oferta = Oferta::find(5);
        $oferta->ciclos()->attach(2);
    }
}
