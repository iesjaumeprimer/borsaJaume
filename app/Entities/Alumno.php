<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class Alumno extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'id', 'nombre','apellidos','email','domicilio', 'telefono','info',
        'bolsa','cv_enlace'
    ];

    public function Ciclos()
    {
        return $this->belongsToMany(Ciclo::class,'alumnos_ciclos', 'id_alumno',
            'id_ciclo', 'id', 'id')->withPivot(['any','validado']);
    }

    public function User()
    {
        return $this->hasOne(User::class,'id');
    }


}
