<?php

namespace App\Http\Controllers\Api;


class MenuController extends ApiBaseController
{

    public function model(){
        return 'Menu';
    }

    public function index(){
        return $this->resource::collection($this->entity::orderBy('order')->get());
    }

}
