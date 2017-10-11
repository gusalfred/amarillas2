<?php

namespace App\Modelos\empresas;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresas';
    protected $primaryKey = 'id_empresa';
    public $timestamps = false;

    protected $fillable = [
    	'nombre',
    ];

    public function categorias(){
    	return $this->hasMany('App\Modelos\empresas\CategoriaEmpresa', 'empresa_id', 'id_empresa');
    }

    public function comentario(){
    	return $this->hasMany('App\Modelos\empresas\Puntuacion', 'id_empresa', 'id_empresa');
    }

}
