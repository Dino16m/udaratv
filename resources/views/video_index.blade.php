<!DOCTYPE html>
<html>
<head>
    <title>Udara TV </title>
    <link rel="stylesheet" type="text/css" href="{{url('public/css/app.css')}}">
    <link rel="stylesheet" href="{{url('public/css/style.css')}}" type="text/css">
    <link rel="stylesheet" href="{{url('public/css/style2.css')}}" type="text/css">
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
    <meta name="description" content="index of all udaratv videos of {{$type}}">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{csrf_token()}}" >
    <meta name="og:type" property="og:type" content="website">
    <meta name="og:title" property="og:title" content="Udara Tv - index of videos of {{$type}}">
    <meta name="og:description" property="og:description" content="download movies of {{$type}} ">
    <meta name="og:image" property="og:image" content="{{url('public/images/udaralogo.png')}}">
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
<div id='app'>
    <!--nav-bar-start-->
    <nav class="navbar navbar-expand-sm navbar-dark sticky-top justify-content-between">
        <a class="navbar-brand" href="{{url('/')}}"><img src="{{url('public/images/udaralogo.png')}}" alt="udaratv" height="40px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{url('/')}}">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('types/hollywoodmovies')}}">Hollywood Movies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('types/hollywoodseries')}}">Hollywood TvSeries</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="{{url('types/nollywoodmovies')}}">Nollywood Movies</a>
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
 <!--ad network-->
        <?php echo include_once (base_path('resources/views/pa_antiadblock_2523831.php')); ?>
    <!--end of ad-->
<!--jumbotron-->

    <div class="jumbotron jumbotron-fluid text-white bg-dark w-100">
        <div class="container text-center">
            <h2 class="text-center font-weight-lighter text-capitalize text-monospace display-4">{{$type}}</h2>
        </div>
    </div>
<!--jumbotron end-->
<!--ad network-->
        <?php echo include_once (base_path('resources/views/pa_antiadblock_2523831.php')); ?>
    <!--end of ad-->
<ul>
@foreach($videos as $video)
    <li  class="list-group-item d-flex justify-content-between align-items-center shadow p-3 bg-dark text-capitalize" style="list-style-image: url('public/css/Youtube.svg')">
<a href="{{$video['link']}}" > <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 42 34">
  <defs>
  </defs>
  <path id="Youtube" class="cls-1" d="M288.945,2136a7.057,7.057,0,0,1,7.055,7.06v13.88a7.057,7.057,0,0,1-7.055,7.06h-21.89a7.057,7.057,0,0,1-7.055-7.06v-13.88a7.057,7.057,0,0,1,7.055-7.06h21.89m0-3h-21.89A10.067,10.067,0,0,0,257,2143.06v13.88A10.067,10.067,0,0,0,267.055,2167h21.89A10.067,10.067,0,0,0,299,2156.94v-13.88A10.067,10.067,0,0,0,288.945,2133h0ZM275,2145l8,5-8,5v-10m0-3a2.907,2.907,0,0,0-1.454.38A2.984,2.984,0,0,0,272,2145v10a2.984,2.984,0,0,0,1.546,2.62A2.907,2.907,0,0,0,275,2158a2.943,2.943,0,0,0,1.59-.46l8-5a2.993,2.993,0,0,0,0-5.08l-8-5A2.943,2.943,0,0,0,275,2142h0Z" transform="translate(-257 -2133)"/>
</svg> <span class="d-inline-block w-1"></span> {{$video['name']}}</a>
    </li>
@endforeach
</ul>
@if($paginator !== 'empty')
<paginator :passed={{$paginator}}></paginator>
@endif

 <hr class="light">
        <!-- Footer Links -->
        <footer class="page-footer  font-small  pt-4">
        <div id="ENGAGEYA_WIDGET_125611"></div>
        <div class="container text-center text-md-left">

            <!-- Grid row -->
            <div class="row">

                <!-- Grid column -->
                <div class="col-md-3 mx-auto">

                    <!-- Links -->
                    <h5 class="font-weight-bold text-uppercase mt-3 mb-4 footerlink">Navigation</h5>

                    <ul class="list-unstyled">
                        <li>
                            <a href="{{url('types/hollywoodmovies')}}">Movies</a>
                        </li>
                        <li>
                            <a href="{{url('types/hollywoodseries')}}">Tvseries</a>
                        </li>
                        <li>
                            <a href="{{url('types/animemovies')}}">Anime</a>
                        </li>
                         <li>
                            <a href="{{url('types/animeseries')}}">Anime Series</a>
                        </li>
                        <li>
                            <a href="#/request">Request!</a>
                        </li>
                    </ul>

                </div>
                <div class=" col-12 mx-auto social padding">
                        <a href="https://www.facebook.com/udaraTV/"><i class="fab mx-auto   fa-facebook"></i></a> 
                        <a href="" ><i class="fab mx-auto d-none fa-twitter"></i></a>
                        <a href="https://chat.whatsapp.com/I6UY1Q7m4Eu05oUqLA76s6" ><i class="fab mx-auto fa-whatsapp"></i></a>
                    </div>
                <!-- Grid column -->

                <hr class="clearfix w-100 d-md-none">

                <!-- Grid column -->
                <div class="col-md-3 mx-auto">

                    <!-- Links -->
                    <h5 class="font-weight-bold text-uppercase mt-3 mb-4 footerlink">Quickie</h5>

                    <ul class="list-unstyled">
                        <li>
                            <a href="{{url('types/hollwoodmovies')}}">Hollywood</a>
                        </li>
                        <li>
                            <a href="{{url('types/nollywoodmovies')}}">Nollywood</a>
                        </li>
                        <li>
                            <a href="{{url('types/bollywoodmovies')}}">Bollywood</a>
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
                            <a  class="foot-lm" href="{{url('tags/action')}} ">Action</a>
                            
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
                        <br>
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

    <!-- Footer end -->

</div>
<script type="text/javascript" src="{{url('public/js/app.js')}}"></script>

</body>
</html>