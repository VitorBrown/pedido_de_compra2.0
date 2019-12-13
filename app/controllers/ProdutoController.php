<?php

namespace App\Controllers;

use App\Core\App;

use App\Models\Produto;
use App\Models\Categoria;

class ProdutoController{

    public function auth(){
        $middleware = array();
        $middleware['auth']['restrict_for'] = '*';
        $middleware['auth']['restrict'] = '*';
        $middleware['auth']['except'] = explode(',','');

        return $middleware;
    }
    

    public function home(){

        $produto = new Produto;
        $categoria = new Categoria;

        $produto = $produto->listarTodosProduto();
        $categoria = $categoria->listarTodasCategoria();

        return view('sistema.adicionarProduto', compact('produto', 'categoria'));
    }

    public function criar(){
        $request = $_POST;

        $produto = new Produto;
        $categoria = new Categoria;

        $produto->setNome($request['nome']);
        $produto->setPreco($request['preco']);
        $categoria->setId($request['categoria_id']);
        $produto->setCategoria($categoria);

        
        $status = 'Ops, houve um erro em criar o produto';

        if($produto->salvarProduto()){
    
            $status = 'Produto criado com sucesso';
        }

        echo json_encode($status);
    }

    public function alterar(){
        $request = $_POST;

        $produto = new Produto;
        $categoria = new Categoria;

        $produto->setId($request['id']);
        $produto->setNome($request['nome']);
        $produto->setPreco($request['preco']);
        $categoria->setId($request['categoria_id']);
        $produto->setCategoria($categoria);

        $status = 'Ops, houve um erro em criar o produto';

        if($produto->alterarProduto()){
            $status = 'Produto criado com sucesso';
        }

        echo json_encode($status);
    }

    public function listar(){
        $request = $_POST;
        $produto = new Produto();
        
        if(isset($request['id'])){
            $produto->setId($request['id']);
            return $produto->listarProduto();
        }

        return $produto->listarTodosProduto();
    }

    public function excluir(){
        $request = $_POST;
        $produto = new Produto();
        
        if(isset($request['id'])){

            $request['id'] = $request['id'];
            $produto->setId($request['id']);
            echo json_encode($produto->deletarProduto());

        }else{

            echo "Campo id está vazio";
        }
    }
}