<?php 

$movies = [["imageurl"=>'public/images/it.jpg', "videourl"=>'public/images/it.jpg', 'name'=>'dino16m'], ["imageurl"=>'public/images/it.jpg', "videourl"=>'public/images/it.jpg', 'name'=>'dino16m'], ["imageurl"=>'public/images/it.jpg', "videourl"=>'public/images/it.jpg', 'name'=>'dino16m'], ["imageurl"=>'public/images/it.jpg', "videourl"=>'public/images/it.jpg', 'name'=>'dino16m'], ["imageurl"=>'public/images/it.jpg', "videourl"=>'public/images/it.jpg', 'name'=>'dino16m'], ["imageurl"=>'public/images/it.jpg', "videourl"=>'public/images/it.jpg', 'name'=>'dino16m'], ["imageurl"=>'public/images/it.jpg', "videourl"=>'public/images/it.jpg', 'name'=>'dino16m'], ["imageurl"=>'public/images/it.jpg', "videourl"=>'public/images/it.jpg', 'name'=>'dino16m'], ["imageurl"=>'public/images/it.jpg', "videourl"=>'public/images/it.jpg', 'name'=>'dino16m'],["imageurl"=>'public/images/it.jpg', "videourl"=>'public/images/it.jpg', 'name'=>'dino16m'], ["imageurl"=>'public/images/it.jpg', "videourl"=>'public/images/it.jpg', 'name'=>'dino16m'], ["imageurl"=>'public/images/it.jpg', "videourl"=>'public/images/it.jpg', 'name'=>'dino16m'], ["imageurl"=>'public/images/it.jpg', "videourl"=>'public/images/it.jpg', 'name'=>'dino16m'], ["imageurl"=>'public/images/it.jpg', "videourl"=>'public/images/it.jpg', 'name'=>'dino16m'], ["imageurl"=>'public/images/it.jpg', "videourl"=>'public/images/it.jpg', 'name'=>'dino16m']];
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
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Home</title>

</head>
<body>
<div id="app"> 
<!--nav-bar-start-->
    <nav class="navbar navbar-expand-sm navbar-dark sticky-top justify-content-between">
        <a class="navbar-brand" href="#"><img src="public/images/udaralogo.png" alt="udaratv" height="40px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="public/types/hollwood">Movies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="public/type/hollywoodseries">TvSeries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Genres</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href=".top10.html"><button class="btn btn-danger my-2 my-sm-0" type="button">HOT!!</button></a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

<!--nav-bar-end--> 

<index-carousel v-bind:videodetails="[{name: 'dino', imageurl: 'public/images/it.jpg', url: 'wapdam.com' }, {name:'mike', imageurl: 'public/images/it.jpg', url: 'wapday.com' }]" > </index-carousel>

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
                    <div id="home" class="container tab-pane active"><br>
                        <div class="container">

                            <h1 class="my-4 text-center text-lg-left">
                                <p class="text-center">Download latest Tvseries.</p>
                            </h1>
                            <br>
                            <div class="row text-center text-lg-left">
                                @foreach($movies as $movie)
                                <tab-component imageurl='{{$movie["imageurl"]}}' videourl='{{$movie["videourl"]}}' name='{{$movie["name"]}}'></tab-component>  
                                @endforeach 
                            </div>

                        </div>
                    </div>
                
                    <div id="menu1" class="container tab-pane fade"><br>
                        <div class="container">

                            <h1 class="my-4 text-center text-lg-left">
                                <p class="text-center"> Download latest Movies.</p>
                            </h1>
                            <br>
                            <div class="row text-center text-lg-left">

                                <tab-component> </tab-component>
                            </div>

                        </div>
                    </div>
                     <div id="seeall" class="container tab-pane fade"><br>
                        <p class="text-center"> Download latest Movies and series.</p>
                        <ul class="list-group bg-dark">
                            @foreach($movies as $movie)
                            <li class="list-group-item d-flex border border-white justify-content-between align-items-center shadow p-3 bg-dark">
                                     <a href="{{$movie['videourl']}}">{{$movie['name']}}</a>
                             </li>
                             @endforeach
                         </ul>
                    </div>
                   
                </div>
            </div>

            <div class="card-text">
                <a href="movies.html">
                    <h1>See more</h1>
                </a>
            </div>
        </div>
</section>
    <hr class="underline">

<section>
    <main role="main" class="container">



        <div class="starter-template">
            <h2 class="headit">Alphabetical listing of videos</h2>
            <hr class="">

            <br>

            <div class="container-fluid">

                <br>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active bg-dark" data-toggle="tab" href="#hollywoodseries">Hollywood TvSeries</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link bg-dark" data-toggle="tab" href="#hollywoodmovies">Hollywood Movies</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link bg-dark" data-toggle="tab" href="#nollywoodseries">Nollywood TvSeries</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link bg-dark" data-toggle="tab" href="#nollywoodmovies">Nollywood Movies</a>
                    </li>
                    <li class="nav-item">
                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="hollywoodseries" class="container tab-pane active"><br>
                        <div class="container">
                            <h1 class="my-4 text-center text-lg-left">
                                <p class="text-center">Hollywood Tvseries by first letter of name.</p>
                            </h1>
                            <br>
                            <categorylist videotype="hollywoodseries"> </categorylist>

                        </div>
                    </div>
                
                    <div id="hollywoodmovies" class="container tab-pane fade"><br>
                        <div class="container">

                            <h1 class="my-4 text-center text-lg-left">
                                <p class="text-center"> Download Hollywood movies</p>
                            </h1>
                            <br>
                            <categorylist videotype="hollywoodmovies"> </categorylist>

                        </div>
                    </div>
                     <div id="nollywoodseries" class="container tab-pane fade"><br>
                        <div class="container">
                            <h1 class="my-4 text-center text-lg-left">
                                <p class="text-center"> Download Nollywood Series eg Jenifa's Diary.</p>
                            </h1>
                            <br>
                            <categorylist videotype="nollywoodseries"> </categorylist>
                        </div>
                    </div>
                    <div id="nollywoodmovies" class="container tab-pane fade"><br>
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

</div>

<script type="text/javascript" src="public/js/app.js"></script>

</body>
</html>