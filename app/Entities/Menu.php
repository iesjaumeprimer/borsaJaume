<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class Menu extends Model
{
    public $timestamps = false;
    protected $table = 'menu';
    protected $guarded = [];
    
}
