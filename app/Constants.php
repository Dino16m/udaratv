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
class constants {
    
    public const supportedVideoTypes = [ 'naija', 'hollywood', 'naijaseries', 'hollywoodseries', 'comedy', 'bollywood']; 
    public const ismovie =  [ 'naija', 'hollywood', 'comedy', 'bollywood']; 
    public const videoUploadLocation = '/public/resources/videos/';
    public const imageUploadLocation = '/public/resources/images/'; 
    public const isSeries = ['naijaseries', 'hollywoodseries'];
    
    public static function inSeries($Value)
    {
        $series = $this::isSeries;
        $value = strtolower($Value);
        foreach ($series as $serie)
        {
            if ($serie == $value){
                return true;
            }
        }
        return false;

    }
    public function inMovie($Value)
    {
        $movies = $this::ismovie;
        $value = strtolower($Value);
        foreach ($series as $serie)
        {
            if ($serie == $value){
                return true;
            }
        }
        return false;
    }
}
