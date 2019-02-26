<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class Empresa extends Model
{
    public $timestamps = false;
    protected $table = 'empreses';
    
    protected $guarded = [];
    
}