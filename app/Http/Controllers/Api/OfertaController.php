<?php

namespace App\Http\Controllers\Api;

use App\Entities\Oferta;
use App\Http\Resources\OfertaResource;
use Illuminate\Http\Request;

class OfertaController extends ApiBaseResourceController
{

    protected $model = 'Oferta';
    protected $rules = [];

    public function update(Request $request, $id)
    {
        $registro = Oferta::find($id);
        $this->validate($request, $this->rules);
        $registro->update($request->all());
        $registro->save();
        if ($request->ciclos){
            foreach ($request->ciclos as $idCiclo)
               $registro->Ciclos()->attach($idCiclo);
        }

        return response($registro,200);
    }
    public function index(){
        return OfertaResource::collection(Oferta::all());
    }
}

