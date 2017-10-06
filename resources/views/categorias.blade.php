@extends('layouts.interna')

@section('title') categorias @endsection

@section('content')

<div class="container" style="margin-top: 50px;">
    <div class="row" style="margin-top: 20px;">
        <ol class="breadcrumb">
            <li><a href="{{ url('/')  }}"><i class="fa fa-home"></i> amarillas365.com</a></li>
            <li class="active">todas las categorias</li>
        </ol>
    </div>
    <div class="row" style="margin-top: 15px">
        <div class="col-sm-1 text-center" style="margin-bottom:10px">
        <a class="btn btn-default" href="{{ url('/categorias') }}" >Todas</a>
        </div>
        <div class="col-sm-11 text-center" id="paginatorContainer" >
            <div class="btn-group btn-group-justified letterPaginator" id="boton">
                @foreach(range('A','Z') as $letter)
                    @if($letter == $letra)
                        <a class="btn btn-primary" href="{{ url('/categorias/?letter='.$letter) }}">{{$letter}}</a>
                    @else
                        <a class="btn btn-default" href="{{ url('/categorias/?letter='.$letter) }}">{{$letter}}</a>
                    @endif     
                @endforeach
            </div>
        </div>
    </div>
    <div class="row" id="portfolio" style="margin-top:20px">
        @if(count($categorias) > 0)
            @foreach($categorias as $cat)
                <div class="col-sm-6 col-md-3 portfolio-item">
                    <div class="jumbotron" style="padding:0px">
                        <div class="jumbotron-photo">
                            <a href="{{ url('categoria/'.$cat->slug) }}" class="portfolio-link">
                                <div class="portfolio-hover">
                                    <div class="portfolio-hover-content">
                                        <i class="fa fa-plus fa-3x"></i>
                                    </div>
                                </div>
                                <img src="uploads/categorias/{{ isset($cat->imagen) ? $cat->imagen : 'no.jpg' }}" style="width:100%" class="img-responsive">
                            </a>
                        </div>
                        <div class="jumbotron-contents portfolio-caption" >
                            <h4 style="height: 40px;">{{ $cat->categoria }}</h4>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <h3 class="text-center fullheight"><i class="fa fa-meh-o"></i> Sin resultados</h3>
        @endif
    </div>
</div>
<script>
         /* $('.btn-group a').slice(2,-2).hide();
        $('.btn-primary').show();
        $('.btn-primary').prev().show();
        $('.btn-primary').next().show();
      
        $('.btn-group a ').last().prev().addClass('prev');
        $('.btn-group a ').first().next().addClass('prev');
        $('.btn-group a ').not('.prev , .next, .disabled, .btn-primary').hide();*/
</script>
@endsection
