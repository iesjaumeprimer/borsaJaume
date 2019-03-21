<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Entities\Alumne;



class AlumnoController extends ApiBaseResourceController
{

    protected $model = 'Alumno';
    protected $rules = ['nombre'=> 'required'];
    protected $relationShip = 'ciclos';

}
