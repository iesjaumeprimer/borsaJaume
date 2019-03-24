<?php

namespace App\Http\Controllers\Api;


class EmpresaController extends ApiBaseController
{



    public function rules(){
        return ['cif' => 'required'];
    }

    public function model(){
        return 'Empresa';
    }
}
