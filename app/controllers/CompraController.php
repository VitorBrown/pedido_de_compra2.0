<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\Cliente;
use App\Models\Produto;
use App\Models\Compra;
use App\Models\Categoria;
use App\Models\Loja;

class CompraController{

    public function auth(){
        $middleware = array();
        $middleware['auth']['restrict_for'] = '*';
        $middleware['auth']['restrict'] = '*';
        $middleware['auth']['except'] = explode(',','');

        return $middleware;
    }

   public function home(){
       $compra = new Compra;

       $compras =  $compra->listarTodasCompras(1);
       $pedidos =  $compra->listarTodasCompras(2);
      
        return view('sistema.pedidoCompra', compact('compras', 'pedidos'));
    }

    public function loja(){

        $loja = new Loja;
        $categoria = new Categoria;

        $categoria =  $categoria->listarTodasCategoria();

        return view('sistema.loja', compact('categoria'));
    }

    public function listarTodasLoja(){
        $post = $_POST;

        $loja = new Loja;
        $produto = new Produto;
        $categoria = new Categoria;

        $loja->setProduto($produto);
        $loja->getProduto()->setPreco($post['valor']);
        $loja->getProduto()->setCriado_em($post['data']);
        $loja->getProduto()->setCategoria($categoria);
        $loja->getProduto()->getCategoria()->setId($post['categoria_id']);
        

        echo $loja->listarProdutosLoja($post);
    }

    public function criar(){
        $request = $_POST;

        $compra = new Compra;
        $produto = new Produto;

        $produto->setId($request['id']);
        $compra->setQuantidade($request['quantidade']);
        $compra->setProduto($produto);
        
        $status = 'Ops, houve um erro em criar a compra';

        if($compra->salvarCompra()){
            $status = 'Compra criada com sucesso';
        }

        echo json_encode($status);
    }

    public function alterar(){
        $request = $_POST;

        $compra = new Compra;
        $produto = new Produto;

        $produto->setId($request['produto_id']);
        $compra->setQuantidade($request['quantidade']);
        $compra->setStatus($request['status']);
        $compra->setId($request['id']);
        $compra->setProduto($produto);
        
        $status = 'Ops, houve um erro em criar a compra';

        if($compra->alterarCompra()){
            $status = 'Compra alterada com sucesso';
        }

        echo json_encode($status);
    }

    public function listar(){
        $request = $_POST;
        $compra = new Compra();
        
        if(isset($request['id'])){
            $compra->setId($request['id']);
            return $compra->listarCompra();
        }

        return $compra->listarTodosCompra();
    }

    public function excluir(){
        $request = $_POST;
        $compra = new Compra();
        
        if(isset($request['id'])){
            $compra->setId($request['id']);
            return $compra->deletarCompra();

        }
    }
}