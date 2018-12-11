<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App;

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
          return $input;
          
      }
    public static function  isInt($var)
    {
      return (is_int($var) || ctype_digit($var));
    }
    public static function isValid($value){
         if(isset($value)){
             return $this::sanitize($value);
         }
         else{return null;}
     }
     public static function makeInsane($Name)
     {
      return preg_replace('_',' ', $Name);
     }
    }
    