<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiteController extends Controller
{
    public function index()
    {
        $categorias = DB::table('categorias_nivel1')
        ->inRandomOrder()
        ->limit(6)
        ->get();

        $main = DB::table('categorias_nivel1')->orderBy('categoria')->paginate(40);

        return view('home', compact('categorias', 'main') );
    }
    public function allCategories()
    {
        $letra='';
        if(isset($_GET['letter'])){
            $letra=$_GET['letter'];
            $categorias = DB::table('categorias_nivel1')->where('categoria','like',$letra.'%')->get();
        }else{
            $categorias =  DB::table('categorias_nivel1')->get();           
        }
        //dd($letra);
        return view('categorias',compact('categorias','letra'));
        
    }
    public function search()
    {
        $termino = $_GET['q'];

        $categorias = DB::table('categorias_nivel2')->where('categoria', 'like', '%'.$termino.'%')->paginate(10);

        //$empresas = DB::table('empresas')->where('nombre', 'like', '%'.$q.'%')->paginate(10);

        $empresas = DB::table('empresas')
            ->join('empresas_direcciones', 'empresas.id_empresa', '=', 'empresas_direcciones.id_empresa')
            ->where('nombre', 'like', '%'.$termino.'%')->paginate(10);

        $descripcion = DB::table('empresas')->where('descripcion', 'like', '%'.$termino.'%')->paginate(10);

        return view('search', compact('categorias', 'empresas', 'descripcion' ,'termino'));
    }

    public function categoria($slug)
    {
        $cat1 = DB::table('categorias_nivel1')->where('slug', $slug)->first();

        $cat2 = DB::table('categorias_nivel2')->where('id_categoria_nivel1', $cat1->id_categoria_nivel1)->paginate(15);

        $avisos = DB::table('avisos')
            ->join('avisos_categorias', 'avisos.id_aviso', '=', 'avisos_categorias.id_aviso')
            //->join('avisos_ubicaciones', 'avisos.id_aviso', '=', 'avisos_ubicaciones.id_aviso')
            ->where('id_categoria_nivel1', $cat1->id_categoria_nivel1)
            ->limit(4)
            ->inRandomOrder()
            ->get();

        return view('categoria', compact('cat1','cat2', 'avisos') );
    }

    public function subcategoria($slug)
    {
        $cat2 = DB::table('categorias_nivel2')->where('slug', $slug)->first();

        $cat1 = DB::table('categorias_nivel1')->where('id_categoria_nivel1', $cat2->id_categoria_nivel1)->first();
        
        $empresas = DB::table('empresas_categorias')
            ->join('empresas', 'empresas_categorias.id_empresa', '=', 'empresas.id_empresa')
            ->join('empresas_direcciones', 'empresas_categorias.id_empresa', '=', 'empresas_direcciones.id_empresa')
            ->where('id_categoria_nivel2', $cat2->id_categoria_nivel2)
            ->paginate(10);
        
        //->select('empresas_categorias.id_empresa',DB::raw(' Count(empresas_valoraciones.id_empresa_valoracion) AS totalcomment'))
        //dd($empresas);

        $relacionados = DB::table('empresas_direcciones')
            ->join('empresas', 'empresas_direcciones.id_empresa', '=', 'empresas.id_empresa')
            ->join('empresas_categorias', 'empresas_direcciones.id_empresa', '=', 'empresas_categorias.id_empresa')
            ->join('categorias_nivel2', 'empresas_categorias.id_categoria_nivel2', '=', 'categorias_nivel2.id_categoria_nivel2')
            ->where('id_categoria_nivel1', $cat1->id_categoria_nivel1)
            ->limit(4)
            ->get();
        
        $avisos = DB::table('avisos')
                ->join('avisos_categorias', 'avisos.id_aviso', '=', 'avisos_categorias.id_aviso')
                ->join('empresas', 'avisos.id_empresa', '=', 'empresas.id_empresa')
                ->where('id_categoria_nivel2', $cat2->id_categoria_nivel2)
                ->inRandomOrder()
                ->limit(4)
                ->get();
        
        
        return view('subcategoria', compact('cat1', 'cat2', 'empresas','relacionados', 'avisos','comentarios'));
            
    }

    public function empresa($id)
    {
        $empresa = DB::table('empresas')
            ->join('empresas_direcciones', 'empresas.id_empresa', '=', 'empresas_direcciones.id_empresa')
            ->join('empresas_categorias', 'empresas.id_empresa', '=', 'empresas_categorias.id_empresa')
            ->where('empresas.id_empresa', $id)->first();
            $id_empresa = $empresa->id_empresa;
        
        $cat2= DB::table('empresas_categorias')
        ->join('categorias_nivel2','empresas_categorias.id_categoria_nivel2','=','categorias_nivel2.id_categoria_nivel2')
        ->where('id_empresa',$id_empresa)->get();
        //dd($cat2);
        
        $direcciones = DB::table('empresas_direcciones')->where('id_empresa', $id_empresa)->get();

        $imagen = DB::table('empresas_media')->where([
            ['id_empresa', $id_empresa]
            ])->first();

        $imagenes = DB::table('empresas_media')->where('id_empresa', $id_empresa)->get();


        $redes = DB::table('empresas_redes')
            ->join('redes_sociales', 'empresas_redes.id_red_social', '=', 'redes_sociales.id_red_social')
            ->where('id_empresa', $id_empresa)->get();
        
        $valor=DB::table('empresas_valoraciones')
            ->join('users', 'users.id', '=', 'empresas_valoraciones.id_usuario')
            ->where('id_empresa', $id_empresa)
            ->avg('valor');
            
            
        $comentarios = DB::table('empresas_valoraciones')
            ->join('users', 'users.id', '=', 'empresas_valoraciones.id_usuario')
            ->where('id_empresa', $id_empresa)
            ->orderBy('creado_fecha','desc')
            ->paginate(6);

        return view('empresa', compact('empresa','cat2','direcciones', 'imagenes', 'imagen', 'redes', 'comentarios','valor') );
    }

    public function registro_empresa()
    {
        $data = "";
        return view('registro_empresa', compact('data'));
    }

    public function comentar(Request $request)
    {
        $id_usuario = Auth::id();
        $id_empresa = $request->input('id_empresa');
        $comentario = $request->input('comentario');
        $valor = $request->input('valor');

        $datos = [
            'id_empresa' => $id_empresa,
            'id_usuario' => $id_usuario,
            'comentario' => $comentario,
            'creado_fecha' => DB::raw('now()'),
            'valor' => $valor
        ];

        DB::table('empresas_valoraciones')->insert($datos);

        return redirect()->action(
            'SiteController@empresa', ['id' => $id_empresa]
        );
    }

}
