<?php

namespace App\Models;

use App\Core\App;

class Categoria{

    private $id;
    private $nome;

    public function __construct($id = null, $nome = null){
        $this->id = $id;
        $this->nome = $nome;
    }

    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

    public function getNome(){
		return $this->Nome;
	}

	public function setNome($Nome){
		$this->Nome = $Nome;
    }
    
    public function listarTodasCategoria(){
        $sql['sql'] = " SELECT c.nome, c.id as categoria_id FROM categorias as c order by c.nome asc";
        $sql['bind_sql'] = array();
        $categorias = array();

        try{

            if($row = App::get('database')->select($sql)){

                foreach($row as $row){

                    $categoria = new Categoria;
                    $categoria->setId($row->categoria_id);
                    $categoria->setNome($row->nome);

                    $categorias[] = $categoria;
                }

            }else{

                return false;

            }

        }catch(Exception $e){

            return 'Erro em listar categorias';
        }
       
        return $categorias;

    }
    
    public function salvarCategoria(){
        $sql['sql'] = "INSERT INTO categorias SET email=:email, senha=:senha, cliente_id=:cliente_id";

        $sql['bind_sql']['email'] = $this->getEmail();
        $sql['bind_sql']['senha'] = $this->getSenha();
        $sql['bind_sql']['cliente_id'] = $this->getCliente_id();

        if(App::get('database')->insert($sql)){
            
            return true;

        }else{
            
            return false;
        
        }
    }

    public function alterarCategoria(){
        
        $sql['sql']  = "UPDATE categorias SET email=:email, senha=:senha, cliente_id=:cliente_id ";
        $sql['sql'] .= " WHERE cliente_id =:cliente_id";

        
        $sql['bind_sql']['email'] = $this->getEmail();
        $sql['bind_sql']['senha'] = $this->getSenha();
        $sql['bind_sql']['cliente_id'] = $this->getCliente_id();

        if(App::get('database')->dml($sql)){
            
            return true;

        }else{
            
            return false;
        
        }
    }

    public function deletarCategoria(){
        
        $sql['sql']  = "UPDATE categorias SET email=:email, senha=:senha, cliente_id=:cliente_id ";
        $sql['sql'] .= " WHERE cliente_id =:cliente_id";

        
        $sql['bind_sql']['email'] = $this->getEmail();
        $sql['bind_sql']['senha'] = $this->getSenha();
        $sql['bind_sql']['cliente_id'] = $this->getCliente_id();

        if(App::get('database')->dml($sql)){
            
            return true;

        }else{
            
            return false;
        
        }
    }


}