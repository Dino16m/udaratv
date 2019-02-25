<!DOCTYPE html>
<html>
<head>
    <title>Udara Tv</title>
    <meta name="csrf-token" content="{{csrf_token()}}" >
    <link rel="stylesheet" type="text/css" href="{{ url('public/css/app.css')}}">
    <link rel="stylesheet" href="<?php echo url('public/css/style.css')?>" type="text/css">
    <link rel="stylesheet" href="<?php echo url('public/css/style2.css')?>" type="text/css">
    <style type="text/css">
        body {
            padding-top: 2rem;
            height: auto;
        }

        .starter-template {
            padding: 3rem 1.5rem;
            text-align: center;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="og:type" property="og:type" content="website">
    <meta name="og:title" property="og:title" content="Udara Tv - download nollywood Movies and series, download hollywood movies and series, Anime, Asian/Korean/Japanese/Chinese Movies movie {{$name}}">
    <meta name="og:description" property="og:description" content="download movie {{$name}} ">
    <meta name="og:image" property="og:image" content="{{$image_link}}">
    <link rel="icon" href="<?php echo url('public/images/udaralogo.png')?>">
     <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-132811731-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-132811731-1');
    </script>
    <!--End of google analytics-->
    <!--ad network-->
        <script data-cfasync="false">
            (function(E,n,G,A,g,Y,a){E['EngageyaObject']=g;E[g]=E[g]||function(){ (E[g].q=E[g].q||[]).push(arguments)},E[g].l=1*new Date();Y=n.createElement(G), a=n.getElementsByTagName(G)[0];Y.async=1;Y.src=A;a.parentNode.insertBefore(Y,a)})(window,document,'script','//widget.engageya.com/engageya_loader.js','__engWidget');
            __engWidget('createWidget',{wwei:'ENGAGEYA_WIDGET_125611',pubid:191419,webid:195234,wid:125611});
        </script>
    <!--end of ad-->
</head>
<body>
<div id="app">
    <!--nav-bar-start-->
    <nav class="navbar navbar-expand-sm navbar-dark sticky-top justify-content-between">
        <a class="navbar-brand" href="{{url('/')}}"><img src="<?php echo url('public/images/udaralogo.png')?>" alt="udaratv" height="40px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="<?php echo url('/')?>">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo url('types/hollwood')?>">Movies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo url('type/hollywoodseries')?>">TvSeries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo url('types/naija')?>">Nollywood-Movies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo url('type/naijaseries')?>">Nollywood-TvSeries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('types/asianseries')}}">Asian TvSeries</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="{{url('types/asianmovies')}}">Asian Movies</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="{{url('types/animemovies')}}">anime Movies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('types/animeseries')}}">anime</a>
                </li>
                <li class="nav-item">
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle bg-dark" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                     Genres
                        </a>
                    <div class="dropdown-menu shadow bg-secondary" aria-labelledby="dropdownMenu1">
                     <a class="dropdown-item shadow" href="{{url('tags/action')}}">Action</a>
                     <a class="dropdown-item shadow" href="{{url('tags/drama')}}">Drama</a>
                     <a class="dropdown-item shadow" href="{{url('tags/comedy')}}">Comedy</a>
                     <a class="dropdown-item shadow" href="{{url('tags/romance')}}">Romance</a>
                     <a class="dropdown-item shadow" href="{{url('tags/horror')}}">Horror</a>
                    </div>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#"><button class="btn btn-danger my-2 my-sm-0" type="button">HOT!!</button></a>
                </li>
            </ul>
           <search-bar searchapi="{{url('api/search')}}"></search-bar>
        </div>
    </nav>
<!--nav-bar-end-->
 <div class="bg-dark searchbar"> <search-bar searchapi="{{url('api/search')}}"></search-bar> </div>
 <main role="main" class="container ">
        <div class="card">

           <image-mount :reuse=false :ishome=true name="{{$name}}" image_link="{{$image_link}}" views="{{$views}}" id="{{$id}}" base_url="{{url('/')}}" number_of_seasons="{{$number_of_seasons}}" imdb_link='{{$imdb_link}}' desc="{{$desc}}" run_time='{{$run_time}}'></image-mount>
            <div class="pt-4">
                @foreach($seasons as $season)
                 <p class="text-center shadow"><a href="{{$season['link']}}">Season {{$season['number']}}</a></p>
                 @endforeach
            </div>
        </div>
        <br>
        <paginator v-bind:passed="{{$paginator}}"></paginator>
    </main><!-- /.container -->

    <section class="container justify-content-center">

        <div class="back guru"><a href="javascript:history.go(-1)">Back</a></div>
    </section>

    <br>
    <br>

    <!-- Footer -->
    <footer class="page-footer  font-small  pt-4">
        <div id="ENGAGEYA_WIDGET_125611"></div>
        <div class="col-lg-12">
            <div class="container-fluid padding">
                <div class="row text-center padding">
                    <div class="col-12">
                        <h2>Join Our Twitter and Facebook Community</h2>
                    </div>
                    <div class="col-12 social padding">
                        <a href="#"><i class="fab fa-facebook"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>

                    </div>
                </div>
            </div>

        </div>
        <hr class="light">
        <!-- Footer Links -->
        <div class="container text-center text-md-left">

            <!-- Grid row -->
            <div class="row">

                <!-- Grid column -->
                <div class="col-md-3 mx-auto">

                    <!-- Links -->
                    <h5 class="font-weight-bold text-uppercase mt-3 mb-4 footerlink">Navigation</h5>

                    <ul class="list-unstyled">
                        <li>
                            <a href="{{url('type/hollywoodmovies')}}">HollyWood Movies</a>
                        </li>
                        <li>
                            <a href="{{url('type/hollywoodmovies')}}">Hollywood Tvseries</a>
                        </li>
                        <li>
                            <a href="{{url('type/nollywoodmovies')}}">NollyWood Movies</a>
                        </li>
                        <li>
                            <a href="{{url('type/nollywoodseries')}}">Nollywood Tvseries</a>
                        </li>
                        <li>
                            <a href="{{url('type/animeseries')}}">Anime series</a>
                        </li>
                        <li>
                            <a href="{{url('type/animemovies')}}">Anime </a>
                        </li>
                        <li>
                            <a href="#Request">Request!</a>
                        </li>
                    </ul>

                </div>
                <!-- Grid column -->

                <hr class="clearfix w-100 d-md-none">

                <!-- Grid column -->
                <div class="col-md-3 mx-auto">

                    <!-- Links -->
                    <h5 class="font-weight-bold text-uppercase mt-3 mb-4 footerlink">Quickie</h5>

                    <ul class="list-unstyled">
                       <li>
                            <a href="{{url('type/hollywoodmovies')}}">HollyWood Movies</a>
                        </li>
                        <li>
                            <a href="{{url('type/nollywoodmovies')}}">NollyWood Movies</a>
                        </li>
                        <li>
                            <a href="{{url('type/bollywoodmovies')}}">BollyWood Movies</a>
                        </li>

                    </ul>

                </div>
                <!-- Grid column -->

                <hr class="clearfix w-100 d-md-none">

                <!-- Grid column -->
                <div class="col-md-3 mx-auto">

                    <!-- Links -->
                    <h5 class="font-weight-bold text-uppercase mt-3 mb-4  footerlink">Genres</h5>

                    <ul class="list-unstyled">
                        <li>
                            <a href="{{url('tags/action')}}">Action</a>
                        </li>
                        <li>
                            <a href="{{url('tags/drama')}}">Drama</a>
                        </li>
                        <li>
                            <a href="{{url('tags/comedy')}}">Comedy</a>
                        </li>
                        <li>
                            <a href="{{url('tags/romance')}}">Romance</a>
                        </li>
                        <li>
                            <a href="{{url('tags/horror')}}">Horror</a>
                        </li>
                        <li>
                            <a href="#!"></a>
                        </li>
                    </ul>

                </div>
                <!-- Grid column -->

                <hr class="clearfix w-100 d-md-none">



            </div>
            <!-- Grid row -->
            <br>
            <p class="small text-center">
                Disclaimer: This site does not store any files on its server. All contents are provided by non-affiliated third parties.
            </p>
        </div>
        <!-- Footer Links -->
        <!-- Copyright -->
         <div class="footer-copyright text-center py-3"><a class="navbar-brand" href="#"><img src="{{url('public/images/udaralogo.png')}}" alt="udaratv" height="40px"></a>© 2018 Copyright:
            <a href='{{url("/")}}'>UdaraTv.com</a>
        </div>
        <!-- Copyright -->

    </footer> 
</div>
<script type="text/javascript" src="<?php echo url('public/js/app.js')?>"></script>
</body>
</html>