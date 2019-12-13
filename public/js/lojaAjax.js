$(document).ready( function(){
     filtrar();
});


function filtrar(){
    $.ajax({
        url : "loja/listar",
        type : 'post',
        data :$('#formLojaFiltrar').serialize()
        ,beforeSend : function(){

             $("#produtos").html("ENVIANDO...");

        }
        }).done(function(loja){

         let html = '';
         let num_itens = 0;
         let pagina_atual = 0;

         loja = JSON.parse(loja);


         if(loja.dado.loja != null){

          $.each(loja.dado.loja, function( key, dado ) {
               html += "<a href='#' data-toggle='modal' onclick='comprar(this)'  data-target='#lojaModal' title='Comprar "+dado.produto_nome+"'";
               html += "data-produto_nome='"+dado.produto_nome+"' data-produto_id='"+dado.produto_id+"'";
               html += "class='list-group-item list-group-item-action flex-column align-items-start'>";
               html += "<div class='d-flex w-100 justify-content-between'>";
               html += "<h5 class='mb-1'>"+dado.produto_nome+"</h5>";
               html += "<small class='text-muted'>"+dado.criado_em+"</small>";
               html += "</div>";
               html += "<p class='mb-1'>Categoria: "+dado.categoria_nome+"</p>";
               html += "<p class='mb-1'>Preço: "+dado.preco+"</p>";
               html += "<small class='text-muted'>Criado por: "+dado.cliente_nome+"</small>";
               html += "</a>";
          });

         }else{
               html += "<span class='list-group-item list-group-item-action flex-column align-items-start'>";
               html += "<div class='d-flex w-100 justify-content-between'>";
               html += "<h5 class='mb-1'>Não existem informações para essa categoria</h5>";
               html += "</div>";
               html += "</span>";
         }

         num_pagina_total = loja.dado.totalPagina;

          let paginas = pagination(pagina_atual, num_pagina_total);

          $('#produtos').html(html);

          html ='';
          html +='<li class="page-item disabled">';
          html +='<a class="page-link" href="#" onclick="abrir_pagina(1)" tabindex="-1">Pagina Anterior</a>';
          html +='</li>';
          $.each( paginas, function( i, val ) {
               if(pagina_atual == val){
                    html +='<a class="page-link active" onclick="abrir_pagina('+val+')" href="#">'+val+'</a>';
               }else{
                    html +='<a class="page-link" onclick="abrir_pagina('+val+')" href="#">'+val+'</a>';
               }
              
          });
          html +='<li id="ultima_pagina" class="page-item">';
          html +='<a class="page-link" onclick="abrir_pagina('+num_pagina_total+')" href="#">Próxima Página</a>';
          html +='</li>';

          $('.pagination').html(html);

        }).fail(function(jqXHR, textStatus, msg){

             alert(msg);

        });
}

function comprar(a){

     var produto_id = a.getAttribute('data-produto_id');
     var produto_nome = a.getAttribute('data-produto_nome');

     $('#produto_nome').html(produto_nome);
     $('#produto_id').val(produto_id);
}

function pagination(currentPage, pageCount) {
     let delta = 2,
         left = currentPage - delta,
         right = currentPage + delta + 1,
         result = [];

     result = Array.from({length: pageCount}, (v, k) => k + 1)
         .filter(i => i && i >= left && i < right);

     return result;
}

function abrir_pagina(num){
     $('#pagina_atual').val(num);
     filtrar();
}

$('#item_pagina').click(function(){
     $('#pagina_atual').val(1);
});