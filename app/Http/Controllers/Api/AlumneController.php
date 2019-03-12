<?php

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;
use App\Entities\Alumne;



class AlumneController extends ApiBaseResourceController
{

    protected $model = 'Alumne';
    protected $rules = [];


    public function update(Request $request, $id)
    {
        $registro = Alumne::find($id);
        $this->validate($request, $this->rules);
        $registro->update($request->all());
        $registro->save();
        $registro->ciclos()->sync($request->ciclos);

        return response($registro,200);
    }
}
