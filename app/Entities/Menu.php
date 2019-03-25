<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class Menu extends Entity
{
    public $timestamps = false;
    protected $table = 'menu';
    protected $guarded = [];
    
}
