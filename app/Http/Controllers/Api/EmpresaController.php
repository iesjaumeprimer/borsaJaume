<?php

namespace App\Http\Controllers\Api;

use App\Entities\Empresa;

class EmpresaController extends ApiBaseController
{

    public function model(){
        return 'Empresa';
    }
}
