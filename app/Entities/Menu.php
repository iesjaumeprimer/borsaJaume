<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class Menu extends Entity
{
    public $timestamps = false;
    protected $table = 'menu';
    protected $guarded = [];
    

    public static function isRol($rol){
        $menus = new Collection();
        foreach (Menu::all() as $menu){
            if ($menu->rol % $rol == 0) $menus->add($menu);
        }
        return $menus;
    }

}
