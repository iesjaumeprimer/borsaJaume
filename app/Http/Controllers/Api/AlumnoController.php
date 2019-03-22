<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Entities\Alumne;



class AlumnoController extends ApiBaseResourceController
{

    protected $model = 'Alumno';
    protected $rules = ['nombre'=> 'required'];
    protected $relationShip = 'ciclos';

    protected function manageRelation($registro,Request $request)
    {
        $relation = $this->relationShip;
        $registro->$relation()->sync($this->removeValidado($request->$relation));
    }

    private function removeValidado($relations)
    {
        foreach ($relations as $index => $related){
            $array[$index]['validado'] = 0;
            foreach ($related as $key => $value)
                if ($key != 'validado') $array[$index][$key] = $value;
            return $array;
        }

    }
}


