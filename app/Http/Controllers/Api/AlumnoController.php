<?php

namespace App\Http\Controllers\Api;

use App\Entities\Ciclo;
use App\Http\Resources\AlumnoResource;
use Illuminate\Http\Request;
use App\Entities\Alumno;
use App\Notifications\ValidateStudent;


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
        $alumno->Ciclos()->updateExistingPivot($idCiclo, ['any' => $request->any,'validado'=>$request->validado]);
        return parent::manageResponse($alumno, $request);
    }

    protected function adviseSomeOne($registro){
        foreach ($registro->ciclosNoValidos as $ciclo){
            $ciclo->Responsable->notify(new ValidateStudent($ciclo));
        }
    }

    public function index()
    {
        if (AuthUser()->isResponsable())
            return AlumnoResource::collection(Alumno::BelongsToCicles(Ciclo::where('responsable',AuthUser()->id)->distinct()->get()));

        return parent::index();
    }



}


