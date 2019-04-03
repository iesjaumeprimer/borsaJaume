<?php
/**
 * Created by PhpStorm.
 * User: igomis
 * Date: 2019-03-24
 * Time: 09:56
 */

namespace App\Http\Controllers\Api;
use Illuminate\Http\Request;

trait traitRelation
{
    protected function manageRelation($registro, Request $request)
    {
        $relation = $this->relationShip();
        $registro->$relation()->sync($request->$relation);
        $this->resource($registro);
    }

    abstract protected function relationShip();

}