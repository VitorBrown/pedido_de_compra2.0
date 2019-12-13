function cuProduto(){
     let url = $('#formProduto').attr('action');
     $.ajax({
          url : url,
          type : 'post',
          data :  $('#formProduto').serialize(),
  
          beforeSend : function(){
  
               $("#resultado").html("ENVIANDO...");
  
          }
          }).done(function(msg){
  
              alert(msg);
              location.reload();
           
          }).fail(function(jqXHR, textStatus, msg){
  
               alert(msg);
  
          }); 
}

function drProduto(action, id){

     $.ajax({
          url : "produto/excluir",
          type : 'post',
          data :  {
               'id':id
          }     
          ,
  
          beforeSend : function(){
  
               $("#resultado").html("ENVIANDO...");
  
          }
          }).done(function(msg){
  
              alert(msg);
              location.reload();
  
          }).fail(function(jqXHR, textStatus, msg){
  
               alert(msg);
  
          }); 
}

   function editarProduto(a){
     var nome = a.getAttribute('data-nome');
     var categoria_id = a.getAttribute('data-categoria_id');
     var preco = a.getAttribute('data-preco');
     var id = a.getAttribute('data-id');
 
     $('#titulo').text('Alterar informações - '+nome);
     $('#botaoProduto').text('Alterar Informações do produto');
 
     $('#nome').val(nome);
     $('#categoria_id').val(categoria_id);
     $('#id').val(id);
     $('#preco').val(preco);
     $('#formProduto').attr('action', 'produto/alterar');
   }
 
   function adicionarProdutoEdit(){
     $('#titulo').text('Adicionar novo produto');
     $('#botaoProduto').text('Adicionar produto');
 
     $('#nome').val('');
     $('#categoria_id').val('');
     $('#id').val('');
     $('#preco').val('');
     $('#formProduto').attr('action', 'produto/criar');
   }
 
   function excluirProduto(a){
     var id = a.getAttribute('data-id');
     
     var excluir = confirm('Excluir Produto?');
 
     if(excluir){
       drProduto('apagar', id)
     }
   }
 
   $('#botaoProduto').click(function(event){
     event.preventDefault();
          cuProduto();
          adicionarProdutoEdit();

   });
