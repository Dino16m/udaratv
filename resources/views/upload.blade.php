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
    <meta name="csrf-token" content="{{csrf_token()}}" >
    <link rel="icon" href="<?php echo url('public/images/udaralogo.png')?>">
</head>
<body>
<div id='app'>
  <upload 
    imageurl="<?php echo url('public/images/udaralogo.png')?>" 
    newmovies="{{url('api/uploader/newMovie')}}"
    newseries=" {{url('api/uploader/newSeries')}}"
    oldmovies= "{{url('api/uploader/updateMovie')}}"
    oldseries="{{url('api/uploader/updateSeries')}}"
    register="{{ route('register') }}"
    ></upload>
    
  
</div>
<script type="text/javascript" src="<?php echo url('public/js/app.js')?>"></script>
</body>
</html>