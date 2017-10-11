<?php

namespace App\Modelos\empresas;

use Illuminate\Database\Eloquent\Model;

class Puntuacion extends Model
{
    protected $table = 'empresas_valoraciones';
    protected $primaryKey = 'id_empresa_valoracion';
    public $timestamps = false;

    protected $fillable = [
    	'id_empresa',
    	'id_usuario',
    	'comentario',
    	'valor',
    	'creado_fecha'
    ];

    protected $casts = [
    	'creado_fecha' => 'date'
    ];

    public function empresa(){
    	return $this->belongsTo('App\Modelos\empresas\Empresa', 'id_empresa');
    }

    public function usuario(){
    	return $this->belongsTo('App\User', 'id');
    }
}
