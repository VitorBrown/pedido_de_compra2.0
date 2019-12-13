function cuCompra(){

     $.ajax({
          url : $('#formCompra').attr('action'),
          type : 'post',
          data :  $('#formCompra').serialize(),
  
          beforeSend : function(){
  
               $("#resultado").html("ENVIANDO...");
  
          }
          }).done(function(msg){
  
              alert(msg);
              location.reload();

          }).fail(function(jqXHR, textStatus, msg){
  
               alert("Houve algum erro na sua compra");
  
          }); 
}

function drCompra(action, id){
     $.ajax({
          url : "compra/excluir",
          type : 'post',
          data :  {
               'action':action,
               'id':id
          }     
          ,
  
          beforeSend : function(){
  
               $("#resultado").html("ENVIANDO...");
  
          }
          }).done(function(msg){
  
              alert(msg);

              carregarCompra();
  
          }).fail(function(jqXHR, textStatus, msg){
  
               alert(msg);
  
          }); 
}

   
   function editarCompra(a){

     var compra_id = a.getAttribute('data-compra_id');
     var produto_id = a.getAttribute('data-produto_id');
     var status = a.getAttribute('data-status');
     var quantidade = a.getAttribute('data-quantidade');

     $('#compra_id').val(compra_id);
     $('#produto_id').val(produto_id);
     $('#status').text(status);
     $('#quantidade').val(quantidade);

   }
 
   function adicionarCompraEdit(){
     $('#compra_id').val('');
     $('#produto_id').val('');
     $('#status').text('');
     $('#quantidade').val('');

   }
 
   function excluirCompra(a){
     var id = a.getAttribute('data-id');
     
     var excluir = confirm('Excluir Compra?');
 
     if(excluir){
       drCompra('apagar', id)
     }
   }
 
   $('#botaoCompra').click(function(event){
     event.preventDefault();
     cuCompra();
     adicionarCompraEdit();

   });

   $('#botaoCompraProduto').click(function(event){
     event.preventDefault();
     cuCompra();
});