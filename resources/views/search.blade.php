@extends('layouts.interna')

@section('content')

        <div class="container" style="margin-top: 50px;">

            <div class="row" style="margin-top: 10px;">
                <div class="col-md-8 col-sm-12">
                    <h3><i class="fa fa-search"></i> Resultados de la búsqueda</h3>
                    <div class="panel panel-search panel-default">
                        <div class="panel-heading"><h5>Por Categorias</h5></div>
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
                               <a class="list-group-item" href="{{ URL::to('empresa/'.$row->id_empresa_direccion.'/'.$row->nombre ) }}">{{ $row->nombre }}</a>
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
                           <h5>En Descripcion </h5>
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
