<?php

namespace App\Models;

use App\Core\App;

class Usuario {

    private $id;
    private $email;
    private $senha;
    private $cliente;

    public function __construct($id = null, $email = null, $senha = null, Cliente $cliente = null){
        $this->id = $id;
        $this->email = $email;
        $this->senha = $senha;
        $this->cliente = $cliente;
   }

    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
	}

	public function getSenha(){
		return $this->senha;
	}

	public function setSenha($senha){
		$this->senha = $senha;
	}

	public function getCliente(){
		return $this->cliente;
	}

	public function setCliente($cliente){
		$this->cliente = $cliente;
    }
    
    public function salvarUsuario(){
        $sql['sql'] = "INSERT INTO usuarios SET email=:email, senha=:senha, cliente_id=:cliente_id";

        $sql['bind_sql']['email'] = $this->getEmail();
        $sql['bind_sql']['senha'] = $this->getSenha();
        $sql['bind_sql']['cliente_id'] = $this->getCliente()->getId();

        if(App::get('database')->insert($sql)){
            
            return true;

        }else{
            
            return false;
        
        }
    }

    public function alterarUsuario(){
        
        $sql['sql']  = "UPDATE usuarios SET email=:email, senha=:senha, cliente_id=:cliente_id ";
        $sql['sql'] .= " WHERE cliente_id =:cliente_id";

        
        $sql['bind_sql']['email'] = $this->getEmail();
        $sql['bind_sql']['senha'] = $this->getSenha();
        $sql['bind_sql']['cliente_id'] = $this->getCliente()->getId();

        if(App::get('database')->dml($sql)){
            
            return true;

        }else{
            
            return false;
        
        }
    }

    public function fazerLogin(){

        $sql['sql']  = " SELECT u.email, c.nome, c.id as cliente_id, c.cpf, c.tipo FROM clientes as c";
        $sql['sql'] .= " LEFT JOIN usuarios as u on(c.id = u.cliente_id)  WHERE ";
        $sql['sql'] .= " u.email =:email and senha=:senha";

        $sql['bind_sql']['email'] = $this->getEmail();
        $sql['bind_sql']['senha'] = $this->getSenha();
        
        $row = App::get('database')->select($sql);
       
            if(isset($row['0']->cliente_id)){
                $_SESSION['usuario']['login'] = true;
                $_SESSION['usuario']['cliente_id']  = $row['0']->cliente_id;
                $_SESSION['usuario']['nome']  = $row['0']->nome;
                $_SESSION['usuario']['cpf']  = $row['0']->cpf;
                $_SESSION['usuario']['tipo']  = $row['0']->tipo;
                $_SESSION['usuario']['email'] = $row['0']->email;
                return true;
            }
        
            $_SESSION['usuario']['login'] = false;

            return false;
        
        }

        public function logado(){
            return ( $_SESSION['usuario']['login'] ? true : false);
        }

        public function logout(){

            if($_SESSION['usuario']['login']){
                unset($_SESSION['usuario']);
                if(!$_SESSION['usuario']['login']){
                    return true;
                }else{
                    return false;
                }
            }

            
        }
}