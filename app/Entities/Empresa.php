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

    public static function OfertasCiclo($alumno){
        return $empresa->Ofertas->where('pivot.interesado',1)->where('id_empresa',$empresa)->where('archivada',0)->get();
    }

    public static function OfertasCiclo($alumno){
        $empresas = new Collection();
        foreach (Oferta::where('id_ciclo',AuthUser()->Ciclo->id)->get() as $oferta){
            $empresas->add($oferta->Empresa);
        }
        return $empresas;
    }

}
