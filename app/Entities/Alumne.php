<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class Alumne extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function Ciclos()
    {
        return $this->belongsToMany(Ciclo::class,'alumnos_ciclos', 'id_alumno',
            'id_ciclo', 'id', 'id')->withPivot(['any','validado']);
    }
}
