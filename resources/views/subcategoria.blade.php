@extends('layouts.interna')

@section('title') {{ $cat2->categoria }} @endsection

@section('content')
<style>
    .panel{
        background:#f2f2f2;
    }
</style>
<div class="container" style="margin-top: 50px;">

    <div class="row" style="margin-top: 20px;">
            <ol class="breadcrumb ">
                <li><a href="{{ url('/')  }}"><i class="fa fa-home"></i> amarillas365.com</a></li>
                <li><a href="{{ url('/categoria/'.$cat1->slug)  }}">{{ substr($cat1->categoria, 0, 30) }} ...</a></li>
                <li class="active">{{ substr($cat2->categoria, 0, 30) }}...</li>
            </ol>
    <!--categorias-->
        <div class="col-md-8">
        @if($empresas->total() <= 0 )
            <h2 class="text-center"> Sin resultados <i class="fa fa-meh-o"></i></h2>
        @else
            @foreach ($empresas as $empresa)
                
                    @if( $empresa->id_aviso )
                        <h5 style="font-size: 11px; color: #CCC; text-align: center;margin:0px">Publicidad </h5>
                        <a href="{{ URL::to('empresa/'.$empresa->id_empresa_direccion.'/'.$empresa->slug) }}" >
                            <img src="{{ url('uploads/avisos/'.$empresa->archivo) }}" class="img-responsive center-block" alt="" style="margin-bottom:15px">
                        </a>                    
                    @endif
                    <div class="panel panel-default col-md-12">
                        <div class="panel-body ">
                        <!--titulo y estrellas--->
                            <div class="row">
                                <div class="col-md-10 col-sm-12">
                                    <h3 style="margin-top:0px" class="hidden-sm hidden-xs">
                                        <a href="{{ URL::to('empresa/'.$empresa->id_empresa_direccion.'/'.$empresa->slug) }}">{{ $empresa->nombre }}</a>
                                    </h3>
                                    <h4 style="margin-top:0px" class="hidden-md hidden-lg">
                                        <a href="{{ URL::to('empresa/'.$empresa->id_empresa_direccion.'/'.$empresa->slug) }}">{{ $empresa->nombre }}</a>
                                    </h4>
                                </div>
                                <div class="col-md-2 center-text">
                                    <div class="rateit" data-rateit-value="{{ $empresa->estrellas }}" data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                                </div>
                            </div>
                                <!--info telf y address-->
                            <div class="row">
                                 <div class="col-md-12">
                                    <p><i class="fa fa-map-marker"></i> {{ $empresa->direccion }}</p>
                                </div>
                                 <div class="col-md-12">
                                    <p><i class="fa fa-phone"></i> {{ $empresa->telefonos }}</p>
                                 </div>
                            </div>
                                <!--comentarios y social-->
                            <div class="row">
                                <div class="col-xs-8 col-md-10"><span class="box-comments">
                                    <i class="fa fa-comment-o" style="font-size: 14px;"></i> {{ count($empresa->comentarios) }} comentarios</span>
                                </div>
                                <div class="col-xs-4 col-md-2">
                                    <share-button></share-button>
                                </div>
                            </div>
                        </div>
                    </div>
            @endforeach
            @endif
            <!--paginador-->
             @if($empresas->total() > 0 )                
            <div class="text-center">
                {{ $empresas->appends(['q' => 'a'])->links() }}
                <p class="text-center">Resultados {{ $empresas->firstItem() }}-{{ $empresas->lastItem() }} de  {{ $empresas->total() }}</p>
            </div>
            @endif
        </div>
        <div class="col-md-4">
            <div style="font-size: 16px; margin-bottom: 15px; text-align: center;"> <b><i class="fa fa-hand-o-right"></i> Empresas Relacionadas</b></div>
                @foreach ($relacionados as $empresa)
                    <div class="panel panel-default col-md-12">
                        <div class="panel-body">
                            <p class="box-title" style="margin-top:0px" class="hidden-sm hidden-xs">
                                <a href="{{ URL::to('empresa/'.$empresa->id_empresa) }}">{{ $empresa->nombre }}</a>
                            </p>
                            <p>{{ $empresa->descripcion }}</p>
                            <div>
                                <div class="rateit relate" data-rateit-value=""  data-rateit-ispreset="true" data-rateit-readonly="true"></div>
                            </div>                        
                        </div>
                    </div>
                @endforeach
            
            
            @foreach ($avisos as $aviso)
                <div style="font-size: 11px; color: #CCC; text-align: center;">Publicidad </div>
                <div style="margin: 3px 0 20px 0;">
                    @if($aviso->url) <a target="_blank" href="{{ $aviso->url }}"> @endif
                        <img src="{{ asset('uploads/avisos/'.$aviso->archivo) }}" class="img-responsive">
                        @if($aviso->url) </a> @endif
                </div>
            @endforeach

        </div>
    </div>
</div>
    <script>
     function randomNum(min,max){
            return (Math.random() * (max - min) + min).toFixed(2);
        }
        $('.relate ').each(function(){
        $(this).attr('data-rateit-value',randomNum(0,5));
        });
    </script>

@endsection
