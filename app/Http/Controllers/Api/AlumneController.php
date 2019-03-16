<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Entities\Alumne;



class AlumneController extends ApiBaseResourceController
{

    protected $model = 'Alumne';
    protected $rules = ['nombre'=> 'required'];
    protected $relationShip = 'ciclos';

}
