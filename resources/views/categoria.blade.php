@extends('layouts.interna')

@section('title') {{ $cat1->categoria }} @endsection

@section('content')

<div class="container" style="margin-top: 50px;">
    <div class="row" style="margin-top: 20px;">
        <ol class="breadcrumb">
            <li><a href="{{ url('/')  }}"><i class="fa fa-home"></i> amarillas365.com</a></li>
            <li class="active">{{ $cat1->categoria }}</li>
        </ol>
    </div>
    <div class="row banner-title animated fadeIn" style="background-image:url('/uploads/categorias/{{ isset($cat1->imagen) ? $cat1->imagen : 'no.jpg' }}')">
        <h3 >{{ $cat1->categoria }} </h3>
    </div>
    <div class="row" style="margin-top: 15px">
        <div class="col-md-8 com-sm-12">
         <div class="panel panel-search panel-default">
            <div class="panel-heading"><h5>Categorias incluidas<br><small style="color:white">Total: {{ $cat2->total() }}</small></span></h5></div>
                <div class="panel-body list-group">
                    @foreach ($cat2 as $row)
                            <a class="list-group-item" href="{{ url('/subcategoria/'.$row->slug) }}">{{ $row->categoria }}</a>
                    @endforeach
                    @if ( count($cat2) == 0)
                        <a class="list-group-item" href="#"> Sin resultados</a>
                    @endif
                </div>
            </div>
            <div class="text-center">
                {{ $cat2->appends(['q' => 'a'])->links() }}
                <p class="text-center">Resultados {{ $cat2->firstItem() }}-{{ $cat2->lastItem() }} de  {{ $cat2->total() }}</p>
            </div>
        </div>
        <div class="col-md-4 col-sm-12 ">
            <div style="margin-top: 50px;">
                @foreach ($avisos as $aviso)
                    <h5 style="font-size: 11px; color: #CCC; text-align: center;">Publicidad </h5>
                    <div>
                        @if($aviso->url) <a target="_blank" href="{{ $aviso->url }}"> @endif
                        <img src="{{ asset('uploads/avisos/'.$aviso->archivo) }}" class="img-responsive center-block">
                        @if($aviso->url) </a> @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

@endsection
