<?php

namespace App\Http\Controllers\Api;


class EmpresaController extends ApiBaseResourceController
{

    protected $model = 'Empresa';

    protected $rules = ['cif' => 'required'];


}
