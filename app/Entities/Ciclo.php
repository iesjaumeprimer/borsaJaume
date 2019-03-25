<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class Ciclo extends Entity
{
    public $timestamps = false;
    protected $guarded = [];


    public function Ofertas()
    {
        return $this->belongsToMany(Oferta::class,'ofertas_ciclos', 'id_ciclo', 'id_oferta', 'id', 'id')->withPivot('any_fin');
    }
}