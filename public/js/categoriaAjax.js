$(document).ready(function(){
     carregarCategoria();
});

function cuCategoria(){
     $.ajax({
          url : "../php/includes/ajax/Categoria.php",
          type : 'post',
          data :  $('#formCategoria').serialize(),
  
          beforeSend : function(){
  
               $("#resultado").html("ENVIANDO...");
  
          }
          }).done(function(msg){
  
              alert(msg);
              carregarCategoria();
          }).fail(function(jqXHR, textStatus, msg){
  
               alert(msg);
  
          }); 
}

function drCategoria(action, id){
     $.ajax({
          url : "../php/includes/ajax/Categoria.php",
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

              carregarCategoria();
  
          }).fail(function(jqXHR, textStatus, msg){
  
               alert(msg);
  
          }); 
}

function carregarCategoria(){
     $.ajax({
          url : "../php/includes/ajax/Categoria.php",
          type : 'post',
          data :  {
               'action':'listarTodos'
          } 
          ,beforeSend : function(){
  
          }
          }).done(function(categoria){

               var  html = '';
                    html +='<option value="0">Selecione uma categoria</option>';   
               $.each(JSON.parse(categoria), function( key, dado ) {
                    html +='<option value="'+dado.categoria_id+'">'+dado.nome+'</option>';     
               }); 

               $('#categoria').html(html);
              
          }).fail(function(jqXHR, textStatus, msg){
  
               alert(msg);
  
          }); 
     }
   
   
   function editarCategoria(a){
     var nome = a.getAttribute('data-nome');
     var id = a.getAttribute('data-id');
 
     console.log(id);
 
     $('#titulo').text('Alterar informações - '+nome);
     $('#botaoCategoria').text('Alterar Informações do categoria');
 
     $('#nome').val(nome);
     $('#email').val(email);
     $('#id').val(id);
     $('#action').val('alterar');
     $('#categoriaNovo').fadeIn();
   }
 
   function adicionarCategoriaEdit(){
     $('#titulo').text('Adicionar novo categoria');
     $('#botaoCategoria').text('Adicionar categoria');
 
     $('#nome').val('');
     $('#email').val('');
     $('#id').val('');
     $('#senha').val('');
     $('#action').val('criar');
     $('#categoriaNovo').fadeOut();
   }
 
   function excluirCategoria(a){
     var id = a.getAttribute('data-id');
 
     var excluir = confirm('Excluir Categoria?');
 
     if(excluir){
       drCategoria('apagar', id)
     }
   }
 
   $('#botaoCategoria').click(function(){

     if($('#senha').val() == $('#senha2').val()){
          cuCategoria();
          adicionarCategoriaEdit();
     }else{
          alert('Senha não são iguais');
     }
    
   });
