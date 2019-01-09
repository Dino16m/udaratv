<?php 
$scat = 'jkl';
$catArr= str_split($scat);
$catStr='';
$catlength=sizeof($catArr);
for($i = 0; $i<$catlength; $i++)
{
    if($catlength == 1){ break;}
    $cat1=$catArr[$i];
    if ($i == ($catlength-1)){
        $catStr = strtoupper($catStr).' or '.strtoupper($cat1);
        break;
    }
   $catStr= $catStr=='' ? $catStr.$cat1 : $catStr. ', '.$cat1;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>UDARA TV</title>
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
     <link rel="icon" href="<?php echo url('public/images/udaralogo.png')?>">
</head>
<body>
<div id="app">
    <!--nav-bar-start-->
    <nav class="navbar navbar-expand-sm navbar-dark sticky-top justify-content-between">
        <a class="navbar-brand" href="#"><img src="<?php echo url('public/images/udaralogo.png')?>" alt="udaratv" height="40px"></a>
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
                    <a class="nav-link" href="#">Genres</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#"><button class="btn btn-danger my-2 my-sm-0" type="button">HOT!!</button></a>
                </li>
            </ul>
           <search-bar></search-bar>
        </div>
    </nav>
<!--nav-bar-end-->

<!--jumbotron-->

    <div class="jumbotron jumbotron-fluid text-white bg-dark w-100">
        <div class="container text-center">
            <h2 class="text-center font-weight-lighter">{{strtoupper($type)}} starting with {{$catStr}}</h2>
        </div>

    </div>
    <!--jumbotron end-->
     <div class="pt-4 container-fluid">
        @foreach($categories as $category)
        <p class="text-center shadow"><a href="{{$category['link']}}">{{$category['name']}}</a></p>
        @endforeach
        <paginator v-bind:passed="{{$paginator}}"></paginator>
    </div>
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