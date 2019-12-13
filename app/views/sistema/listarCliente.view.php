<?php
  
  include('layout/header.php');
?>
<!-- Begin Page Content -->
<div class="container-fluid">

<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">Clientes</h1>

<div id='background' class="card o-hidden border-0 shadow-lg my-5">
<div class="card-body p-0">
  <div class="row">
    <div class="col-lg-12 col-sm-12">
      <div class="p-5">
      <div class="card">
        <div class="card-header">
          <button id='clienteNovo' type='button' onclick='adicionarClienteEdit()' data-toggle='modal'  data-target='#clienteModal' class='btn btn-primary'>Adicionar Novo Cliente</button>
        </div>
        <ul id='resultado' class="list-group list-group-flush">

        <?php
          foreach($cliente as $c):
        ?>
        <li class='list-group-item'>
          <div class='btn-group' role='group' >
          <button type='button' onclick='editarCliente(this)' data-toggle='modal'  data-target='#clienteModal' data-id='<?=$c->getId()?>' data-nome='<?=$c->getNome()?>'
           data-cpf='<?=$c->getCpf()?>' data-tipo='<?=$c->getTipo()?>' data-email='<?=$c->getUsuario()->getEmail()?>'  class='btn btn-warning'>Editar</button>
          <button type='button' onclick='excluirCliente(this)' data-id='<?=$c->getId()?>' class='btn btn-danger'>Exluir</button>
          </div>
            Nome:<?=$c->getNome()?>, CPF:<?=$c->getCpf()?> 
          </li>

        <?php 
        endforeach;
        ?>
        </ul>
      </div>
      </div>
    </div>
  </div>
</div>
</div>

</div>

<div class="modal fade" id="clienteModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="titulo"> </h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

        <form id="formCliente" method="post" action="cliente/criar">
                <input type="hidden" id="id" name="id" />
                
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" id='nome' name='nome' class="form-control form-control-user" placeholder="Escreva seu nome">
                  </div>
                  <div class="col-sm-6">
                    <input type="text" id='cpf' name='cpf' class="form-control form-control-user" placeholder="Digite o seu cpf">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6">
                    <input type="email" id='email' name='email' class="form-control form-control-user" placeholder="Escreva seu email">
                  </div>
                  <div class="col-sm-6">
                    <select id='tipo' class='form-control form-control-user' name='tipo'>
                      <option value='adm'>Administrador</option>
                      <option value='a'>Normal</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="password" id='senha' name='senha' class="form-control form-control-user" placeholder="Digite a nova senha">
                  </div>
                  <div class="col-sm-6">
                    <input type="password" id='senha2' class="form-control form-control-user" placeholder="Digite novamente a senha">
                  </div>
                </div>
                <input type='submit' value="Criar" id="botaoCliente" class="btn btn-primary btn-block">   
        </form>
        
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

<!-- /.container-fluid -->
<script src='public/js/clienteAjax.js'></script>
    
<?php 
    include_once('layout/footer.php');
?>