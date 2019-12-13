<?php
  
  include('layout/header.php');

?>
        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <h1 class="h3 mb-4 text-gray-800">Realizar Compras</h1>

          <form id='formProduto'>
            <input type='hidden' name='action' value='listarTodos'/>
          </form>

          <div id='background' class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body p-0">
            <!-- Nested Row within Card Body -->
            <div class="row">
              <div class="col-lg-12">
              <div class="p-3">
                  Filtrar por:
                </div>
                <div class="p-1">
                <form onclick='filtrar()' id='formLojaFiltrar' class="form-inline">
                  <div class="form-group mx-sm-3 mb-2">
                    <input type="hidden" name='action' value="filtrar">
                    <input type='hidden' id='pagina_atual' name='pagina' value='1'/>
                    <select id="categoria" name='categoria_id' class="form-control form-control-user">
                    </select>
                  </div>
                  <div class="form-group mx-sm-3 mb-2">
                    <select id="valor" name='valor' class="form-control form-control-user">
                      <option value='1'>Mais barato</option>
                      <option value='2'>Mais caro</option>
                    </select>
                  </div>
                  <div class="form-group mx-sm-3 mb-2">
                    <select id="data" name='data' class="form-control form-control-user">
                    <option value='1'>Mais antigo</option>
                    <option value='2'>Mais recente</option>
                    </select>
                  </div>
                  <div class="form-group mx-sm-3 mb-2">
                    <select id="item_pagina" name='item_pagina' class="form-control form-control-user">
                     <option value='5'>Itens por página 5</option>
                     <option value='20'>Itens por página 20</option>
                     <option value='30'>Itens por página 30</option>
                    </select>
                  </div>
                </form>
                </div>
              </div>
            </div>
           
            <div class='row'>
                <div class='col-lg-12'>
                <div class="p-3">
                  Produtos
                </div>
                <div class="p-1">
                  <div id="produtos" class="list-group">
                
                  </div>
                </div>
                <div class="p-3">
                  <nav aria-label="...">
                    <ul class="pagination">
                      <li class="page-item disabled">
                        <a class="page-link" href="#" tabindex="-1">Pagina Anterior</a>
                      </li>
                      <li class="page-item">
                      <a class="page-link" href="#">1</a></li>
                      <li class="page-item active">
                        <a class="page-link" href="#">2 <span class="sr-only">(current)</span></a>
                      </li>
                      <li class="page-item">
                      <a class="page-link" href="#">3</a></li>
                      <li id='ultima_pagina' class="page-item">
                        <a class="page-link" href="#">Próxima Página</a>
                      </li>
                    </ul>
                  </nav>
                <div>
                </div>
            </div>
          </div>
        </div>
      </div>
        <!-- /.container-fluid -->

  <div class="modal fade" id="lojaModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="titulo"> </h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

        <form id="formCompra">
                <input type='hidden' name='action' value='criar'>
                <input type='hidden' id='produto_id' name='id' value=''>
                Comprar <span id='produto_nome'></span>
                <div class="form-group row">
                  <div class="col-sm-6 mb-3 mb-sm-0">
                   
                    <input type="text" id='quantidade' name='quantidade' class="form-control form-control-user" placeholder="Escreva a quantidade">
                  </div>
                </div>
                <a id='botaoCompraProduto' href="#" class="btn btn-success btn-block">
                  Comprar
                </a>
           </form>
        </div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
        </div>
      </div>
    </div>
  </div>

    <script src="../js/lojaAjax.js"></script>
    <script src="../js/compraAjax.js"></script>
    <script src="../js/categoriaAjax.js"></script>
    <script>
        function carregarProdutos(){

          Produto();
        
        }
    </script>
    
<?php 
    include_once('layout/footer.php');
?>