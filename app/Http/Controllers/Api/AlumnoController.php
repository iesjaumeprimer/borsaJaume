<?php

namespace App\Http\Controllers\Api;

use App\Entities\Alumne;



class AlumnoController extends ApiBaseController
{
    use traitRelation;

    public function model(){
        return 'Alumno';
    }
   protected function relationShip()
    {
        return 'ciclos';
    }

}


