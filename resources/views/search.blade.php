@extends('layouts.interna')
@section('title') Resultados de búsqueda @endsection
@section('content')

        <div class="container" style="margin-top: 50px;">

            <div class="row" style="margin-top: 20px;">
            <ol class="breadcrumb">
                <li><a href="{{ url('/')  }}"><i class="fa fa-home"></i> amarillas365.com</a></li>
                <li>Búsqueda: '{{$termino}}'</li>
            </ol>
                <div class="col-md-8 col-sm-12">
                @if(count($categorias) <= 0 && count($empresas) <= 0 && count($descripcion)<= 0)
                    <p class="variable-title"><i class="fa fa-search"></i> Sin resultados para "<span class="bg-info" style="border-radius: 8px">{{$termino}}</span>" </p>
                @else
                    <p class="variable-title"><i class="fa fa-search"></i> Resultados de la búsqueda para "<span class="bg-success" style="border-radius: 8px"> {{$termino}} </span>" </p>
                @endif                    
                    <div class="panel panel-search panel-default">
                        <div class="panel-heading"><h5>Por Categorías</h5></div>
                        <div class="panel-body list-group">
                            @foreach ($categorias as $row)
                                    <a class="list-group-item" href="{{ url('/subcategoria/'.$row->slug) }}">{{ $row->categoria }}</a>
                            @endforeach
                            @if ( count($categorias) == 0)
                                <a class="list-group-item" href="#"> Sin resultados</a>
                            @endif
                        </div>
                    </div>
                    <div class="panel panel-search panel-default">
                       <div class="panel-heading">
                           <h5>Por nombre de Empresas</h5>
                       </div>
                       <div class="panel-body list-group">
                           @foreach ($empresas as $row)
                               <a class="list-group-item" href="{{ URL::to('empresa/'.$row->id_empresa ) }}">{{ $row->nombre }}</a>
                           @endforeach
                           @if ( count($empresas) > 9)
                               <a class="list-group-item active" href=""><i class="fa fa-plus"></i> Ver Mas Resultados por Nombre </a>
                           @endif
                            @if ( count($empresas) == 0)
                                <a class="list-group-item" href="#"> Sin resultados</a>
                            @endif
                       </div>
                   </div>
                    <div class="panel panel-search panel-default">
                       <div class="panel-heading">
                           <h5>En Descripción </h5>
                       </div>
                       <div class="panel-body list-group">
                        @foreach ($descripcion as $row)
                                <a class="list-group-item" href="{{ url('/search/emp') }}">{{ $row->nombre }}</a>
                        @endforeach
                        @if ( count($descripcion) == 0)
                            <a class="list-group-item" href="#"> Sin resultados</a>
                        @endif
                       </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-12" >
                    <div style="font-size: 18px; margin-bottom: 15px;">Relacionados</div>
                </div>
            </div>
        </div>

@endsection
