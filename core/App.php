<?php

namespace App\Core;

class App{

    protected static $registry = [];

    public static function bind($key, $value)
    {
        static::$registry[$key] = $value;
    }

    public static function get($key)
    {
        if(!array_key_exists($key, static::$registry)){
            throw new Exception("Não existe está chave {$key} no registrador");
        }
        return static::$registry[$key];
    }

    function dd($dd){

        '<pre>'.var_dump($dd);
        
        exit;
    }
    
    function back(){
    
        return header("Location: ". $_SERVER['HTTP_REFERER']);
    
    }

} 