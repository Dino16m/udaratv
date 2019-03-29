<?php
$movies=[];
$series=[];
foreach ($recents as $recent) {
    if($recent['season']==null && $recent['season']==null)
    {
        array_push($movies, $recent);
    }
    else
    {
         array_push($series, $recent);
    }
    $all = array_merge($series, $movies);
}
 ?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="{{url('/public/css/app.css')}}">
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
    <meta name="csrf-token" content="{{csrf_token()}}" >
    <meta name="og:type" property="og:type" content="website">
    <meta name="og:title" property="og:title" content="Udara Tv - download nollywood Movies and series, download hollywood movies and series">
    <meta name="og:description" property="og:description" content="download UdaraTv recently updates series and movies">
    <meta name="og:image" property="og:image" content="{{url('public/images/udaralogo.png')}}">
    <link rel="icon" href="<?php echo url('public/images/udaralogo.png')?>">


    <title>Udara Tv</title>
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
        <?php echo include_once (dirname(__FILE__) . '/pa_antiadblock_2523772.php'); ?>
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
<section>
    <main role="main" class="container">



        <div class="starter-template">
            <h2 class="headit">Recently updated</h2>
            <hr class="">

            <br>

            <div class="container-fluid">

                <br>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active bg-dark" data-toggle="tab" href="#home">TvSeries</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link bg-dark" data-toggle="tab" href="#menu1">Movies</a>
                    </li>
                     <li class="nav-item ">
                        <a class="nav-link bg-dark" data-toggle="tab" href="#seeall">See all</a>
                    </li>
                    <li class="nav-item">

                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="home" class="container-fluid tab-pane active"><br>
                        <div class="container-fluid">
                            <!--here-->
                            <h1 class="my-4 text-center text-lg-left">
                                <p class="text-center">Download latest Tvseries.</p>
                            </h1>
                            <br>
                            <ul class="list-group bg-dark" >
                            @foreach($series as $serie)
                                <tab-component-text type='series' videourl='{{$serie["link"]}}' episode='{{$serie["episode"]}}' season='{{$serie["season"]}}' videoname='{{$serie["name"]}}' timestamp='{{$serie["updatedAt"]}}'></tab-component-text>  
                            @endforeach 
                            </ul>

                        </div>
                    </div>
                
                    <div id="menu1" class="container tab-pane fade"><br>
                        <div class="container">

                            <h1 class="my-4 text-center text-lg-left">
                                <p class="text-center"> Download latest Movies.</p>
                            </h1>
                            <br>
                            <ul class="list-group bg-dark" >
                                @foreach($movies as $movie)
                                <tab-component-text type='movies' videourl='{{$movie["link"]}}' videoname='{{$movie["name"]}}' timestamp='{{$movie["updatedAt"]}}' ></tab-component-text> 
                                @endforeach
                            </ul>

                        </div>
                    </div>
                     <div id="seeall" class="container tab-pane fade"><br>
                      <h1>  <p class="text-center"> Download latest Movies and series.</p> </h1>
                       <br>
                        <ul class="list-group bg-dark" >
                             @foreach($all as $all1)
                              @if($all1['season']==null or $all1['episode']==null)
                               <tab-component-text type='movies' videourl='{{$all1["link"]}}' videoname='{{$all1["name"]}}' timestamp='{{$all1["updatedAt"]}}' ></tab-component-text> 
                               @endif
                               @if($all1['season']!=null or $all1['episode']!=null)
                               <tab-component-text type='series' videourl='{{$all1["link"]}}' season="{{$all1['season']}}" episode="{{$all1['episode']}}" videoname='{{$all1["name"]}}' timestamp='{{$all1["updatedAt"]}}' ></tab-component-text> 
                               @endif
                             @endforeach
                         </ul>
                    </div>
                   
                </div>
            </div>
</section> 
 <!-- Footer -->
     <footer class="page-footer  font-small ">
        <div id="ENGAGEYA_WIDGET_125611"></div>
        <div class="col-lg-12">
            <div class="container-fluid padding">
                <div class="row text-center padding">
                    <div class="col-12 padding">
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
                            <a href="{{url('types/hollywoodmovies')}}">Hollywood Movies</a>
                        </li>
                        <li>
                            <a href="{{url('types/hollywoodseries')}}">Hollywood Tvseries</a>
                        </li>
                        <li>
                            <a href="{{url('types/asianmovies')}}">Asian Movies</a>
                        </li>
                        <li>
                            <a href="{{url('types/asianseries')}}">Asian series</a>
                        </li>
                        <li>
                            <a href="{{url('types/animemovies')}}">Anime</a>
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
                            <a href="{{url('types/hollywoodmovies')}}">Hollywood</a>
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
                            <a  class="foot-lm" href="#! ">Action</a>
                            
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
        <!-- Copyright -->

    </footer>

    <!-- Footer end -->
</div>
<script type="text/javascript" src="<?php echo url('public/js/app.js')?>"></script>
 
</body>
</html>