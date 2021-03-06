<?php 
$movies=[];
$series=[];
foreach ($recents as $recent) {
    if($recent['season']==null)
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
<head prefix= " my_namespace: {{url('/')}}">
    <link rel="stylesheet" type="text/css" href="public/css/app.css">
    <link rel="stylesheet" href="public/css/style.css" type="text/css">
    <link rel="stylesheet" href="public/css/style2.css" type="text/css">
    <link rel="stylesheet" href="public/css/owl.carousel.css" type="text/css">
    <link rel="stylesheet" href="public/css/animate.css" type="text/css">
    <link rel="stylesheet" href="public/css/owl.theme.default.css" type="text/css">
    <style type="text/css">
        body {
            padding-top: 2rem;
            height: auto;
        }

        .starter-template {
            padding: 2rem 0.5rem;
            text-align: center;
        }
    </style>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="google-site-verification" content="Th8HNdr7cKYDKfi21HsdFYYUa5mryCK_ahacx-i6BxE">
    <meta name="description" content="Hollywood movies download, Tv series download, Nollywood movies download, UdaraTv.com, {{$pageMeta}}">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{csrf_token()}}" >
    <meta name="og:type" property="og:type" content="website">
    <meta name="og:title" property="og:title" content="Udara Tv - download nollywood Movies and series, download hollywood movies and series, Anime, Asian movies and series, bollywoodmovies and series">
    <meta name="og:description" property="og:description" content="Hollywood movies download, Tv series download, Nollywood movies download,  Anime, Asian movies and series, bollywoodmovies and series UdaraTv.com, {{$pageMeta}}">
    <meta name="og:image" property="og:image" content="{{url('public/images/udaralogo.png')}}">
    <link rel="icon" href="<?php echo url('public/images/udaralogo.png')?>">
    <meta name="msvalidate.01" content="4933F6D223E4EF9F7C3F176449B05D99" />
    <meta name="yandex-verification" content="27a757e33b722ff5" />
    <meta name="propeller" content="7462e67733b4e3fe4a001c8a7b7bfe29">
    <title>Udara Tv - download nollywood Movies and series, download hollywood movies and series</title>
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
        
    <!--end of ad-->
</head>
<body style="max-width: 100%">
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
                    <a class="nav-link" href="#/request"><button class="btn btn-success" type="button">Request</button></a>
                </li>
            </ul>
           <search-bar searchapi="{{url('api/search')}}"></search-bar>
        </div>
    </nav>
    <div class="bg-dark searchbar"> <search-bar searchapi="{{url('api/search')}}"></search-bar> </div>
<!--nav-bar-end--> 

<router-view api="{{url('api/subscribe')}}" v-bind:isroute=true v-bind:isfinal=false> </router-view>
<div class="float-button d-block mobile-only"> <a class="w-60 h-60 mx-auto my-auto d-block" href="#/request"><img class="rounded-circle h-100 w-100" src="{{url('public/css/udara.jpg')}}"></a> </div>
<div class="container mt-4">
        <div class="row">
                 <index-carousel v-bind:videodetails="{{$lacarousel}}" > </index-carousel>
         </div>
     </div>
<section>
    <main role="main" class="container">

    <!--ad network-->
        <?php echo include_once (base_path('resources/views/pa_antiadblock_2523831.php')); ?>
    <!--end of ad-->
        <div class="starter-template">
            <span class="tlt letters pc-only"> You can request for movies!! click on the green request button</span>
            <span class="tlt-mobile letters mobile-only">You can request for movies!! touch the fruit to try </span>
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
                    <div id="home" class="container tab-pane fade"><br>
                        <div class="container w-100">
                            <!--here-->
                            <h1 class="my-4 text-center text-lg-left">
                                <p class="text-center">Download latest Tvseries.</p>
                            </h1>
                            <br>
                            <ul class="list-group bg-dark w-100" >
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
                     <div id="seeall" class="container tab-pane  active"><br>
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
 <!--ad network-->
        <?php echo include_once (base_path('resources/views/pa_antiadblock_2523831.php')); ?>
    <!--end of ad-->
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
                            <a href="{{url('types/nollywoodmovies')}}">Nollywood Movies</a>
                        </li>
                        <li>
                            <a href="{{url('types/nollywoodseries')}}">Nollywood Tvseries</a>
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
                            <a href="{{url('types/hollywoodmovies')}}">Hollywood Movies</a>
                        </li>
                        <li>
                            <a href="{{url('types/nollywoodmovies')}}">Nollywood Movies</a>
                        </li>
                        <li>
                            <a href="{{url('types/bollywoodmovies')}}">Bollywood movies</a>
                        </li>
                        <li>
                            <a href="{{url('types/anime')}}">Anime</a>
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
         <div class="text-center d-block  text-white "><img src="https://uzucorp.com/uzu.jpg" class="rounded-circle uzu" alt="uzucorp.com" height="40px" width="40px">      Rapidly developed by <a href="https://uzucorp.com/">Uzucorp</a> </div>
        
        <!-- Copyright -->

    </footer>

    <!-- Footer end -->
</div>

<script type="text/javascript" src="public/js/app.js"></script>
<script type="text/javascript" src="public/js/textillate.js"></script>
<script type="text/javascript" src="public/js/lettering.js"></script>
<script type="text/javascript" src="public/js/owl.carousel.js"></script>
<script>
   $('.tlt').textillate({ 
			in: { effect: 'bounceInLeft', sequence: true },
			out: { effect: 'rollOut', shuffle: true },
			loop: true
	});
       $('.tlt-mobile').textillate({ 
			in: { effect: 'bounceInDown', sequence: true },
			out: { effect: 'hinge', shuffle: true },
			loop: true
	});

   $('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    nav:false,
        dots:true,
        autoplay:true,
        autoHeight:true,
    
    responsive:{
        0:{
            items:2
        },
        600:{
            items:3
        },
        1000:{
            items:5
        }
    }
    })  
   
    
</script>
 
</body>
</html>
