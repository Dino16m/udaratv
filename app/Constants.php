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
    
    public const supportedVideoTypes = [ 'naija', 'hollywood','hollywoodmovies','nollywoodmovies','nollywood','bollywoodmovies','bollywoodseries', 
            'naijaseries','nollywoodseries', 'hollywoodseries','comedy',
             'bollywood', 'animemovies','asianmovies','animeseries','asianseries', 'anime' ]; 
    public const ismovie =  [ 'naija', 'hollywoodmovies','nollywoodmovies', 'animemovies','asianmovies', 'comedy', 'bollywoodmovies']; 
    public const videoUploadLocation = '/videos/';
    public const imageUploadLocation = '/public/images/'; 
    public const isSeries = ['naijaseries','bollywoodseries','animeseries','asianseries','series', 'hollywoodseries', 'nollywoodseries'];
    public const rawStoragePath= '/storage/app/raw/';
    public const compressionDirectory ='/videos/compressing/';
    public const defaultPicture = 'public/udaralogo.png';
    public const telegramRecipients = ['successvisa','me',];
    public const unAllowedExtensions = ['com', 'jpg', 'jpeg', 'png', 'me', 'space'];

    public static function waterMark()
    {
     return base_path('/public/watermark.png');
    }

    public static function getTmp(){
        return '/var/tmp/';
    }
 
    public static function inSeries($Value)
    {
        $series = self::isSeries;
        $value = strtolower($Value);
        return in_array($value, $series) ? true : false;
    }

    public static function inMovie($Value)
    {
        $movies = self::ismovie;
        $value = strtolower($Value);
        return in_array($value, $movies) ? true : false;
    }
}
