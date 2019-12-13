<?php

namespace App\Core;

class Router {
    public $routes = [

        'GET' => [],

        'POST' => []

    ];

    public static function load($file){
        
        $router = new static;

        require $file;

        return $router;
    }

    public function get($uri, $controller){
        $this->routes['GET'][$uri] = $controller;
    }

    public function post($uri, $controller){
        $this->routes['POST'][$uri] = $controller;
    }

    public function direct($uri, $requestType){

        if(array_key_exists($uri, $this->routes[$requestType])){

            $controller = explode('@', $this->routes[$requestType][$uri])[0];
            $action = explode('@', $this->routes[$requestType][$uri])[1];

            return $this->callAction($controller, $action);

        }
        throw new \Exception('Nenhuma rota selecionada para essa URL');
    }

    protected function callAction($controller, $action){

        $controller = "App\\Controllers\\{$controller}";

        $controller = new $controller;

        $middleware = $controller->auth();


        if(!method_exists($controller, $action)){
            throw new Exception(
                'A função '.$action.' não existe para este controller '
            );
        }

        if(isset($_SESSION['usuario']['login']) && $_SESSION['usuario']['login'] == true){

            if($middleware['auth']['restrict_for'] == 'auth' && !in_array($action, $middleware['auth']['except'])){
                return header("Location: ".$_SERVER['HTTP_HOST'].'cliente');
            }

            if($middleware['auth']['restrict_for'] == 'auth' && in_array($action, $middleware['auth']['except']) ){
                return $controller->$action();
            }

            if($middleware['auth']['restrict_for'] == '*'){
                return $controller->$action();
            }

        }else{
          
            $controller = 'UsuarioController';

            $controller = "App\\Controllers\\{$controller}";

            $controller = new $controller;
            
            $middleware = $controller->auth();
          
                
            if($middleware['auth']['restrict_for'] == 'auth'){
                 return $controller->$action();
            }
        

        }
        
    }

}