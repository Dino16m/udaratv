<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>Home</title>

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.2/css/all.css" integrity="sha384-/rXc/GQVaYpyDdyxK+ecHPVYJSN9bmVFBvjA/9eOB+pb3F2w2N6fc5qB9Ew5yIns" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css" type="text/css">
     <link rel="stylesheet" href="css/style2.css" type="text/css">
    <!-- Custom styles for this template -->
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
</head>

<body>



    <header class="pl-4 ml-4">
        <h1>UdaraTv.com</h1>
        <p>A sticky navigation bar stays fixed at the top of the page when you scroll past it.</p>

    </header>
<!--nav-bar-start-->
    <nav class="navbar navbar-expand-sm navbar-dark sticky-top justify-content-between">
        <a class="navbar-brand" href="#"><img src="images/udaralogo.png" alt="udaratv" height="40px"></a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria- controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
             <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="index2.html">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="movies2.html">Movies</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="tvseries2.html">TvSeries</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="genres.html">Genres</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href=".top10.html"><button class="btn btn-danger my-2 my-sm-0" type="button">HOT!!</button></a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" v-model='searchstring' aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" v-on:click='search()' type="submit">Search</button>
            </form>
        </div>
    </nav>

<!--nav-bar-end-->

    <!--carousel-->

    <!--Carousel Wrapper-->
    <div id="carousel-example-2" class="carousel slide carousel-fade" data-ride="carousel">
        <!--Indicators-->
        <ol class="carousel-indicators">
            <li data-target="#carousel-example-2" data-slide-to="0" class="active"></li>
            <li data-target="#carousel-example-2" data-slide-to="1"></li>
            <li data-target="#carousel-example-2" data-slide-to="2"></li>
        </ol>
        <!--/.Indicators-->
        <!--Slides-->
        <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
                <div class="view">
                    <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(68).jpg" alt="First slide">
                    <div class="mask rgba-black-light"></div>
                </div>
                <div class="carousel-caption">
                    <h3 class="h3-responsive">Light mask</h3>
                    <p>First text</p>
                </div>
            </div>
            <div class="carousel-item">
                <!--Mask color-->
                <div class="view">
                    <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(6).jpg" alt="Second slide">
                    <div class="mask rgba-black-strong"></div>
                </div>
                <div class="carousel-caption">
                    <h3 class="h3-responsive">Strong mask</h3>
                    <p>Secondary text</p>
                </div>
            </div>
            <div class="carousel-item">
                <!--Mask color-->
                <div class="view">
                    <img class="d-block w-100" src="https://mdbootstrap.com/img/Photos/Slides/img%20(9).jpg" alt="Third slide">
                    <div class="mask rgba-black-slight"></div>
                </div>
                <div class="carousel-caption">
                    <h3 class="h3-responsive">Slight mask</h3>
                    <p>Third text</p>
                </div>
            </div>
        </div>
        <!--/.Slides-->
        <!--Controls-->
        <a class="carousel-control-prev" href="#carousel-example-2" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carousel-example-2" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
        <!--/.Controls-->
    </div>
    <!--/.Carousel Wrapper-->
    <!--carousel end-->
    <br>

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

                                <div class="col-lg-3 col-md-4 col-xs-6">
                                   <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/6cbdea04ef11c41c9d6dd8af12b2daa9.jpg" alt="">
                                    </a>
                                    <a class="name">pharisee</a>
                                  </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/b22afd615d390153527756dbb1d6cd3e.jpg" alt="">
                                    </a>
                                    <a class="name">pharisee</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/09/ae98fac00f2a70db54bcba6a041d0db4.jpg" alt="predator">
                                    </a>
                                     <a class="name">pharisee</a>
                                </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="movie2/pharisee" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/c9dfdaaaddcd2df3f5da4f875f4572f3.jpg" alt="">
                                          </a>
                                        <a class="name">pharisee</a>
                                    </div>
                                   
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/13f8c7af5e87aa19bd69dff9e8623059.jpg" alt="">
                                    </a>
                                        <a class="name">pharisee</a>
                                    </div>
                                    
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                     <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/a1df66c23dfc03408a5b08e19df2baeb.jpg" alt="">
                                    </a>
                                         <a class="name">pharisee</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                     <div class="poster-item">
                                         <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/e397bf3557e43c0c449d8e6621c7cb55.jpg" alt="">
                                    </a>
                                         <a class="name">pharisee</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/05d614b2a84837a41840b14f0b1bca35.jpg" alt="">
                                    </a>
                                    <a class="name">pharisee</a>
                                </div>
                              
                                </div>
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

                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/13f8c7af5e87aa19bd69dff9e8623059.jpg" alt="">
                                    </a>
                                    <a class="name">pharisee</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/a1df66c23dfc03408a5b08e19df2baeb.jpg" alt="">
                                    </a>
                                    <a class="name">pharisee</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/e397bf3557e43c0c449d8e6621c7cb55.jpg" alt="">
                                    </a>
                                    <a class="name">pharisee</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/05d614b2a84837a41840b14f0b1bca35.jpg" alt="">
                                    </a>
                                    <a class="name">pharisee</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/c3fc9e8d528a57eb75fe2adb36f3ca0c.jpg" alt="">
                                    </a>
                                    <a class="name">pharisee</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/559734c2ccee7fad085c7077b97000b2.jpg" alt="">
                                    </a>
                                    <a class="name">pharisee</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/cd2e2e430e3792853282da7377ca5546.jpg" alt="">
                                    </a>
                                    <a class="name">pharisee</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/19b9b273bca8b232927a419138f4c653.jpg" alt="">
                                    </a>
                                    <a class="name">pharisee</a>
                                    </div>
                                </div>

                            </div>

                        </div>
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
        <!--RecOMMENDEd-->
     <main role="main" class="container">



        <div class="starter-template">
            <h2 class="headit">Recommended</h2>
            <hr class="">

            <br>

            <div class="container">

                <br>
                <!-- Nav tabs -->
                <ul class="nav nav-tabs " role="tablist">
                    <li class="nav-item ">
                        <a class="nav-link active bg-dark" data-toggle="tab" href="#home2">TvSeries</a>
                    </li>
                    <li class="nav-item bg-dark">
                        <a class="nav-link bg-dark" data-toggle="tab" href="#menu2">Movies</a>
                    </li>
                    <li class="nav-item">

                    </li>
                </ul>

                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="home2" class="container tab-pane active"><br>
                        <div class="container">

                            <h1 class="my-4 text-center text-lg-left">
                                <p class="text-center">Download latest Tvseries.</p>
                            </h1>
                            <br>
                            <div class="row text-center text-lg-left">

                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/6cbdea04ef11c41c9d6dd8af12b2daa9.jpg" alt="">
                                    </a>
                                    <a class="name">pharisee</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/b22afd615d390153527756dbb1d6cd3e.jpg" alt="">
                                    </a>
                                    <a class="name">Jefe</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/09/ae98fac00f2a70db54bcba6a041d0db4.jpg" alt="predator">
                                    </a>
                                     <a class="name">Predator</a>
                                </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="movie2/pharisee.html" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/c9dfdaaaddcd2df3f5da4f875f4572f3.jpg" alt="Pharisee">
                                          </a>
                                        <a class="name">Pharisee</a>
                                    </div>
                                   
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/13f8c7af5e87aa19bd69dff9e8623059.jpg" alt="">
                                    </a>
                                        <a class="name">Outlaw King</a>
                                    </div>
                                    
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                     <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/a1df66c23dfc03408a5b08e19df2baeb.jpg" alt="">
                                    </a>
                                         <a class="name">Here and Now</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                     <div class="poster-item">
                                         <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/e397bf3557e43c0c449d8e6621c7cb55.jpg" alt="">
                                    </a>
                                         <a class="name">pharisee</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="shadow img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/05d614b2a84837a41840b14f0b1bca35.jpg" alt="">
                                    </a>
                                    <a class="name">pharisee</a>
                                </div>
                              
                                </div>
                            </div>

                        </div>

                    </div>
                
                    <div id="menu2" class="container tab-pane fade"><br>
                        <div class="container">

                            <h1 class="my-4 text-center text-lg-left">
                                <p class="text-center"> Download latest Movies.</p>
                            </h1>
                            <br>
                            <div class="row text-center text-lg-left">

                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/13f8c7af5e87aa19bd69dff9e8623059.jpg" alt="Outlaw King">
                        
                                    </a>
                                    <a class="name">Outlaw King</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100 img-effect">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/a1df66c23dfc03408a5b08e19df2baeb.jpg" alt="Here and Now"><   
                                      
                                        
                                    </a>
                                
                                    <a class="name">Here and Now</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/e397bf3557e43c0c449d8e6621c7cb55.jpg" alt="">
                                    </a>
                                    <a class="name">In a relationship</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/05d614b2a84837a41840b14f0b1bca35.jpg" alt="">
                                    </a>
                                    <a class="name">Time Freak</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/c3fc9e8d528a57eb75fe2adb36f3ca0c.jpg" alt="">
                                    </a>
                                    <a class="name">Lez Bomb</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/559734c2ccee7fad085c7077b97000b2.jpg" alt="">
                                    </a>
                                    <a class="name">River Runs Red</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/cd2e2e430e3792853282da7377ca5546.jpg" alt="">
                                    </a>
                                    <a class="name">This is Our Christmas</a>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-4 col-xs-6">
                                    <div class="poster-item">
                                    <a href="#" class="d-block mb-4 h-100">
                                        <img class="img-fluid my-2" src="https://static.akacdn.ru/static/images/2018/11/19b9b273bca8b232927a419138f4c653.jpg" alt="">
                                    </a>
                                    <a class="name">Equalizer2</a>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                   
                </div>
            </div>

            <div class="card-text">
                <a href="movies.html">
                    <h1 class="">See more</h1>
                </a>
            </div>
        </div>
        
  </section>

    <section class="container justify-content-center">

        <div class="row justify-content-center">
            <div class="col-sm-8">
                <div class="card-body text-center">
                    <p class="card-text  text-center">Oops!! didn't find what you were looking?click below to submit request</p>
                    <a href="request.html" class="col-md-6 btn btn-success  text-center">Request a Movie</a>
                </div>
            </div>


        </div>

    </section>

    <br>
    <br>

<!--
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright © Your Website 2017</p>
        </div>
        <!-- /.container
    </footer -->

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
                            <a href="#!">Movies</a>
                        </li>
                        <li>
                            <a href="#!">Tvseries</a>
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
                            <a href="#!">Hollywood</a>
                        </li>
                        <li>
                            <a href="#!">Nollywood</a>
                        </li>
                        <li>
                            <a href="#!">Bollywood</a>
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
                            <a href="#!">Drama</a>
                        </li>
                
                        <li>
                            <a href="#!">Comedy</a>
                        </li>
                    
                        <li>
                            <a href="#!">Romance</a>
                        </li>
                
                        <li>
                            <a href="#!">Horror</a>
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
        <div class="footer-copyright text-center py-3"><a class="navbar-brand" href="#"><img src="images/udaralogo.png" alt="udaratv" height="40px"></a>© 2018 Copyright:
            <a href="#">UdaraTv.com</a>
        </div>
        <!-- Copyright -->

    </footer>

    <!-- Footer end -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

</body>
</html>