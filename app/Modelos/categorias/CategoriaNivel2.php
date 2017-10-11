<?php

namespace App\Modelos\categorias;

use Illuminate\Database\Eloquent\Model;

class CategoriaNivel2 extends Model
{
    protected $table = 'categorias_nivel2';
    protected $fillable = [
    	'id_categoria_nivel2',
    	'id_categoria_nivel1',
    	'categoria',
    	'slug',
    	'descripcion',
    	'orden'
    ];

    public $timestamps = false;
    protected $primaryKey = 'id_categoria_nivel2';


    public function empresas(){
    	return $this->hasMany('App\Modelos\empresas\CategoriaEmpresa', 'categorias_nivel2_id', 'id_categoria_nivel2');
    }
}
