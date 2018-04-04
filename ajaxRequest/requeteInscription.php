<?php
session_start();
include_once('connexionBDD.php'); // Connexion à la base de données
require('../language/traduction.php'); 

global $db;

if (!isset($_SESSION['id'])) { 

if(isset($_POST['emailInscription']) AND isset($_POST['mdpInscription']) AND isset($_POST['mdpConfirmInscription']) AND isset($_POST['pseudoInscription']))
{

if(!empty($_POST['emailInscription']) AND !empty($_POST['mdpInscription']) AND !empty($_POST['mdpConfirmInscription']) AND !empty($_POST['pseudoInscription']))
{

if(filter_var($_POST['emailInscription'], FILTER_VALIDATE_EMAIL)){

$presencEmail = $db->query("SELECT COUNT(*) FROM user_temp WHERE email='$_POST[emailInscription]' ")->fetchColumn();

if($presencEmail == 0){

if($_POST['mdpInscription'] == $_POST['mdpConfirmInscription'])
{

if(strlen($_POST['mdpInscription']) > 5)
{

if(preg_match('/^[a-zA-Z0-9 ]+$/',$_POST['pseudoInscription']))
{

if(strlen($_POST['pseudoInscription']) > 3 AND strlen($_POST['pseudoInscription']) < 15)
{

$presencePseudo = $db->query("SELECT COUNT(*) FROM user_temp WHERE login='$_POST[pseudoInscription]' ")->fetchColumn();

if($presencePseudo == 0)
{



$options = [
    'cost' => 12,
];

$passcrypt = password_hash($_POST['mdpInscription'], PASSWORD_BCRYPT, $options)."\n";

$temps = time();
$inserer = $db->prepare("INSERT INTO user_temp(pass, login, email, picture, premium, solde, timestamp_inscription, gain_provi, biographie, instagram, facebook, twitter, youtube, photo_couverture, newsletter, website)
    VALUES(:pass, :login, :email, :picture, :premium, :solde, :timestamp_inscription, :gain_provi, :biographie, :instagram, :facebook, :twitter, :youtube, :photo_couverture, :newsletter, :website)");
$inserer->execute(array(
    "pass" => $passcrypt,
    "login" => htmlspecialchars($_POST['pseudoInscription']),
    "email" => htmlspecialchars($_POST['emailInscription']),
    "picture" => "",
    "premium" => "0",
    "solde" => "0",
    "timestamp_inscription" => $temps,
    "gain_provi" => "0",
    "biographie" => "",
    "instagram" => "",
    "facebook" => "",
    "twitter" => "",
    "youtube" => "",
    "photo_couverture" => "",
    "newsletter" => "0",
    "website" => "",
));
  session_start();
$_SESSION['id'] = $_POST['emailInscription'];

$inscription = "yes";

}
else
{
$inscription = $language[$langueAffichage]['Pseudo_deja_utilise'];   
}

}
else
{
$inscription = $language[$langueAffichage]['Le_pseudo_doit_contenir_entre_4et14'];   
}

}
else
{
$inscription = $language[$langueAffichage]['Caracteres_alphanumerique_espace'];  
}

}
else
{
$inscription = $language[$langueAffichage]['Mdp_6_mini']; 	
}

}
else
{
$inscription = $language[$langueAffichage]['Mdp_correspondance'];   
}


}
else
{
$inscription = $language[$langueAffichage]['Compte_email_existant'];       
}


}
else
{
$inscription = $language[$langueAffichage]['Email_invalide'];        
}



}
else
{
$inscription = $language[$langueAffichage]['Au_moins_un_champs_vide'];       
}


}
else
{
$inscription = $language[$langueAffichage]['Probleme_survenu'];     
}


}
else
{
$inscription = $language[$langueAffichage]['Deja_connecte'];     
}


echo json_encode(['inscription' => $inscription]);



 
?>
