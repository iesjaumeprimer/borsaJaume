<?php

namespace App\Http\Controllers\Api;

use App\Entities\Oferta;
use App\Http\Resources\OfertaResource;
use Illuminate\Http\Request;
use App\Entities\Alumno;

class OfertaController extends ApiBaseResourceController
{

    protected $model = 'Oferta';
    protected $rules = [];
    protected $relationShip = 'ciclos';


    public function index()
    {

        if (AuthUser()->rol == config('role.empresa'))
            return OfertaResource::collection(Oferta::BelongsToEnterprise(AuthUser()->id)->get());
        if (AuthUser()->rol == config('role.alumno'))
            return OfertaResource::collection(Oferta::BelongsToCicles(Alumno::find(AuthUser()->id)->ciclos->where('pivot.validado','=',true)));
        if (AuthUser()->rol == config('role.responsable'))
            return OfertaResource::collection(Oferta.BelongsToFamlily(AuthUser()->id)->get());
        return parent::index();
    }

}

