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
    
    public const supportedVideoTypes = [ 'naija', 'hollywood', 'naijaseries', 'hollywoodseries', 'comedy', 'bollywood']; 
    public const ismovie =  [ 'naija', 'hollywood', 'comedy', 'bollywood']; 
    public const videoUploadLocation = '/videos/';
    public const imageUploadLocation = '/public/images/'; 
    public const isSeries = ['naijaseries', 'series', 'hollywoodseries'];
    
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
