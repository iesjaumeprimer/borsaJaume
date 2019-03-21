<?php

namespace App\Entities;


use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;


class User extends Authenticatable
{
    use HasApiTokens,Notifiable,SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','rol','active', 'activation_token',
    ];

    protected $dates = ['deleted_at'];
    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password','activation_token',
    ];

    protected $rules = [
        'name'     => 'required|string',
        'email'    => 'required|string|email|unique:users',
        'password' => 'required|string|confirmed',
        'rol'      => 'required'
    ];
}
