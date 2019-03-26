<?php

namespace App\Entities;


class Empresa extends Entity
{
    public $timestamps = false;
    
    protected $fillable = ['id','cif','nombre','domicilio','localidad','contacto','telefono','web','descripcion'];

    public function User()
    {
        return $this->hasOne(User::class,'id');
    }

    static public function rules()
    {
        return ['cif' => 'required'];
    }


}