<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Validator;
use App\subscribers;

class subscriberController extends Controller
{
    public function subscribe(Request $request)
    {
        $tmpName = Validator::isValid($request->get('name'));
        $tmpEmail = Validator::isValid($request->get('email'));
        $tmpMovies = $request->get('movies');
        $newMovies = $this::sanitizeJson($tmpMovies);

        $name = $tmpName ? $tmpName : 'user';
        $email = $tmpEmail? $tmpEmail : 'user';
        $movies = $newMovies === false ? 'empty' : $newMovies;
        if(($name=='user' && $email == 'user') || $email==='user' )
        {
            return response()->json(['status'=>'bad_email']);
        }
        if( $movies==='empty' )
        {
           return response()->json(['status'=>'bad_movie']);
        }
        
        foreach ($movies as $movie) {
             subscribers::create(['name'=>$name, 'email'=>$email, 'movie_name'=>$movie]);
        }

        return response()->json(['status'=>'everything_good']);
       
    }

    public function sanitizeJson($Json)
    {
        $Arr =explode('|', $Json);
        if(empty($Arr)){
            return false;
        }

        $valid = [];
        foreach ($Arr as $movie) {
            $tmp = Validator::sanitize($movie);
            array_push($valid, $tmp);
        }
        return empty($valid) ? false : $valid;
    }
}

