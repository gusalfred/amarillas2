<?php

namespace App\Modelos\empresas;

use Illuminate\Database\Eloquent\Model;

class CategoriaEmpresa extends Model
{
    protected $table = 'empresas_categorias';
    protected $primaryKey = 'id_empresa_categoria';
    protected $fillable = [
    	'empresa_id',
    	'id_categoria_nivel2'
    ];

    public $timestamps = false;

    public function categoria(){
    	return $this->belongsTo('App\Modelos\categorias\CategoriaNivel2', 'id_categoria_nivel2');
    }

    public function empresa(){
    	return $this->belongsTo('App\Modelos\empresas\Empresa', 'id_empresa');
    }
}
