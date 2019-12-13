<?php
session_start();
use App\Core\App;

$_SERVER['HTTP_HOST']= 'http://localhost/floripa_project/';

$_SERVER['SERVER_NAME']= 'http://localhost/floripa_project/';

$_SERVER['REQUEST_URI'] = explode('/', $_SERVER['REQUEST_URI']);

unset($_SERVER['REQUEST_URI'][0], $_SERVER['REQUEST_URI'][1]);

$_SERVER['REQUEST_URI'] = '/'.implode('/', $_SERVER['REQUEST_URI']);

App::bind('config', require 'config.php');


App::bind('database', new QueryBuilder(
    Connection::make(App::get('config')['database'])
));

function view($name, $data = []){

    if(strstr( $name, '.' )){
        $name = explode('.', $name);
        $name = implode('/', $name);
    }
    
    extract($data);

    return require "app/views/{$name}.view.php";    
}

function redirect($path){
   $path = $_SERVER['HTTP_HOST']."".$path;

    header("Location: ".$path);

}