<?php

namespace App\Http\Controllers\Api;

use App\Entities\Oferta;
use App\Http\Resources\OfertaResource;
use Illuminate\Http\Request;
use App\Entities\Alumno;
use App\Entities\Ciclo;

class OfertaController extends ApiBaseController
{
    use traitRelation;

    public function model(){
        return 'Oferta';
    }
    protected function relationShip()
    {
        return 'ciclos';
    }

    public function index()
    {
        return $this->filterIndex(false);
    }

    public function indexArxiu()
    {
        return $this->filterIndex(true);
    }

    private function filterIndex($archivada){
        if (AuthUser()->isEmpresa())
            return OfertaResource::collection(Oferta::BelongsToEnterprise(AuthUser()->id)->where('archivada',$archivada));
        if (AuthUser()->isAlumno()){
            $ofertasFinalitzat = OfertaResource::collection(Oferta::BelongsToCicles(Alumno::find(AuthUser()->id)->ciclos->where('pivot.validado','=',true)->where('pivot.any', '!=', null))
                ->where('validada',true)->where('activa',true)->where('estudiando',false)->where('archivada',false));
            $ofertas = $ofertasFinalitzat->concat(OfertaResource::collection(Oferta::BelongsToCicles(Alumno::find(AuthUser()->id)->ciclos->where('pivot.validado','=',true))
                ->where('validada',true)->where('activa',true)->where('estudiando',true)->where('archivada',false)));

            return $ofertas->values();// values devuelve un array en vez de un objeto
        }
        if (AuthUser()->isResponsable())
            return OfertaResource::collection(Oferta::BelongsToCicles(Ciclo::where('responsable',AuthUser()->id)->get())->where('archivada',$archivada));

        return OfertaResource::collection(Oferta::all())->where('archivada',$archivada);
    }

    public function alumnoInterested(Request $request,$id)
    {
        Oferta::find($id)->alumnos()->sync([AuthUser()->id =>['interesado'=>$request->interesado]]);
        return response($this->show($id),200);
    }



}

