<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class Oferta extends Model
{
    public $timestamps = false;
    protected $table = 'ofertas';
    protected $fillable = [
            'id', 'id_empresa','descripcion','puesto','tipo_contrato', 'activa','contacto',
            'telefono','email','validada', 'any','archivada'
        ];

    public function Ciclos()
    {
        return $this->belongsToMany(Ciclo::class,'ofertas_ciclos', 'id_oferta', 'id_ciclo', 'id', 'id')->withPivot('any_fin');
    }
    public function Empresa(){
        return $this->belongsTo(Empresa::class,'id_empresa');
    }

    public function scopeBelongsToEnterprise($query,$idEmpresa){
        return $query->where('id_empresa', $idEmpresa);
    }
    public static function BelongsToCicles($ciclos){
        $ofertas = new Collection();
        foreach ($ciclos as $ciclo){
            foreach ($ciclo->ofertas as $oferta)
                if (!$ofertas->contains($oferta)) $ofertas->add($oferta);
        }
        return $ofertas;
    }
}