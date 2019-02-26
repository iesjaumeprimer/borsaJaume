<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiBaseController;
use App\Http\Resources\Menu as MenuResource;
use App\Entities\Menu;
use App\Http\Controllers\Controller;

class MenuController extends ApiBaseController
{

    protected $model = 'Menu';

    public function index(){
        return new MenuResource(Menu::all());
    }


}
