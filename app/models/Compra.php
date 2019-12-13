<?php

namespace App\Models;

use App\Core\App;

class Compra {

    private $id;
    private $produto;
    private $cliente;
    private $quantidade;
    private $criado_em;
    private $status;
    private $total;

    public function __construct($id = null, Produto $produto = null, Cliente $cliente = null, $quantidade = 1, $criado_em = null, $status = 2) {
        $this->id = $id;
        $this->produto = $produto;
        $this->cliente = $cliente;
        $this->quantidade = $quantidade;
        $this->status= $status;
        $this->criado_em = date('y-m-d h:m:s');
    }

    public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
	}

	public function getProduto(){
		return $this->produto;
	}

	public function setProduto($produto){
		$this->produto = $produto;
	}

	public function getCliente(){
		return $this->cliente;
	}

	public function setCliente($cliente){
		$this->cliente = $cliente;
	}

	public function getQuantidade(){
		return $this->quantidade;
	}

	public function setQuantidade($quantidade){
		$this->quantidade = $quantidade;
	}

	public function getCriado_em(){
		return $this->criado_em;
	}

	public function setCriado_em($criado_em){
		$this->criado_em = $criado_em;
	}

	public function getStatus(){
        switch($this->status){
            case 1:
                $status = 'Pago';
            break;
            case 2:
                $status = 'Em Aberto';
            break;
            case 0:
                $status = 'Cancelado';
            break;
        }
		return $status;
    }
     
    public function getNumberStatus(){
		return $this->status;
    }

	public function setStatus($status){
     
		$this->status = $status;
    }
    
    public function getTotal(){
		return $this->total;
	}

	public function setTotal($total){
		$this->total = $total;
    }
   
    
    public function salvarCompra(){
        $sql['sql']  = " INSERT INTO compras SET cliente_id=:cliente_id, produto_id=:produto_id, quantidade=:quantidade, criado_em=:criado_em, ";
        $sql['sql'] .= " total = (select (preco * :quantidade) total from produtos where id = :produto_id)";

        $sql['bind_sql']['produto_id'] = $this->getProduto()->getId();
        $sql['bind_sql']['cliente_id'] = $_SESSION['usuario']['cliente_id'];
        $sql['bind_sql']['quantidade'] = $this->getQuantidade();
        $sql['bind_sql']['status'] = $this->getNumberStatus();
        $sql['bind_sql']['criado_em'] = $this->getCriado_em();

        if(App::get('database')->insert($sql)){
            
            return true;

        }else{
            
            return false;

        }
        
    }

    public function alterarCompra(){
        
        $sql['sql']  = " UPDATE compras SET ";
        $sql['sql'] .= " status=:status";
        $sql['sql'] .= " WHERE id = :compra_id";
        
        $sql['bind_sql']['compra_id'] = $this->getId();
        $sql['bind_sql']['status'] = $this->getNumberStatus();
    
        if(App::get('database')->dml($sql)){
            
            return true;

        }else{

            return false;

        }
            
          
    }

    public function listar(){

        $sql['sql']   = ' SELECT p.nome AS produto_nome, c.nome AS categoria_nome, c.id AS categoria_id, p.id AS produto_id, ';
        $sql['sql']  .= ' p.preco, cli.nome AS cliente_nome, cli.id AS cliente_id, com.id AS compra_id, com.quantidade, com.total';
        $sql['sql']  .= ' FROM compras AS com';
        $sql['sql']  .= ' INNER JOIN produtos AS p ON (p.id = com.produto_id)';
        $sql['sql']  .= ' INNER JOIN clientes AS cli ON (cli.id = com.cliente_id)';
        $sql['sql']  .= ' LEFT JOIN categorias AS c ON (c.id = p.categoria_id)';
        $sql['sql']  .= ' WHERE com.id = compra_id';
        $sql['sql']  .= ' ORDER BY com.id DESC';

        $sql['bind_sql']['compra_id'] = $this->getId();
        
        try{

            if($row = App::get('database')->select($sql)){

               foreach($row as $row){

                   $produto = new Produto;
                   $categoria = new Categoria;
                   $compra = new Compra;
                   $cliente = new Cliente;

                   $compra->setId($row->compra_id);
                   
                   $cliente->setId($row->cliente_id);
                   $cliente->setNome($row->cliente_nome);

                   $compra->setCliente($cliente);

                   $produto->setId($row->produto_id);
                   $produto->setNome($row->produto_nome);
                   $produto->setPreco($row->preco);

                   $categoria->setId($row->categoria_id);
                   $categoria->setNome($row->categoria_nome);

                   $produto->setCategoria($categoria);

                   $compra->setProduto($produto);
                   $compra->setStatus($row->status);
                   $compra->setCriado_em($row->compra_feita_em);

                   $compras[] = $compra;
               }

           }else{

               return false;

           }

       

    }catch(Exception $e){

        return "ops houve um erro na query".$sql['sql'];

    }
    }

    public function listarTodasCompras($tipo){

        $sql['sql']   = 'select com.Id as compra_id, com.quantidade, com.status, com.criado_em as compra_feita_em, ';
        $sql['sql']  .= 'p.nome as produto_nome, p.id as produto_id, ';
        $sql['sql']  .= 'cat.Id as categoria_id, cat.nome as categoria_nome, p.preco, com.total ';
        $sql['sql']  .= 'from produtos as p ';
        $sql['sql']  .= 'inner join compras as com on(com.produto_id = p.Id) ';
        $sql['sql']  .= 'inner join clientes as cli on(com.cliente_id = com.cliente_id) ';
        $sql['sql']  .= 'inner join categorias as cat on(p.categoria_id = cat.Id) ';

        if($tipo == 1 ){
            $sql['sql']  .= 'where com.cliente_id = :cliente_id';
        }else{
            $sql['sql']  .= 'where p.cliente_id = :cliente_id';
        }
        $sql['sql']  .= ' group by com.id ';
        $sql['sql']  .= 'order by com.criado_em, com.status desc ';
                    
        $sql['bind_sql']['cliente_id'] = $_SESSION['usuario']['cliente_id'];
        
        $compras = false;

        try{

                 if($row = App::get('database')->select($sql)){

                    foreach($row as $row){

                        $produto = new Produto;
                        $categoria = new Categoria;
                        $compra = new Compra;
                        $cliente = new Cliente;

                        $compra->setId($row->compra_id);

                        $produto->setId($row->produto_id);
                        $produto->setNome($row->produto_nome);
                        $produto->setPreco($row->preco);

                        $categoria->setId($row->categoria_id);
                        $categoria->setNome($row->categoria_nome);

                        $produto->setCategoria($categoria);

                        $compra->setProduto($produto);
                        $compra->setQuantidade($row->quantidade);
                        $compra->setStatus($row->status);
                        $compra->setTotal($row->total);
                        $compra->setCriado_em($row->compra_feita_em);

                        $compras[] = $compra;
                    }

                }else{

                    return false;

                }

            

        }catch(Exception $e){

            return "ops houve um erro na query".$sql['sql'];

        }
        

        return $compras;
    }


    
    public function deletarCompra(){
            
        $sql['sql'] = "DELETE FROM compras WHERE id=:compra_id ";
        $sql['bind_sql']['compra_id'] = $this->getId();

        if(App::get('database')->dml($sql)){
            
            return true;

        }else{

            return false;

        }

    }

    public function deletarCompraLote(){

        $sql['sql'] = "DELETE FROM compras WHERE id in (:compra_id)";
        $sql['bind_sql']['compra_id'] = $this->getId();

        if(App::get('database')->dml($sql)){
            
            return true;

        }else{

            return false;

        }
    }
}
?>