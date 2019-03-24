<?php

namespace App\Http\Controllers\Api;

use App\Entities\Oferta;
use App\Http\Resources\OfertaResource;
use Illuminate\Http\Request;
use App\Entities\Alumno;

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

        if (AuthUser()->isEmpresa())
            return OfertaResource::collection(Oferta::BelongsToEnterprise(AuthUser()->id)->get());
        if (AuthUser()->isAlumno())
            return OfertaResource::collection(Oferta::BelongsToCicles(Alumno::find(AuthUser()->id)->ciclos->where('pivot.validado','=',true)));
        if (AuthUser()->isResponsable())
            return OfertaResource::collection(Oferta.BelongsToFamlily(AuthUser()->id)->get());
        return parent::index();
    }

    public function alumnoInterested(Request $request,$id)
    {
        Oferta::find($id)->alumnos()->sync([AuthUser()->id =>['interesado'=>$request->interesado]]);
        return response($this->show($id),200);
    }



}

