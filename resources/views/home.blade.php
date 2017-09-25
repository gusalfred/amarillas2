@extends('layouts.app')

@section('title') P&aacute;ginas Amarillas de Peru en Internet @endsection

@section('content')
        <!-- Portfolio Grid Section -->
<section id="portfolio" class="bg-light-gray">
    <div class="container">
    <div class="row">
        <h3 class="col-md-12 hidden-sm hidden-xs" style="margin-top:0px"> O héchale un vistazo a cualquiera de estas categorías <i class="fa fa-level-down"></i></h3>
        <h5 class="col-md-12 hidden-md hidden-lg" style="margin-top:0px"> O héchale un vistazo a cualquiera de estas categorías <i class="fa fa-level-down"></i></h5>
    </div>
        <div class="row">
            <?php $row = 1; ?>
            @foreach ($categorias as $categoria)
            <div class="col-sm-6 col-md-4 portfolio-item">
                <a href="{{ url('categoria/'.$categoria->slug) }}" class="portfolio-link" data-toggle="modal">
                    <div class="portfolio-hover">
                        <div class="portfolio-hover-content">
                            <i class="fa fa-plus fa-3x"></i>
                        </div>
                    </div>
                    <img src="uploads/categorias/{{ isset($categoria->imagen) ? $categoria->imagen : 'no.jpg' }}" style="width:100%" class="img-responsive">
                </a>
                <div class="portfolio-caption">
                    <h4 style="height: 40px;">{{ $categoria->categoria }}</h4>
                </div>
            </div>
            <?php $row++; ?>
            @endforeach

        </div>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <img src="images/banners/ad-960x90.png" class="img-responsive" />
        </div>
    </div>
</div>

<div class="container" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="row">
        <div class="col-md-4 col-sm-6 center-block" style="margin-bottom: 15px;">
            <img src="images/banners/sociales.jpg" class="img-responsive center-block" />
        </div>
        <div class="col-sm-8">
            <img src="images/banners/burger.jpg" class="img-responsive" />
            <div class="portfolio-caption" style="background-color: #f7f7f7;">
                <h4>Bon burger</h4>
                <p class="text-muted">Calle 74 Entre Av. 3G y 3H, Maracaibo - Venezuela ></p>
            </div>
        </div>
    </div>
</div>

<div class="container" style="margin-top: 20px; margin-bottom: 20px;">
    <div class="row">
    <div class="col-sm-12">
        <h5 style="margin-top:0px" ><i class="fa fa-list"></i> Todas las categorias</h5>
    </div>
        @foreach ($main as $row)
        <div class="col-sm-12 col-md-3 cat-list" style="margin: 5px 0;">
            <a href="{{ url('/categoria/'.$row->slug) }}"> {{ $row->categoria }}</a>
        </div>
        @endforeach
    </div>
</div>

@endsection
