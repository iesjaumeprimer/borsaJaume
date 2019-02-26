<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class Oferta extends Model
{
    public $timestamps = false;
    protected $table = 'ofertes';
    protected $guarded = [];
    
}