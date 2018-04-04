<?php
include_once('connexionBDD.php'); // Connexion à la base de données
require('../language/traduction.php'); 

// CHECKER si bon membre

if(isset($_SESSION['id']))
{

$membreCo = $db->prepare("SELECT * FROM user_temp WHERE email = ? ");
$membreCo->execute(array($_SESSION['id']));
while ($donneesMembreCo = $membreCo->fetch())
{
$idMembreCo = $donneesMembreCo['id'];
}
$membreCo->closeCursor();

if(isset($_POST['typeCommentaireSupprimer']) AND isset($_POST['idCommentaireSupprimer']))
{
if($_POST['typeCommentaireSupprimer'] == "reponse")
{
$select = "id_membre_reponse";
$from = "reponse_commentaire";
}
elseif($_POST['typeCommentaireSupprimer'] == "commentaire")
{
$select = "id_membre";
$from = "commentaire_kit";
}

}

$checkID = $db->prepare("SELECT $select FROM $from WHERE id = ? ");
$checkID->execute(array($_POST['idCommentaireSupprimer']));
while ($donneesCheckID = $checkID->fetch())
{
$idMembreCommentaire = $donneesCheckID[$select];
}
$checkID->closeCursor();


if($idMembreCommentaire == $idMembreCo)
{
$sql = "DELETE FROM $from WHERE id =  :id  ";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id', $_POST['idCommentaireSupprimer'], PDO::PARAM_INT); 
$stmt->execute();

$msg = "ok";
}
else
{
$msg = "Bien tenté ;)";
}

}
else
{
$msg = "Bien tenté / Pas de session ;)";	
}

echo json_encode(['msg' => $msg]);
?>