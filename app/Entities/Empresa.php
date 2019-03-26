<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class Empresa extends Entity
{
    public $timestamps = false;
    protected $fillable = [
        'id', 'cif', 'nombre','domicilio', 'localidad', 'contacto', 
        'telefono', 'web', 'descripcion'
    ];

    
    protected $guarded = [];

    public function User()
    {
        return $this->hasOne(User::class,'id');
    }

    static public function rules()
    {
        return ['cif' => 'required'];
    }


}