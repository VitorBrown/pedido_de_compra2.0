<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\Cliente;
use App\Models\Usuario;

class UsuarioController{
    
    public function auth(){
        $middleware = array();
        $middleware['auth']['restrict_for'] = 'auth';
        $middleware['auth']['restrict'] = '*';
        $middleware['auth']['except'] = explode(',','logout');

        return $middleware;
    }
    
    public function home(){

        return view('index');
    }


    public function login(){
        $usuario = new Usuario;
        $request = $_POST;

        $usuario->setEmail($request['email']);
        $usuario->setSenha($request['senha']);

        if($usuario->fazerLogin()){
            redirect('cliente');
        }else{
            redirect('loja');
        }  
    }

    public function logout(){
        $usuario = new Usuario;

        if($usuario->logout()){
            redirect('');
        } 
    }
}