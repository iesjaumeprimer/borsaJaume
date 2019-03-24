<?php

namespace App\Http\Controllers\Api;

use App\Entities\Alumne;



class AlumnoController extends ApiBaseController
{

    use traitRelation;

    public function model(){
        return 'Alumno';
    }

    public function rules(){
        return ['nombre'=> 'required'];
    }

    protected function relationShip()
    {
        return 'ciclos';
    }

    protected function validateRelation($relations)
    {
        foreach ($relations as $index => $related){
            $array[$index]['validado'] = 0;
            foreach ($related as $key => $value)
                if ($key != 'validado') $array[$index][$key] = $value;
        }
        return $array;

    }
}


