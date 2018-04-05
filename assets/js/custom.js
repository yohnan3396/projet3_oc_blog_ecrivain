$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})



function ajouterCommentaire()
{

var form=$("#form-ajoutCommentaire");



$("#successAjoutCommentaire").hide();
$("#errorAjoutCommentaire").hide();


 $.ajax({
  type: form.attr('method'),
  url: form.attr('action'),
  data: form.serialize(),
  dataType: 'json', // JSON
     
beforeSend: function() {

$("#loaderAjoutCommentaire").show();
           
     },  
 success: function(json) {

 $("#loaderAjoutCommentaire").hide();

if(json.errorAjoutCommentaire === 'yes') {
// Redirection vers le kit
$("#successAjoutCommentaire").show();

location.reload();




} 
else
{
$("#errorAjoutCommentaire").show();
$("#errorAjoutCommentaire").html(json.errorAjoutCommentaire);

}
                                               
  }
                
                  

                });

  
}




function signalerCommentaire(id)
{
$("#idCommentaireSignalement").val(id);

$("#commentaireVerifiee").show();
$("#successSignalement").hide();
$("#submitSignalement").show();
}




function submitSignalement()
{

var idCommentaireSignalement = $("#idCommentaireSignalement").val();



 $.ajax({
  type: 'POST',
  url: '/signalerCommentaire',
  data: {idCommentaireSignalement: idCommentaireSignalement},
  dataType: 'json', // JSON
     
beforeSend: function() {

$("#loaderSignalement").show();
           
     },  
 success: function(json) {

$("#loaderSignalement").hide();
$("#commentaireVerifiee").hide();
$("#successSignalement").show();
$("#submitSignalement").hide();

                                               
  }
                
                  

                });


}



function deleteArticle(id)
{



 $.ajax({
  type: 'POST',
  url: '/deleteArticle',
  data: {'id':id},
  dataType: 'json', // JSON
     
beforeSend: function() {


  },  
 success: function(json) {

$("#trArticle" + id).hide();
                                        
  }
                
                  

                });

}


function deleteCommentaire(id, id_signalement)
{



 $.ajax({
  type: 'POST',
  url: '/deleteCommentaire',
  data: {'id':id, 'id_signalement':id_signalement},
  dataType: 'json', // JSON
     
beforeSend: function() {


  },  
 success: function(json) {

$("#trCommentaire" + id).hide();
                                        
  }
                
                  

                });

}



function annulerSignalement(id)
{



 $.ajax({
  type: 'POST',
  url: '/annulerSignalement',
  data: {'id_signalement':id},
  dataType: 'json', // JSON
     
beforeSend: function() {


  },  
 success: function(json) {

$("#trCommentaire" + id).hide();
                                        
  }
                
                  

                });

}



function submitFormAddArticle()
{

var form=$("#form-article");



 $.ajax({
  type: form.attr('method'),
  url: form.attr('action'),
  data: form.serialize(),
  dataType: 'json', // JSON
     
beforeSend: function() {


           
     },  
 success: function(json) {

if(json.msg === 'yes') {

location.href='/blog-admin';

} 
else
{
alert(json.msg);
}
                                               
  }
                
                  

                });

  
}

