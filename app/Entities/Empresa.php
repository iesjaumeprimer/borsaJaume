<?php

namespace App\Entities;


class Empresa extends Entity
{
    public $timestamps = true;
    
    protected $fillable = ['id','cif','nombre','domicilio','localidad','contacto','telefono','web','descripcion'];

    public function User()
    {
        return $this->hasOne(User::class,'id');
    }

    public function Ofertas()
    {
        return $this->hasMany(Oferta::class, 'id_empresa','id');
    }

    static public function rules()
    {
        return ['cif' => 'required'];
    }


}
