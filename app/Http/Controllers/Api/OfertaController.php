<?php

namespace App\Http\Controllers\Api;

use App\Entities\Oferta;
use App\Http\Resources\OfertaResource;
use Illuminate\Http\Request;

class OfertaController extends ApiBaseResourceController
{

    protected $model = 'Oferta';
    protected $rules = [];
    protected $relationShip = 'ciclos';




}

