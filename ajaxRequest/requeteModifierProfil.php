<?php
include_once('connexionBDD.php'); // Connexion à la base de données
require('../language/traduction.php'); 
global $db;




$id = "none";




if(isset($_SESSION['id']))
{

$membreCo = $db->prepare("SELECT * FROM user_temp WHERE email = ? ");
$membreCo->execute(array($_SESSION['id']));
while ($donneesMembreCo = $membreCo->fetch())
{
$idMembreCo = $donneesMembreCo['id'];
$infoPremium = $donneesMembreCo['premium'];
}



if(isset($_POST['biographie']) AND isset($_POST['facebook_url']) AND isset($_POST['instagram_url']) AND isset($_POST['pseudo']) AND isset($_POST['twitter_url']) AND isset($_POST['urlImageProfil']) AND isset($_POST['website_url']) AND isset($_POST['youtube_url']))
{

if(!empty($_POST['pseudo']))
{

if(is_array(getimagesize($_POST['urlImageProfil'])))
{

if(preg_match('/^[a-zA-Z0-9 ]+$/',$_POST['pseudo']))
{

if(strlen($_POST['pseudo']) > 3 AND strlen($_POST['pseudo']) < 15)
{

$presencePseudo = $db->query("SELECT COUNT(*) FROM user_temp WHERE login='$_POST[pseudo]' AND id!='$idMembreCo' ")->fetchColumn();

if($presencePseudo == 0)
{
      

  
$temps = time();

$req = $db->prepare("UPDATE user_temp SET login = :login, biographie = :biographie, picture = :picture, facebook = :facebook, youtube = :youtube, twitter = :twitter, instagram = :instagram, website = :website WHERE id='$idMembreCo' ");
$req->execute(array(
  'login' => htmlspecialchars($_POST['pseudo']),
  'biographie' => htmlspecialchars($_POST['biographie']),
  'picture' => htmlspecialchars($_POST['urlImageProfil']),
  'facebook' =>  htmlspecialchars($_POST['facebook_url']),
  'youtube' =>  htmlspecialchars($_POST['youtube_url']),
  'twitter' => htmlspecialchars($_POST['twitter_url']),
  'instagram' => htmlspecialchars($_POST['instagram_url']),
  'website' => htmlspecialchars($_POST['website_url']),


  ));








$errorModifierProfil = "yes";


$id = $db->lastInsertId();



}
else
{
$errorModifierProfil = $language[$langueAffichage]['Pseudo_deja_utilise'];          
}

}
else
{
$errorModifierProfil = $language[$langueAffichage]['Le_pseudo_doit_contenir_entre_4et14'];       
}

}
else
{
$errorModifierProfil = $language[$langueAffichage]['Caracteres_alphanumerique_espace'];           
}

}
else
{
$errorModifierProfil  = $language[$langueAffichage]['Url_vers_image_invalide'];          
}



}
else
{
    $errorModifierProfil  = $language[$langueAffichage]['Au_moins_un_champs_vide'];   
}


}
else
{
    $errorModifierProfil  = $language[$langueAffichage]['Probleme_survenu'];  
}




}
else
{
    $errorModifierProfil  = $language[$langueAffichage]['Vous_devez_etre_connecte'];          
}



echo json_encode(['errorModifierProfil' => $errorModifierProfil, 'id' => $id]);



 
?>
