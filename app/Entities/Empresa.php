<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;


class Empresa extends Model
{
    public $timestamps = false;
   
    
    protected $guarded = [];

    public function User()
    {
        return $this->hasOne(User::class,'id');
    }
    
}