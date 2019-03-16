<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class Oferta extends Model
{
    public $timestamps = false;
    protected $table = 'ofertes';
    protected $fillable = [
            'id', 'id_empresa','descripcion','puesto','tipo_contrato', 'activa','contacto',
            'telefono','email','validada', 'any','archivada'
        ];

    public function Ciclos()
    {
        return $this->belongsToMany(Ciclo::class,'ofertas_ciclos', 'id_oferta', 'id_ciclo', 'id', 'id')->withPivot('any_fin');
    }

    public function getMyCiclosAttribute(){
        $array = [];
        foreach ($this->ciclos as $ciclo){
            $array[$ciclo->id] = $ciclo->pivot;
        }
        return $array;
    }
}