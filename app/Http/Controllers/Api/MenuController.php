<?php

namespace App\Http\Controllers\Api;


class MenuController extends ApiBaseController
{

    public function model(){
        return 'Menu';
    }

    public function index(){
        return $this->resource::collection($this->entity::where('rol',9999)->orderBy('order')->get());
        return $this->resource::collection($this->entity::isRol(AuthUser()->rol)->orderBy('order')->get());
    }

}
