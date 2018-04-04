<?php
include_once('connexionBDD.php'); // Connexion à la base de données
require('../language/traduction.php'); 

global $db;

$id = "none";

if(isset($_SESSION['id']))
{



if(isset($_POST['idKit']) AND isset($_POST['commentKit']) AND isset($_POST['type']))
{

if(!empty($_POST['idKit']) AND !empty($_POST['commentKit']) AND !empty($_POST['type']))
{

if(strlen($_POST['commentKit']) > 4 AND strlen($_POST['commentKit']) <= 120)
{

$membreCo = $db->prepare("SELECT * FROM user_temp WHERE email = ? ");
$membreCo->execute(array($_SESSION['id']));
while ($donneesMembreCo = $membreCo->fetch())
{
$idMembreCo = $donneesMembreCo['id'];
}
$membreCo->closeCursor();



$temps = time();
$inserer = $db->prepare("INSERT INTO commentaire_kit(id_membre, commentaire, temps, id_kit, type)
    VALUES(:id_membre, :commentaire, :temps, :id_kit, :type)");
$inserer->execute(array(
    "id_membre" => $idMembreCo,
    "commentaire" => htmlspecialchars($_POST['commentKit']),
    "temps" => $temps,
    "id_kit" => htmlspecialchars($_POST['idKit']),
    "type" => htmlspecialchars($_POST['type']),


));



$errorAjoutCommentaire = "yes";


$id = $db->lastInsertId();

   


}
else
{
$errorAjoutCommentaire  = $language[$langueAffichage]['Le_commentaire_doit_etre_compris_5120'];        
}


}
else
{
    $errorAjoutCommentaire  = $language[$langueAffichage]['Au_moins_un_champs_vide'];   
}


}
else
{
    $errorAjoutCommentaire  = $language[$langueAffichage]['Probleme_survenu'];   
}





}
else
{
    $errorAjoutCommentaire  = $language[$langueAffichage]['Vous_devez_etre_connecte'];
}



echo json_encode(['errorAjoutCommentaire' => $errorAjoutCommentaire, 'id' => $id, 'type' => $_POST['type']]);



 
?>
