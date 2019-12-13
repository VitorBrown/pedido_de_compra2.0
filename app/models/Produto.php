<?php

namespace App\Models;

use App\Core\App;

class Produto{

    private $id;
    private $nome;
    private $categoria;
    private $preco;
    private $produto;
    private $criado_em;
    
    public function __construct($id = null, $nome = null, Categoria $categoria = null,
                                $preco = null, Cliente $cliente = null, $criado_em = null){
         $this->id = $id;
         $this->nome = $nome;
         $this->preco = $preco;
         $this->categoria = $categoria;
         $this->cliente = $cliente;
         $this->criado_em = date('d/m/y h:m:s');
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

	public function getCategoria(){
		return $this->categoria;
	}

	public function setCategoria(Categoria $categoria){
		$this->categoria = $categoria;
	}

	public function getPreco(){
		return $this->preco;
	}

	public function setPreco($preco){
		$this->preco = $preco;
	}

	public function setCliente(Cliente $produto){
		$this->cliente = $produto;
	}

	public function getCriado_em(){
		return $this->criado_em;
	}

	public function setCriado_em($criado_em){
		$this->criado_em = $criado_em;
    }
    
    public function salvarProduto(){

        $sql['sql'] = "INSERT INTO produtos SET nome=:nome, preco=:preco, categoria_id=:categoria_id, cliente_id=:cliente_id, criado_em=:criado_em";

        $sql['bind_sql']['nome'] = $this->getNome();
        $sql['bind_sql']['preco'] = $this->getPreco();
        $sql['bind_sql']['categoria_id'] = $this->getCategoria()->getId();
        $sql['bind_sql']['cliente_id'] = $_SESSION['usuario']['cliente_id'];
        $sql['bind_sql']['criado_em'] = $this->getCriado_em();

        $id = App::get('database')->insert($sql);

        if($id){

           return true;

        }else{

            return false;

        }

    }
    
    public function alterarProduto(){

        $sql['sql']  = " UPDATE produtos SET nome=:nome, preco=:preco, categoria_id=:categoria_id ";
        $sql['sql'] .= " WHERE id =:produto_id";
        $sql['sql'] .= " AND cliente_id = :cliente_id";

        $sql['bind_sql']['nome'] = $this->getNome();
        $sql['bind_sql']['preco'] = $this->getPreco();
        $sql['bind_sql']['categoria_id'] = $this->getCategoria()->getId();
        $sql['bind_sql']['cliente_id'] = $_SESSION['usuario']['cliente_id'];
        $sql['bind_sql']['produto_id'] = $this->getId();
        
        if(App::get('database')->dml($sql)){

           return true;

        }else{

            return false;

        }
    }


    public function listarProduto(){

        $sql['sql']  = " SELECT p.nome, p.preco, p.id as produto_id, c.id as categoria_id, c.nome as categoria_nome FROM categorias as c";
        $sql['sql'] .= " RIGHT JOIN categorias as p on(c.id = p.categoria_id)  WHERE p.id = ?";

        $sql['bind_sql']['id'] = $this->getId();
    
        try{

                if($row = App::get('database')->select($sql)){

                $produto = new Produto();
                $categoria = new Categoria;

                $produto->setId($row[0]->produto_id);
                $categoria->setId($row[0]->categoria_id);
                $categoria->setNome($row[0]->categoria_nome);
                $produto->setCategoria($categoria);
                $produto->setNome($row[0]->nome);
                $produto->setPreco($row[0]->preco);

                }
            
        }catch(Exception $e){

            return 'Erro em listar produto';

        }

        return $produto;
    }

    public function listarTodosProduto(){

        $sql['sql']  = ' SELECT p.id as produto_id, c.id as categoria_id, p.nome as produto_nome, c.nome as categoria_nome,';
        $sql['sql'] .= ' p.preco FROM produtos as p';
        $sql['sql'] .= ' LEFT JOIN categorias as c on (p.categoria_id = c.id)';
        $sql['sql'] .= ' where p.cliente_id = :cliente_id';
        $sql['sql'] .= ' order by p.nome asc';
        
        $sql['bind_sql']['cliente_id'] = $_SESSION['usuario']['cliente_id'];

        $produtos = array();

        try{

            if($row = App::get('database')->select($sql)){
              
                foreach($row as $row){

                    $produto = new Produto();
                    $categoria = new Categoria;

                    $produto->setId($row->produto_id);
                    $categoria->setId($row->categoria_id);
                    $categoria->setNome($row->categoria_nome);
                    $produto->setCategoria($categoria);
                    $produto->setNome($row->produto_nome);
                    $produto->setPreco($row->preco);

                    $produtos[] = $produto;
                }

            }else{

                return false;

            }

        }catch(Exception $e){

            return 'Erro em listar produtos';
        }

        return $produtos;
    }

    
    public function deletarProduto(){

        $sql['sql']  = " DELETE FROM produtos WHERE id in (:id)";
        $sql['sql'] .= " AND cliente_id = :cliente_id";
     
        $sql['bind_sql']['id'] = $this->getId();
        $sql['bind_sql']['cliente_id'] = $_SESSION['usuario']['cliente_id'];
       
        if(App::get('database')->dml($sql)){

           return true;

        }else{

            return false;

        }

    }
}
?>