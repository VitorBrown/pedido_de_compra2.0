<?php
  
  include('layout/header.php');
?>
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Produtos</h1>

<div id='background' class="card o-hidden border-0 shadow-lg my-5">
<div class="card-body p-0">
  <div class="row">
    <div class="col-lg-12 col-sm-12">
      <div class="p-5">
      <div class="card">
        <div class="card-header">
          <button id='produtoNovo' type='button' onchange='adicionarProdutoEdit()' data-toggle='modal'  data-target='#produtoModal' class='btn btn-primary'>Adicionar Novo Produto</button>
        </div>
        <ul id='resultado' class="list-group list-group-flush">
          <?php foreach($produto as $p):?>
            <li class='list-group-item'>
                    <div class='btn-group' role='group' >
                    <button type='button' onclick='editarProduto(this)' data-id='<?=$p->getId()?>'  data-toggle='modal'
                      data-target='#produtoModal' data-nome='<?=$p->getNome()?>' data-preco='<?=$p->getPreco()?>' data-categoria_id='<?=$p->getCategoria()->getId()?>'  class='btn btn-warning'>Editar</button>
                    <button type='button' onclick='excluirProduto(this)' data-id='<?=$p->getId()?>' class='btn btn-danger'>Exluir</button>
                    </div>
                     Nome: <?=$p->getNome()?> Categoria: <?=$p->getCategoria()->getNome()?> Preço: R$<?=$p->getPreco()?>;
                    </li>
          <?php endforeach;?>
        </ul>
      </div>
      </div>
    </div>
  </div>
</div>
</div>

</div>

<div class="modal fade" id="produtoModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="titulo"> </h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

        <form id="formProduto" action="produto/criar" method="post">
                <input type='hidden' id='id' name='id' value=''>
                <div class="form-group row">
                  <div class="col-sm-12 mb-3 mb-sm-0">
                    <input type="text" id='nome' name='nome' class="form-control form-control-user" placeholder="Digite o nome do produto">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <select id="categoria" name='categoria_id' class="form-control form-control-user">
                        <?php foreach($categoria as $c): ?>
                           <option value="<?=$c->getId()?>"><?=$c->getNome()?></option>
                        <?php endforeach; ?>
                    </select>
                  </div>
                  <div class="col-sm-6">
                    <input type="text" id='preco' name='preco' class="form-control form-control-user" placeholder="Digite o preço">
                  </div>
                </div>
                <a id='botaoProduto' href="#" class="btn btn-primary btn-block">
                  Adiciona novo produto
                </a>
         </form>
        
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

<!-- /.container-fluid -->
<script src='public/js/produtoAjax.js'></script>
    
<?php 
    include_once('layout/footer.php');
?>