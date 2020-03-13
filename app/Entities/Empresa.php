<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Collection;


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

    

    public static function OfertasCiclo($alumno){
        $empresas = new Collection();
        foreach (Oferta::where('id_ciclo',AuthUser()->Ciclo->id)->get() as $oferta){
            $empresas->add($oferta->Empresa);
        }
        return $empresas;
    }

}
