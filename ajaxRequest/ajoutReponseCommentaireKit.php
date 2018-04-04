<?php
include_once('connexionBDD.php'); // Connexion à la base de données
require('../language/traduction.php'); 

global $db;

$id = "none";

if(isset($_SESSION['id']))
{





if(isset($_POST['idCommentaire']) AND isset($_POST['commentReponseKit']))
{

if(!empty($_POST['idCommentaire']) AND !empty($_POST['commentReponseKit']))
{

if(strlen($_POST['commentReponseKit']) > 4 AND strlen($_POST['commentReponseKit']) <= 120)
{

$membreCo = $db->prepare("SELECT * FROM user_temp WHERE email = ? ");
$membreCo->execute(array($_SESSION['id']));
while ($donneesMembreCo = $membreCo->fetch())
{
$idMembreCo = $donneesMembreCo['id'];
}
$membreCo->closeCursor();


$commentaireKit = $db->prepare("SELECT type FROM commentaire_kit WHERE id = ? ");
$commentaireKit->execute(array($_POST['idCommentaire']));
while ($donneesCommentaireKit = $commentaireKit->fetch())
{
$type = $donneesCommentaireKit['type'];
}
$commentaireKit->closeCursor();



$temps = time();
$inserer = $db->prepare("INSERT INTO reponse_commentaire(id_membre_reponse, id_commentaire, temps_reponse, commentaire_reponse)
    VALUES(:id_membre_reponse, :id_commentaire, :temps_reponse, :commentaire_reponse)");
$inserer->execute(array(
    "id_membre_reponse" => $idMembreCo,
    "id_commentaire" => htmlspecialchars($_POST['idCommentaire']),
    "temps_reponse" => $temps,
    "commentaire_reponse" => htmlspecialchars($_POST['commentReponseKit']),



));



$errorReponseCommentaire = "yes";


$id = $db->lastInsertId();

   


}
else
{
$errorReponseCommentaire  = $language[$langueAffichage]['Le_commentaire_doit_etre_compris_5120'];   
}


}
else
{
    $errorReponseCommentaire  = $language[$langueAffichage]['Au_moins_un_champs_vide'];  
}


}
else
{
    $errorReponseCommentaire  = $language[$langueAffichage]['Probleme_survenu'];    
}





}
else
{
    $errorReponseCommentaire  = $language[$langueAffichage]['Vous_devez_etre_connecte']; 
}



echo json_encode(['errorReponseCommentaire' => $errorReponseCommentaire, 'id' => $id, 'type' => $type]);



 
?>
