<?php

namespace App\Entities;

class Alumno extends Entity
{
    public $timestamps = false;
    protected $fillable = [
        'id', 'nombre','apellidos','domicilio', 'telefono','info',
        'bolsa','cv_enlace'
    ];

    public function Ciclos()
    {
        return $this->belongsToMany(Ciclo::class,'alumnos_ciclos', 'id_alumno',
            'id_ciclo', 'id', 'id')->withPivot(['any','validado']);
    }

    public function CiclosValidos()
    {
        return $this->belongsToMany(Ciclo::class,'alumnos_ciclos', 'id_alumno',
            'id_ciclo', 'id', 'id')
            ->wherePivot('validado',1)
            ->withPivot('any');
    }


    public function User()
    {
        return $this->hasOne(User::class,'id');
    }

    public static function rules(){
        return ['nombre'=> 'required'];
    }

}
