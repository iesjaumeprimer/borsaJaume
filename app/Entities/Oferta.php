<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Collection;
use App\Notifications\ValidateOffer;


class Oferta extends Entity
{
    public $timestamps = false;
    protected $table = 'ofertas';
    protected $fillable = [
            'id', 'id_empresa','descripcion','puesto','tipo_contrato', 'activa','contacto',
            'telefono','email', 'any','estudiando','archivada'
        ];

    public function Ciclos()
    {
        return $this->belongsToMany(Ciclo::class,'ofertas_ciclos', 'id_oferta', 'id_ciclo', 'id', 'id')->withPivot('any_fin');
    }
    public function Alumnos()
    {
        return $this->belongsToMany(Alumno::class,'ofertas_alumnos', 'id_oferta', 'id_alumno', 'id', 'id')->withPivot('interesado');
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

    public function adviseResponsibles()
    {
        foreach ($this->Ciclos as $ciclo){
            $ciclo->Responsable->notify(new ValidateOffer($this->id));
        }
    }

    public function adviseStudents()
    {
        foreach ($this->lookStudents() as $alumno){
            User::find($alumno)->notify(new ValidateOffer($this->id));
        }
    }

    private function lookStudents(){
        $ciclos = hazArray($this->Ciclos,'id','id');
        $any = $this->any_fin?$oferta->any_fin:9999;
        if (!$this->estudiando)
            return DB::table('alumnos_ciclos')
                ->select('idAlumno')
                ->distinct()
                ->whereIn('id_ciclo',$ciclos)
                ->where('validado',1)
                ->where('any','>=',$any)
                ->get();

        return DB::table('alumnos_ciclos')
            ->select('idAlumno')
            ->distinct()
            ->whereIn('id_ciclo',$ciclos)
            ->where('validado',1)
            ->get();
    }

}