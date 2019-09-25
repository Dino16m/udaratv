<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;
use App\Constants;
/**
 * Description of Validator
 *
 * 
 */
class Validator {
    public static function validateEmail(){}
    public static function validateInput(){}
    
    public static function sanitize($input){
          $input= trim($input);
          $input = stripslashes($input);
          $input= htmlspecialchars($input);
          $input = self::isEmptyString($input) ? '0ith5' : $input;
          return $input;
          
      }
    public static function isValidExtension($ext)
    {
      if(!in_array($ext, Constants::unAllowedExtensions) && strlen($ext)>0) return true;
      return false;

    }
    public static function  isInt($var)
    {
      return (is_int($var) || ctype_digit($var));
    }


    public static function isEmptyString($var)
    {
      return(empty($var) && $var!='0');
    }
    public static function isValid($value){
         if(isset($value)){
             return self::sanitize($value);
         }
         else{return null;}
     }
     public static function makeInsane($Name)
     {
      return preg_replace('~_~',' ', $Name);
     }
    }
    