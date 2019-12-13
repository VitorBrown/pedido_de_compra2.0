<?php
  
  include('layout/header.php');
?>
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Compras</h1>

<div id='background' class="card o-hidden border-0 shadow-lg my-5">
<div class="card-body p-0">
  <div class="row">
    <div class="col-lg-6 col-sm-12">
      <div class="p-5">
          <div class="card">
          <div class="card-header">
            Compras
          </div>
          <ul id='compra' class="list-group list-group-flush">
          <?php if(isset($compras) && $compras): ?>
            <?php foreach($compras as $c): ?>
              <li class="list-group-item">
                <p>Numero do pedido: <b> <?=$c->getId();?></b></p>
                <p>Nome: <b> <?=$c->getProduto()->getNome();?> </b>, Categoria: <b>  <?=$c->getProduto()->getCategoria()->getNome();?> </b>,  
               Preco: <b> <?=$c->getProduto()->getPreco();?> </b> Quantidade: <b>  <?=$c->getQuantidade();?> </b> Preco: <b> <?=$c->getId();?> </b>, 
                Pedido feito em: <b><?=$c->getCriado_em();?></b>
                Status: <b><?=$c->getStatus();?></b></p>
               </li>
            <?php endforeach;?>
            <?php else: ?>
          <li class="list-group-item"> 
            <p>Não existe compras no momento</p>
          </li>
        <?php endif; ?>
          </ul>
        </div> 
      </div>
    </div>
    <div class="col-lg-6 col-sm-12">
      <div class="p-5">
      <div class="card">
        <div class="card-header">
          Pedidos
        </div>
        <ul id='pedido' class="list-group list-group-flush">
        <?php if(isset($pedidos) && $pedidos): ?>
            <?php foreach($pedidos as $p): ?>
            <li class="list-group-item">
                <p>Numero do pedido: <b> <?=$p->getId();?></b></p>
                <p>Nome: <b> <?=$p->getProduto()->getNome();?> </b>, Categoria: <b>  <?=$p->getProduto()->getCategoria()->getNome();?> </b>,  
               Preco: <b> <?=$p->getProduto()->getPreco();?> </b> Quantidade: <b>  <?=$p->getQuantidade();?> </b> Preco: <b> <?=$p->getId();?> </b>, 
               <?php if($p->getStatus() == "Em Aberto"): ?>
                    Status: <a href="#" title="Clique aqui para alterar o status do pedido" 
                    data-toggle="modal" onclick="editarCompra(this)" data-status="<?=$p->getStatus();?>" data-target="#statusModal"
                    data-quantidade="<?=$p->getQuantidade();?>"
                    data-compra_id="<?=$p->getId();?>"
                    data-produto_id="<?=$p->getProduto()->getId();?>" > <b><?=$p->getStatus();?></b></a>
                <?php endif; ?>
                Pedido feito em: <b><?=$p->getCriado_em();?></b>, 
                 Status: <b><?=$p->getStatus();?></b></p>
               </li>
            <?php endforeach; ?>
            <?php else: ?>
          <li class="list-group-item"> 
            <p>Não existe pedidos no momento</p>
          </li>
        <?php endif; ?>
        </ul>
      </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>
<!-- /.container-fluid -->

<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="titulo"> </h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

        <form id="formCompra" action="compra/alterar">
                <input type='hidden' id='compra_id' name='id' value=''>
                <input type='hidden' id='produto_id' name='produto_id' value=''>
                <input type='hidden' id='quantidade' name='quantidade' value=''>
                Status Atual do pedido: <span id='status'></span>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                  <select class='form-control form-control-user' name='status'>
                    <option value='1'>Pago</option>
                    <option value='0'>Cancelado</option>
                  </select>
                 </div>
                </div>
                <a id='botaoCompra' href="#" class="btn btn-success btn-block">
                  Alterar Status
                </a>
           </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript" charset="utf-8" src='public/js/compraAjax.js'></script>
    
<?php 
    include_once('layout/footer.php');
?>