<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\Cliente;
use App\Models\Usuario;

class ClienteController{

    public function auth(){
        $middleware = array();
        $middleware['auth']['restrict_for'] = '*';
        $middleware['auth']['restrict'] = '*';
        $middleware['auth']['except'] = explode(',','');

        return $middleware;
    }


    public function home(){

        $cliente = new Cliente;

        $cliente = $cliente->listarTodosClientes();

        return view('sistema.listarCliente', compact('cliente'));
    }

    public function criar(){

        $request = $_POST;
  
        $cliente = new Cliente;
        $usuario = new USuario;

        $cliente->setNome($request['nome']);
        $cliente->setCPF($request['cpf']);
        $cliente->setTipo($request['tipo']);

        $usuario->setEmail($request['email']);
        $usuario->setSenha($request['senha']);

        $cliente->setUsuario($usuario);

        $status = 'Ops, houve um erro em criar o cliente';

        if($cliente->salvarCliente()){
        
            $status = 'Cliente Criado com sucesso';
        }

        echo json_encode($status);

    }

    public function alterar(){

        $request = $_POST;
        $cliente = new Cliente;
        $usuario = new USuario;

        $cliente->setId($request['id']);
        $cliente->setNome($request['nome']);
        $cliente->setCPF($request['cpf']);
        $cliente->setTipo($request['tipo']);

        $usuario->setEmail($request['email']);
        $usuario->setSenha($request['senha']);

        $cliente->setUsuario($usuario);
        
        $status = 'Ops, houve um erro em alterar o cliente';

        if($cliente->alterarCliente()){
        
            $status = 'Cliente Criado com sucesso';
        }

        echo json_encode($status);

    }

    public function listarClientes(){
        $request = $_POST;
        $cliente = new Cliente();
        
        if(isset($request['id'])){
            $cliente->setId($request['id']);
            return $cliente->listarCliente();
        }

        return $cliente->listarTodosClientes();
    }

    public function excluir(){
        $request = $_POST;
        $cliente = new Cliente;

        if(isset($request['id'])){
            
            $request['id'] = $request['id'];
            $cliente->setId($request['id']);
            return $cliente->deletarCliente();

        }else{
            echo "Campo id está vazio";
        }
    }

}