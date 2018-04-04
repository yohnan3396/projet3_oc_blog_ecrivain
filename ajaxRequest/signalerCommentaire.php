<?php
include_once('connexionBDD.php'); // Connexion à la base de données
require('../language/traduction.php'); 

global $db;

if(isset($_POST['typeCommentaire']) AND !empty($_POST['typeCommentaire']) AND isset($_POST['idCommentaireSignalement']) AND !empty($_POST['idCommentaireSignalement']))
{

$temps = time();
$inserer = $db->prepare("INSERT INTO signaler_commentaire(id_commentaire, type, temps)
    VALUES(:id_commentaire, :type, :temps)");
$inserer->execute(array(
    "id_commentaire" => htmlspecialchars($_POST['idCommentaireSignalement']),
    "type" => htmlspecialchars($_POST['typeCommentaire']),
    "temps" => $temps,
 


));



$msg = "yes";

	
}
else
{
$msg = "Un problème est survenu";
}

   



echo json_encode(['msg' => $msg]);



 
?>
