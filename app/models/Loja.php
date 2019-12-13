<?php

namespace App\Models;

use App\Core\App;

class Loja extends Compra{

    public function listarProdutosLoja($post){

        $sql['sql']    = '	SELECT p.nome AS produto_nome, c.nome AS categoria_nome, c.id AS categoria_id, p.id AS produto_id,';
        $sql['sql']   .= '	 p.preco, cli.nome AS cliente_nome, cli.id AS cliente_id, p.criado_em';
        $sql['sql']   .= '	from produtos as p';
        $sql['sql']   .= '	inner join clientes as cli on(p.cliente_id = cli.Id)';
        $sql['sql']   .= '	left join categorias as c on(c.Id = p.categoria_id)';
        $sql['sql']   .= '   where p.cliente_id <> :cliente_id';

        $sql['bind_sql']['cliente_id'] = $_SESSION['usuario']['cliente_id'];

        if($this->getProduto()->getCategoria()->getId()){

            $sql['sql'] .= '  and categoria_id= :categoria_id';
            $sql['bind_sql']['categoria_id'] = $this->getProduto()->getCategoria()->getId();

        }

        if($this->getProduto()->getPreco() || $this->getProduto()->getCriado_em()){
            $sql['sql'] .= '  order by ';
            $filtro = array();
            if($this->getProduto()->getPreco() == 1){
                $filtro[] = 'p.preco asc';
            }

            if($this->getProduto()->getPreco() == 2){
                $filtro[] = 'p.preco desc';
            }

            if($this->getProduto()->getCriado_em() == 1){
                $filtro[] = 'p.criado_em asc';
            }

            if($this->getProduto()->getCriado_em() == 2){
                $filtro[] = 'p.criado_em desc';
            }
            
            $sql['sql'] .= implode(',', $filtro);

        }

        $lojas = array();

        $row = App::get('database')->select($sql);

        if(count($row) > 0){

        $totalPagina = count($row) / $post['item_pagina'];
       
        if($totalPagina > 1){

            $sql['sql'] .= ' LIMIT '.($post['pagina'] - 1) * $post['item_pagina'].','. $post['item_pagina'];

        }else{

            $totalPagina = 1;

        }

        $dados = App::get('database')->select($sql);
        
        $lojas = array();

            foreach($dados as $row){

                $lojas[] = $row;

            }

            $json = array(
                'dado' => array(
                    'loja' => $lojas, 
                    'totalPagina' => $totalPagina
                )
            );
           
        }else{

            $json = array(
                'dado' => array(
                    'loja' => null,
                    'totalPagina' => 1
                )
            );

        }

        
   
     return json_encode($json);
    
    }

    
  
}
?>