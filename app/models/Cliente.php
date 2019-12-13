<?php

namespace App\Models;

use App\Core\App;

class Cliente{

    private $id;
    private $nome;
    private $cpf;
    private $tipo;
    private $usuario;
    
    public function __construct($id = null, $nome = null, $cpf = null, $tipo = 'a', Usuario $usuario = null){
         $this->id = $id;
         $this->nome = $nome;
         $this->cpf = $cpf;
         $this->tipo = $tipo;
         $this->usuario = $usuario;
    }

    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getNome(){
		return $this->nome;
	}

	public function setNome($nome){
		$this->nome = $nome;
	}

	public function getCpf(){
		return $this->cpf;
	}

	public function setCpf($cpf){
		$this->cpf = $cpf;
	}

	public function getTipo(){
		return $this->tipo;
	}

	public function setTipo($tipo){
		$this->tipo = $tipo;
	}

	public function getUsuario(){
		return $this->usuario;
	}

	public function setUsuario(Usuario $usuario){
		$this->usuario = $usuario;
	}
    
    public function salvarCliente(){
        $sql['sql'] = "INSERT INTO clientes SET nome=:nome, cpf=:cpf, tipo=:tipo ";

        $sql['bind_sql']['nome'] = $this->getNome();
        $sql['bind_sql']['cpf'] = $this->getCpf();
        $sql['bind_sql']['tipo'] = $this->getTipo();
        
        $this->setId(App::get('database')->insert($sql));
   
        $this->getUsuario()->setCliente($this);

        if($this->getUsuario()->getCliente()->getId()){

           return $this->getUsuario()->salvarUsuario();

        }else{

            return false;

        }

    }
    
    public function alterarCliente(){
        
        $sql['sql'] = "UPDATE clientes SET nome=:nome, cpf=:cpf, tipo=:tipo WHERE id=:id";

        $sql['bind_sql']['id'] = $this->getId();
        $sql['bind_sql']['nome'] = $this->getNome();
        $sql['bind_sql']['cpf'] = $this->getCpf();
        $sql['bind_sql']['tipo'] = $this->getTipo();
        
        App::get('database')->dml($sql);
   
        $this->getUsuario()->setCliente($this);

        if($this->getUsuario()->getCliente()->getId()){

           return $this->getUsuario()->alterarUsuario();

        }else{

            return false;

        }
    }

    public function deletarCliente(){

        $sql['sql']  = "DELETE FROM clientes WHERE id in (:id) ";
   
        $sql['bind_sql']['id'] = $this->getId();
   
        if(App::get('database')->dml($sql)){

           return "Cliente excluido com sucesso";

        }else{

            return false;

        }

    }

    public function listarCliente(){

        $sql['sql']  = " SELECT u.email, c.nome, c.id as cliente_id, c.tipo, c.cpf  FROM clientes as c";
        $sql['sql'] .= " LEFT JOIN usuarios as u on(c.id = u.cliente_id)  WHERE c.id = :id";

        $sql['bind_sql']['id'] = $this->getId();
    
        try{

                if($row = App::get('database')->select($sql)){

                $cliente = new Cliente();

                $cliente->setId($row[0]->cliente_id);
                $cliente->setNome($row[0]->nome);
                $cliente->setEmail($row[0]->email);
                $cliente->setTipo($row[0]->tipo);
                $cliente->setCpf($row[0]->cpf);

                }
            
        }catch(Exception $e){

            return 'Erro em listar cliente';

        }

        return $cliente;
    }

    public function listarTodosClientes(){

        $sql['sql']  = " SELECT u.email, c.nome, c.id  as cliente_id, c.tipo, c.cpf FROM clientes as c";
        $sql['sql'] .= " INNER JOIN usuarios as u on(c.id = u.cliente_id) order by c.id ";
        
        $clientes = array();

        try{

            if($row = App::get('database')->select($sql)){

                foreach($row as $row){

                    $cliente = new Cliente();
                    $usuario = new Usuario();

                    $cliente->setId($row->cliente_id);
                    $cliente->setNome($row->nome);

                    $usuario->setEmail($row->email);
                    $cliente->setUsuario($usuario);

                    $cliente->setTipo($row->tipo);
                    $cliente->setCpf($row->cpf);  

                    $clientes[] = $cliente;
                }

            }else{

                false;

            }

        }catch(Exception $e){

            return 'Erro em listar clientes';
        }
       
        return $clientes;
    }
}
?>