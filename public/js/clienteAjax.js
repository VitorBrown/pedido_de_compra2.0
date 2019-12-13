function cuCliente(){
  let url = $('#formCliente').attr('action');
  $.ajax({
       url : url,
       type : 'post',
       data :  $('#formCliente').serialize(),

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

function drCliente(action, id){
  $.ajax({
       url : "cliente/excluir",
       type : 'post',
       data :  {
            'id':id
       },
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

   function editarCliente(a){
     var nome = a.getAttribute('data-nome');
     var email = a.getAttribute('data-email');
     var id = a.getAttribute('data-id');
     var cpf = a.getAttribute('data-cpf');
     var tipo = a.getAttribute('data-tipo');

     $('#titulo').text('Alterar informações - '+nome);
     $('#botaoCliente').text('Alterar Informações do cliente');
 
     $('#nome').val(nome);
     $('#email').val(email);
     $('#cpf').val(cpf);
     $('#tipo').val(tipo);
     $('#id').val(id);
     $('#formCliente').attr('action','cliente/alterar');
   }
 
   function adicionarClienteEdit(){
     $('#titulo').text('Adicionar novo cliente');
     $('#botaoCliente').text('Adicionar cliente');
 
     $('#nome').val('');
     $('#email').val('');
     $('#id').val('');
     $('#senha').val('');
     $('#cpf').val('');
     $('#tipo').val('');
     $('#formCliente').attr('action','cliente/criar');
   }
 
   function excluirCliente(a){
     let id = a.getAttribute('data-id');
 
     let excluir = confirm('Excluir Cliente?');
 
     if(excluir){
       drCliente('apagar', id)
     }
   }
 
   $('#botaoCliente').click(function(event){
    event.preventDefault();
     if($('#senha').val() == $('#senha2').val()){
          cuCliente();
          adicionarClienteEdit();
     }else{
          alert('Senha não são iguais');
     }
    
   });
