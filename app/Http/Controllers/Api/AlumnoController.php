<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Entities\Alumno;


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

    protected function validaCiclo(Request $request,$idAlumno,$idCiclo)
    {
        $alumno = Alumno::find($idAlumno);
        $any = $request->any;
        $validado = $request->validado;
        $alumno->Ciclos()->updateExistingPivot($idCiclo, ['any' => $any,'validado'=>$validado]);
        return parent::manageResponse($alumno, $request);
    }
}


