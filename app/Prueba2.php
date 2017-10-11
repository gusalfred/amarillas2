<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Prueba2 extends Model
{
     use SoftDeletes;
     protected $table = 'prueba2';
     protected $fillable = [
           'nombres', 
           'apellidos', 
           'edad'
     ];

 	protected $dates = ['deleted_at'];	
}
