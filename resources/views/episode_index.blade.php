<!DOCTYPE html>
<html>
<head>
    <title> Udara Tv</title>
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
    <meta name="og:title" property="og:title" content="Udara Tv - download nollywood Movies and series, download hollywood movies and series">
    <meta name="og:description" property="og:description" content="download episodes of {{$name}}">
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
        <?php echo include_once (base_path('resources/views/pa_antiadblock_2523772.php')); ?>
        <?php echo include_once (base_path('resources/views/pa_antiadblock_2523831.php')); ?>
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
                    <a class="nav-link" href="<?php echo url('types/hollywoodmovies')?>">Movies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo url('types/hollywoodseries')?>">TvSeries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo url('types/nollywoodmovies')?>">Nollywood-Movies</a>
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
                 <li class="nav-item">
                    <a class="nav-link" href="#/request"><button class="btn btn-success" type="button">Request</button></a>
                </li>
            </ul>
           <search-bar searchapi="{{url('api/search')}}"></search-bar>
        </div>
    </nav>
    <!--nav-bar-end-->
    <div class="bg-dark searchbar"> <search-bar searchapi="{{url('api/search')}}"></search-bar> </div>
    <router-view api="{{url('api/subscribe')}}" v-bind:isroute=true v-bind:isfinal=false> </router-view>
    <div class="float-button d-block mobile-only"> <a class="w-100 h-100 mx-auto my-auto d-block" href="#/request"><img class="rounded-circle h-100 w-100" src="{{url('public/css/udara.jpg')}}"></a> </div>
    <main role="main" class="container ">
        <div class="card">

           <image-mount :reuse=true name="{{$name}}" base_url="{{url('/')}}" number_of_episodes={{$episodes_number}}></image-mount>
            <div class="pt-4">
                @foreach($episodes as $episode)
                 <p class="text-center shadow"><a href="{{$episode['link']}}">Episode {{$episode['episode']}}</a></p>
                 @endforeach
            </div>
        </div>
        <br>
    </main>
    <!-- /.container -->
    <!--ad network-->
        <?php echo include_once (base_path('resources/views/pa_antiadblock_2523831.php')); ?>
    <!--end of ad-->
      <section class="container justify-content-center">

        <div class="back guru"><a href="javascript:history.go(-1)">Back</a></div>
    </section>

    <br>
    <br>

    <!-- Footer -->
    <footer class="page-footer  font-small  pt-4">
        <!--ad network-->
        <?php echo include_once (base_path('resources/views/pa_antiadblock_2523831.php')); ?>
        <!--end of ad-->
        <div class="col-lg-12">
            <div class="container-fluid padding">
                <div class="row text-center padding">
                    <div class="col-12">
                        <h2>Join Our Twitter and Facebook Community</h2>
                    </div>
                    <div class=" col-12 mx-auto social padding">
                        <a href="https://www.facebook.com/udaraTV/"><i class="fab mx-auto   fa-facebook"></i></a> 
                        <a href="" ><i class="fab mx-auto d-none fa-twitter"></i></a>
                        <a href="https://chat.whatsapp.com/I6UY1Q7m4Eu05oUqLA76s6" ><i class="fab mx-auto fa-whatsapp"></i></a>
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
                            <a href="{{url('type/asianseries')}}">Asian/Korean Tvseries</a>
                        </li>
                        <li>
                            <a href="#/request">Request!</a>
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
        <div class="text-center d-block  text-white "><img src="https://uzucorp.com/uzu.jpg" class="rounded-circle uzu" alt="uzucorp.com" height="40px" width="40px">      Rapidly developed by <a href="https://uzucorp.com/">Uzucorp</a> </div>
        
        <!-- Copyright -->

    </footer> 
</div>
<script type="text/javascript" src="<?php echo url('public/js/app.js')?>"></script>
</body>
</html>