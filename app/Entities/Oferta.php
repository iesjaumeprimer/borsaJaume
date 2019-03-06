<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class Oferta extends Model
{
    public $timestamps = false;
    protected $table = 'ofertes';
    protected $guarded = [];

    public function Ciclos()
    {
        return $this->belongsToMany(Ciclo::class,'ofertas_ciclos', 'id_oferta', 'id_ciclo', 'id', 'id')->withPivot('any_fin');
    }
}