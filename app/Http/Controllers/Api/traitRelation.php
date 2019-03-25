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
    protected function manageResponse($registro, Request $request)
    {
        $relation = $this->relationShip();
        $registro->$relation()->sync($this->validateRelation($request->$relation));
        return parent::manageResponse($registro, $request);
    }

    abstract protected function relationShip();
    protected function validateRelation($relations){
        return $relations;
    }
}