<?php
/**
 * Created by PhpStorm.
 * User: igomis
 * Date: 2019-03-25
 * Time: 09:14
 */

namespace App\Entities;
use Illuminate\Database\Eloquent\Model;

abstract class Entity extends Model
{
    static public function rules(){
        return [];
    }
}

