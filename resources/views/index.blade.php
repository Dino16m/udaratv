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
}
$all = array_merge($series, $movies);
$carousel = [];
$i = 0;
$previous = '';
$pageMeta = '';
foreach ($all as $all1)
{ 
    if($previous==$all1['name']){continue;}
    $carousel[$i]=[
        'name'=>$all1['name'],
        'url'=>$all1['link'],
        'imageurl'=>url($all1['image_link'])
    ];
    $pageMeta .=$all1['name'] .', ';
    $previous=$all1['name'];
    $i++;
}
$lacarousel=json_encode($carousel);
?>
<html> 
<head>
    <link rel="stylesheet" type="text/css" href="public/css/app.css">
    <link rel="stylesheet" href="public/css/style.css" type="text/css">
    <link rel="stylesheet" href="public/css/style2.css" type="text/css">
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
    <meta name="google-site-verification" content="Th8HNdr7cKYDKfi21HsdFYYUa5mryCK_ahacx-i6BxE">
    <meta name="description" content="Hollywood movies download, Tv series download, Nollywood movies download, UdaraTv.com, {{$pageMeta}}">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{csrf_token()}}" >
    <link rel="icon" href="<?php echo url('public/images/udaralogo.png')?>">

    <title>Home</title>

</head>
<body>
<div id="app"> 
<!--nav-bar-start-->
    <nav class="navbar navbar-expand-sm navbar-dark sticky-top justify-content-between">
        <a class="navbar-brand" href="{{url('/')}}"><img src="public/images/udaralogo.png" alt="udaratv" height="40px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{url('/')}}">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="types/hollywoodmovies">Hollywood Movies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="types/hollywoodseries">Hollywood TvSeries</a>
                </li>
                 <li class="nav-item">
                    <a class="nav-link" href="types/nollywoodmovies">Nollywood Movies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="types/nollywoodseries">Nollywood TvSeries</a>
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
           <search-bar></search-bar>
        </div>
    </nav>

<!--nav-bar-end--> 

<index-carousel v-bind:videodetails="{{$lacarousel}}" > </index-carousel>

<section>
    <main role="main" class="container">



        <div class="starter-template">
            <h2 class="headit">Recently updated</h2>
            <hr class="">

            <br>

            <div class="container-fluid">

                <br>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs d-flex w-100" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link flex-item bg-dark" data-toggle="tab" href="#home">TvSeries</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link flex-item bg-dark" data-toggle="tab" href="#menu1">Movies</a>
                    </li>
                     <li class="nav-item ">
                        <a class="nav-link flex-item active bg-dark" data-toggle="tab" href="#seeall">See all</a>
                    </li>
                    <li class="nav-item">

                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="home" class="container tab-pane active"><br>
                        <div class="container">
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

            <div class="card-text">
                <a href="recents/seemore">
                    <h1>See more</h1>
                </a>
            </div>
        </div>
</section>
    <hr class="underline">

<section>
    <main role="main" class="container w-100">



        <div class="starter-template">
            <h2 class="headit">Alphabetical listing of videos</h2>
            <hr class="">

            <br>

            <div class="container-fluid w-100">

                <br>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs w-100" role="tablist">
                    <li class="nav-item d-flex">
                        <a class="nav-link active  bg-dark" data-toggle="tab" href="#hollywoodseries">Hollywood TvSeries</a>
                    </li>
                    <li class="nav-item flex-item">
                        <a class="nav-link  bg-dark" data-toggle="tab" href="#hollywoodmovies">Hollywood Movies</a>
                    </li>
                    <li class="nav-item flex-item">
                        <a class="nav-link  bg-dark" data-toggle="tab" href="#nollywoodseries">Nollywood TvSeries</a>
                    </li>
                    <li class="nav-item flex-item">
                        <a class="nav-link  bg-dark" data-toggle="tab" href="#nollywoodmovies">Nollywood Movies</a>
                    </li>
                    <li class="nav-item flex-item">
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content w-100">
                    <div id="hollywoodseries" class="container w-100 tab-pane active"><br>
                        <div class="container">
                            <h1 class="my-4 text-center text-lg-left">
                                <p class="text-center">Hollywood Tvseries by first letter of name.</p>
                            </h1>
                            <br>
                            <categorylist videotype="hollywoodseries"> </categorylist>

                        </div>
                    </div>
                
                    <div id="hollywoodmovies" class="container w-100 tab-pane fade"><br>
                        <div class="container">

                            <h1 class="my-4 text-center text-lg-left">
                                <p class="text-center"> Download Hollywood movies</p>
                            </h1>
                            <br>
                            <categorylist videotype="hollywoodmovies"> </categorylist>

                        </div>
                    </div>
                     <div id="nollywoodseries" class="container w-100 tab-pane fade"><br>
                        <div class="container">
                            <h1 class="my-4 text-center text-lg-left">
                                <p class="text-center"> Download Nollywood Series eg Jenifa's Diary.</p>
                            </h1>
                            <br>
                            <categorylist videotype="nollywoodseries"> </categorylist>
                        </div>
                    </div>
                    <div id="nollywoodmovies" class="container w-100 tab-pane fade"><br>
                         <div class="container">
                            <h1 class="my-4 text-center text-lg-left">
                                <p class="text-center"> Download Nollywood movies.</p>
                            </h1>
                            <br>
                            <categorylist videotype="nollywoodmovies"> </categorylist>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
</section>

<hr class="underline">
 <!-- Footer -->
     <footer class="page-footer  font-small ">
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
                            <a href="{{url('types/nollywoodmovies')}}">Nollywood Movies</a>
                        </li>
                        <li>
                            <a href="{{url('types/nollywoodseries')}}">Nollywood Tvseries</a>
                        </li>
                        <li>
                            <a href="#!">Request!</a>
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
                            <a href="{{url('types/hollywoodmovies')}}">Hollywood Movies</a>
                        </li>
                        <li>
                            <a href="{{url('types/nollywoodmovies')}}">Nollywood Movies</a>
                        </li>
                        <li>
                            <a href="{{url('types/bollywoodmovies')}}">Bollywood movies</a>
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

<script type="text/javascript" src="public/js/app.js"></script>

</body>
</html>