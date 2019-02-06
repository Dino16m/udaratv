<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

/**
 * Description of Constants
 *
 * 
 */
class Constants {
    
    public const supportedVideoTypes = [ 'naija', 'hollywood','hollywoodmovies','nollywoodmovies','nollywood','bollywoodmovies','bollywoodseries', 'naijaseries','nollywoodseries', 'hollywoodseries', 'comedy', 'bollywood']; 
    public const ismovie =  [ 'naija', 'hollywoodmovies','nollywoodmovies', 'comedy', 'bollywoodmovies']; 
    public const videoUploadLocation = '/videos/';
    public const imageUploadLocation = '/public/images/'; 
    public const isSeries = ['naijaseries','bollywoodseries', 'series', 'hollywoodseries', 'nollywoodseries'];

    public static function getTmp(){
        return '/var/tmp/';
    }
 
    public static function inSeries($Value)
    {
        $series = self::isSeries;
        $value = strtolower($Value);
        foreach ($series as $serie)
        {
            if ($serie == $value){
                return true;
            }
        }
        return false;

    }
    public static function inMovie($Value)
    {
        $movies = self::ismovie;
        $value = strtolower($Value);
        foreach ($movies as $movie)
        {
            if ($movie == $value){
                return true;
            }
        }
        return false;
    }
}
