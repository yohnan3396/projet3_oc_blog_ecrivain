$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})





function loadCommentaire(type)
{




 $.ajax({
  type: 'POST',
  url: 'http://blog-ecrivain.yohann-kipfer.com/index.php',
  data: {idKit: idKit, type: type},
  dataType: 'html', // JSON
     
beforeSend: function() {

if(type != "objet")
{
$(".post-comments").html('<center><img src="https://leskits.com/assets/img/loader.svg" id="loaderAjoutCommentaire"></center>');
}
else
{
$("#commentairesObjets.post-comments").html('<center><img src="https://leskits.com/assets/img/loader.svg" id="loaderAjoutCommentaire"></center>');
}


           
     },  
 success: function(html) {

if(type != "objet")
{
$(".post-comments").html(html);
}
else
{
$("#commentairesObjets.post-comments").html(html);  
}

 
                                               
  }
                
                  

                });



}


function submitCommentaireKitObjet()
{

var form=$("#form-ajoutCommentaireObjet");



$("#successAjoutCommentaireObjet").hide();
$("#errorAjoutCommentaireObjet").hide();


 $.ajax({
  type: form.attr('method'),
  url: form.attr('action'),
  data: form.serialize(),
  dataType: 'json', // JSON
     
beforeSend: function() {

$("#loaderAjoutCommentaireObjet").show();
           
     },  
 success: function(json) {

 $("#loaderAjoutCommentaireObjet").hide();

if(json.errorAjoutCommentaire === 'yes') {
// Redirection vers le kit
$("#successAjoutCommentaireObjet").show();
$(form).closest('form').find("input[type=text], textarea").val("");

loadCommentaireKit(json.type);




} 
else
{
$("#errorAjoutCommentaireObjet").show();
$("#errorAjoutCommentaireObjet").html(json.errorAjoutCommentaire);

}
                                               
  }
                
                  

                });

  
}



function submitCommentaireKit()
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
$(form).closest('form').find("input[type=text], textarea").val("");

loadCommentaireKit(json.type);




} 
else
{
$("#errorAjoutCommentaire").show();
$("#errorAjoutCommentaire").html(json.errorAjoutCommentaire);

}
                                               
  }
                
                  

                });

  
}


function ouvrirModalUpload(type)
{
$("#formulaireUpload").val(type);
$("#uploadImage").modal('show');

}

 function submitUploadImage()
 {
var formulaireUpload = $("#formulaireUpload").val();

var url = $('iframe[name=frameUpload]').contents().find('#urlImageUpload').html();
if(url == "")
{
alert("Aucune image uploadé");
}
 else
 {

if(formulaireUpload == 'objet')
{
$("#urlImageObjet").val(url);
$("#previewImageObjet").attr('src', url);
}

if(formulaireUpload == 'modifierKit')
{
$("#urlImageKit").val(url);
$("#previewImageKit").attr('src', url);
}

if(formulaireUpload == 'profil')
{
$("#urlImageProfil").val(url);
$("#previewImageProfil").attr('src', url);
}


if(formulaireUpload == 'modifierObjet')
{
$("#urlImageObjet").val(url);
$("#previewImageObet").attr('src', url);
}






$("#uploadImage").modal('hide'); 


}


 }
   

function submitDeconnexion()
{


 $.ajax({
  type: 'POST',
  url: 'https://leskits.com/ajaxRequest/requeteMeDeconnecter.php',
  dataType: 'json', // JSON
     
beforeSend: function() {


           
     },  
 success: function(json) {

if(json.msg === 'ok')
{
window.location.href = "https://leskits.com";
}
else
{
  
}                                          
  }
                
                  

                });




}



function supprimerLeKit(id)
{


 $.ajax({
  type: 'POST',
  url: 'https://leskits.com/ajaxRequest/requeteSupprimerKit.php',
  data: {'id_kit':id},
  dataType: 'json', // JSON
     
beforeSend: function() {


           
     },  
 success: function(json) {

if(json.msg === 'ok')
{
alert('Le Kit a bien été supprimé.');
window.location.href = "https://leskits.com";
}
else
{
  
}                                          
  }
                
                  

                });




}

function changeLink()
{
var link = $("#lienObjet").val();
link = encodeURIComponent(link);



 $.ajax({
  type: 'GET',
  url: 'https://opengraph.io/api/1.1/site/' + link + '?app_id=5a6c96c23e22ba981a3954b3',
  dataType: 'json', // JSON
     
beforeSend: function() {

$("#loaderAjoutObjet").show();
           
     },  
 success: function(data) {

 $("#loaderAjoutObjet").hide();

$("#titreObjet").val(data.hybridGraph.title);
$("#descriptionObjet").val(data.hybridGraph.description);
$("#urlImageObjet").val(data.hybridGraph.image);
$("#previewImageObjet").attr('src', data.hybridGraph.image);

                                               
  }
                
                  

                });






}
function changeImage()
{
var image = $("#urlImageObjet").val();

$("#previewImageObjet").attr('src', image);

}

function responseCommentaire(id)
{
$("#idCommentaire").val(id);
}

function signalerCommentaire(type, id)
{
$("#typeCommentaire").val(type);
$("#idCommentaireSignalement").val(id);

$("#commentaireVerifiee").show();
$("#successSignalement").hide();
}

function supprimerCommentaire(type, id, type2)
{
$("#typeCommentaireSupprimer").val(type);
$("#idCommentaireSupprimer").val(id);
$("#supprimerCommentaireInput").val(type2);
$("#commentaireSuprime").show();
$("#successCommentaire").hide();
}





function submitSupprimerCommentaire(type)
{
var typeCommentaireSupprimer = $("#typeCommentaireSupprimer").val();
var idCommentaireSupprimer = $("#idCommentaireSupprimer").val();
var type2 = $("#supprimerCommentaireInput").val();


 $.ajax({
  type: 'POST',
  url: 'https://leskits.com/ajaxRequest/supprimerCommentaire.php',
  data: {typeCommentaireSupprimer: typeCommentaireSupprimer, idCommentaireSupprimer: idCommentaireSupprimer},
  dataType: 'json', // JSON
     
beforeSend: function() {

$("#loaderSupprimerCommentaire").show();
           
     },  
 success: function(json) {

$("#loaderSupprimerCommentaire").hide();
$("#commentaireSuprime").hide();
$("#successCommentaire").show();
$('#supprimerCommentaire').modal('hide');
loadCommentaireKit(type2);
                                               
  }
                
                  

                });


}


function submitSignalement()
{
var typeCommentaire = $("#typeCommentaire").val();
var idCommentaireSignalement = $("#idCommentaireSignalement").val();



 $.ajax({
  type: 'POST',
  url: 'https://leskits.com/ajaxRequest/signalerCommentaire.php',
  data: {typeCommentaire: typeCommentaire, idCommentaireSignalement: idCommentaireSignalement},
  dataType: 'json', // JSON
     
beforeSend: function() {

$("#loaderSignalement").show();
           
     },  
 success: function(json) {

 $("#loaderSignalement").hide();
$("#commentaireVerifiee").hide();
$("#successSignalement").show();

                                               
  }
                
                  

                });


}



function submitReponseCommentaireKit()
{

var form=$("#form-ajoutReponseCommentaire");



$("#successReponseCommentaire").hide();
$("#errorReponseCommentaire").hide();


 $.ajax({
  type: form.attr('method'),
  url: form.attr('action'),
  data: form.serialize(),
  dataType: 'json', // JSON
     
beforeSend: function() {

$("#loaderReponseCommentaire").show();
           
     },  
 success: function(json) {

 $("#loaderReponseCommentaire").hide();

if(json.errorReponseCommentaire === 'yes') {
// Redirection vers le kit
$("#successReponseCommentaire").show();
$(form).closest('form').find("input[type=text], textarea").val("");
$('#reponseCommentaire').modal('hide');
loadCommentaireKit(json.type);




} 
else
{
$("#errorReponseCommentaire").show();
$("#errorReponseCommentaire").html(json.errorReponseCommentaire);

}
                                               
  }
                
                  

                });

  
}



function changeImageProfil()
{
var image = $("#urlImageProfil").val();

$("#previewImageProfil").attr('src', image);

}
function changeImageModifierObjet()
{
  var image = $("#urlImageObjet").val();

$("#previewImageObjet").attr('src', image);

}

function changeImageKit()
{
var image = $("#urlImageKit").val();

$("#previewImageKit").attr('src', image);

}

function modifierObjetShow()
{

if ($("#modifierLobjet").css('display') == 'none' ){
$("#modifierLobjet").show();
}
else
{
$("#modifierLobjet").hide();  
}  

}

function supprimerObjetBefore(id)
{
$("#supprimerObjetInput").val(id);
}

function supprimerObjet()
{
var idObjet = $("#supprimerObjetInput").val();


 $.ajax({
  type: 'POST',
  url: 'https://leskits.com/ajaxRequest/requeteSupprimerObjet.php',
  data: {'id_objet':idObjet},
  dataType: 'json', // JSON
     
beforeSend: function() {


           
     },  
 success: function(json) {
$("#objet" + idObjet).hide();
$("#affichageObjet").modal('hide');
changeUrlObjet();
                                        
  }
                
                  

                });

}


function likeKit(id)
{


 $.ajax({
  type: 'POST',
  url: 'https://leskits.com/ajaxRequest/likeKit.php',
  data: {id_kit:id},
  dataType: 'json', // JSON
     
beforeSend: function() {


           
     },  
 success: function(json) {

$("[name=lienLikeKit]").html(json.msg);
$("[name=nbLikeKit]").html(json.nbLike);


                                        
  }
                
                  

                });


  
}

function likeCommentaire(type, id)
{


 $.ajax({
  type: 'POST',
  url: 'https://leskits.com/ajaxRequest/likeCommentaire.php',
  data: {id_commentaire:id, type_commentaire: type},
  dataType: 'json', // JSON
     
beforeSend: function() {


           
     },  
 success: function(json) {

$("#" + type + id).find("[name=nbLike]").html(json.nbLike);
$("#" + type + id).find("[name=lienLike]").html(json.msg);


                                        
  }
                
                  

                });


  
}





function submitFormModifierPass()
{

var form=$("#form-modifierPass");

$("#successModifierPass").hide();
$("#errorModifierPass").hide();


 $.ajax({
  type: form.attr('method'),
  url: form.attr('action'),
  data: form.serialize(),
  dataType: 'json', // JSON
     
beforeSend: function() {

$("#loaderModifierPass").show();
           
     },  
 success: function(json) {

 $("#loaderModifierPass").hide();

if(json.errorModifierPass === 'yes') {
// Redirection vers le kit

$("#successModifierPass").show();
$("html, body").animate({ scrollTop: 0 }, "slow");

} 
else
{
$("#errorModifierPass").show();
$("#errorModifierPass").html(json.errorModifierPass);
$("html, body").animate({ scrollTop: 0 }, "slow");
}
                                               
  }
                
                  

                });

  
}

function submitFormProfil()
{

var form=$("#form-modifierProfil");

$("#successModifierProfil").hide();
$("#errorModifierProfil").hide();


 $.ajax({
  type: form.attr('method'),
  url: form.attr('action'),
  data: form.serialize(),
  dataType: 'json', // JSON
     
beforeSend: function() {

$("#loaderModifierProfil").show();
           
     },  
 success: function(json) {

 $("#loaderModifierProfil").hide();

if(json.errorModifierProfil === 'yes') {
// Redirection vers le kit

$("#successModifierProfil").show();
$("html, body").animate({ scrollTop: 0 }, "slow");

} 
else
{
$("#errorModifierProfil").show();
$("#errorModifierProfil").html(json.errorModifierProfil);
$("html, body").animate({ scrollTop: 0 }, "slow");
}
                                               
  }
                
                  

                });

  
}




function submitFormAjoutObjet()
{

var form=$("#form-ajoutObjet");

$("#successAjoutObjet").hide();
$("#errorAjoutObjet").hide();


 $.ajax({
  type: form.attr('method'),
  url: form.attr('action'),
  data: form.serialize(),
  dataType: 'json', // JSON
     
beforeSend: function() {

$("#loaderAjoutObjet").show();
           
     },  
 success: function(json) {

 $("#loaderAjoutObjet").hide();

if(json.errorAjoutObjet === 'yes') {
// Redirection vers le kit
loadObjetsKits();
$("#successAjoutObjet").show();

var titreObjet = $("#titreObjet").val();
var descriptionObjet = $("#descriptionObjet").val();
var urlImage = $("#urlImageObjet").val();
var lienObjet = $("#lienObjet").val();


$(form).closest('form').find("input[type=text], textarea").val("");
$("#previewImageObjet").attr('src', 'https://leskits.com/assets/img/pas_image.jpg');
$('#ajouterUnObjet').animate({ scrollTop: 0 }, 'slow');
} 
else
{
$("#errorAjoutObjet").show();
$("#errorAjoutObjet").html(json.errorAjoutObjet);
$('#ajouterUnObjet').animate({ scrollTop: 0 }, 'slow');
}
                                               
  }
                
                  

                });

  
}





function submitFormModifierObjet()
{

var form=$("#form-modifierObjet");

$("#successModifierObjet").hide();
$("#errorModifierObjet").hide();


 $.ajax({
  type: form.attr('method'),
  url: form.attr('action'),
  data: form.serialize(),
  dataType: 'json', // JSON
     
beforeSend: function() {

$("#loaderModifierObjet").show();
           
     },  
 success: function(json) {

 $("#loaderModifierObjet").hide();

if(json.errorModifierObjet === 'yes') {
// Redirection vers le kit

$("#successModifierObjet").show();

loadObjetsKits();
$('#modifierLobjet').animate({ scrollTop: 0 }, 'slow');

} 
else
{
$("#errorModifierObjet").show();
$("#errorModifierObjet").html(json.errorModifierObjet);
$('#modifierLobjet').animate({ scrollTop: 0 }, 'slow');
}
                                               
  }
                
                  

                });





}



function submitFormModifierKit()
{

var form=$("#form-modifierKit");

$("#successModifierKit").hide();
$("#errorModifierKit").hide();


 $.ajax({
  type: form.attr('method'),
  url: form.attr('action'),
  data: form.serialize(),
  dataType: 'json', // JSON
     
beforeSend: function() {

$("#loaderModifierKit").show();
           
     },  
 success: function(json) {

 $("#loaderModifierKit").hide();

if(json.errorModifierKit === 'yes') {
// Redirection vers le kit

$("#successModifierKit").show();
  window.setTimeout(function(){
location.reload();
    }, 2000);

$('#modifierLeKit').animate({ scrollTop: 0 }, 'slow');

} 
else
{
$("#errorModifierKit").show();
$("#errorModifierKit").html(json.errorModifierKit);
$('#modifierLeKit').animate({ scrollTop: 0 }, 'slow');
}
                                               
  }
                
                  

                });





}



Stripe.setPublishableKey('pk_live_g7dbzzYf4BL7LerFicdlkNaT')
      

function submitFormStripe()
{
var $form = $('#form-paymentStripe');
$("#buttonPay").attr('disabled', true);
$("#errorPayment").hide();
$("#errorPayment").html('');

       Stripe.card.createToken($form, function (status, response) {
                if (response.error) {
            
                    $("#errorPayment").show();
                 

var errorMessages = {
  incorrect_number: "Le numéro de carte est incorrect.",
  invalid_number: "Le numéro de carte est incorrect.",
  invalid_expiry_month: "Le mois d'expiration de la carte est invalide.",
  invalid_expiry_year: "L'année d'expiration de la carte est invalide.",
  invalid_cvc: "Le code de sécurité à 3 chiffres est invalide.",
  expired_card: "La carte a expiré.",
  incorrect_cvc: "Le code de sécurité à 3 chiffres est incorrect.",
  incorrect_zip: "Le zip code de la carte est faux.",
  card_declined: "La carte a été décliné.",
  missing: "Il n'y a pas de carte sur un client qui est en cours de facturation.",
  processing_error: "Une erreur s'est produite lors du traitement de la carte.",
  rate_limit:  "Frapper l'API trop rapidement. S'il vous plaît laissez-nous savoir si vous rencontrez toujours cette erreur."
};

  if ( response.error && response.error.type == 'card_error' ){
    $( '#errorPayment' ).html( errorMessages[ response.error.code ] );
  }




                    $("#buttonPay").attr('disabled', false)
                } else {
                    var token = response.id
                    $("#stripeToken").val(token);

                   
 $.ajax({
  type: $form.attr('method'),
  url: $form.attr('action'),
  data: $form.serialize(),
  dataType: 'json', // JSON
     
beforeSend: function() {

$("#loaderPayment").show();
           
     },  
 success: function(json) {

$("#loaderPayment").hide();


if(json.payment === 'yes') {
$("#successPayment").show();
$($form).hide();


  window.setTimeout(function(){

    location.reload();

    }, 4000);


} 
else
{
$("#errorPayment").show();
$("#errorPayment").html(json.payment);

}
                                               
  }
                
                  

                });
                  

                  



                }
            })


}

 
           
        
     
