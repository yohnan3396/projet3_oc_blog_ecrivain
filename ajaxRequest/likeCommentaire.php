<?php
include_once('connexionBDD.php'); // Connexion à la base de données
require('../language/traduction.php'); 

global $db;

if(isset($_POST['id_commentaire']) AND !empty($_POST['id_commentaire']) AND isset($_POST['type_commentaire']) AND !empty($_POST['type_commentaire']) AND is_numeric($_POST['id_commentaire']) AND ($_POST['type_commentaire'] == 'commentaire' OR $_POST['type_commentaire'] == 'reponse'))
{

$membreCo = $db->prepare("SELECT * FROM user_temp WHERE email = ? ");
$membreCo->execute(array($_SESSION['id']));
while ($donneesMembreCo = $membreCo->fetch())
{
$idMembreCo = $donneesMembreCo['id'];
}
$membreCo->closeCursor();

$presenceLike = $db->query("SELECT COUNT(*) FROM like_commentaire WHERE id_commentaire='$_POST[id_commentaire]' AND type='$_POST[type_commentaire]' AND id_membre='$idMembreCo' ")->fetchColumn(); 




 if($presenceLike == 1){


$sql = "DELETE FROM like_commentaire WHERE id_commentaire =  :id_commentaire AND type = :type AND id_membre = :id_membre  ";
$stmt = $db->prepare($sql);
$stmt->bindParam(':id_commentaire', $_POST['id_commentaire'], PDO::PARAM_INT); 
$stmt->bindParam(':type', $_POST['type_commentaire'], PDO::PARAM_INT); 
$stmt->bindParam(':id_membre', $idMembreCo, PDO::PARAM_INT); 
$stmt->execute();


$msg = $language[$langueAffichage]['Jaime'];
 }
 else
 {

$temps = time();
$inserer = $db->prepare("INSERT INTO like_commentaire(type, id_commentaire, id_membre, temps)
    VALUES(:type, :id_commentaire, :id_membre, :temps)");
$inserer->execute(array(
    "id_commentaire" => htmlspecialchars($_POST['id_commentaire']),
    "type" => htmlspecialchars($_POST['type_commentaire']),
    "id_membre" => $idMembreCo,
    "temps" => $temps,

));

$msg = $language[$langueAffichage]['Jaime_plus'];

}

	
}
else
{
$msg = $language[$langueAffichage]['Probleme_survenu'];
}


$nbLike = $db->query("SELECT COUNT(*) FROM like_commentaire WHERE id_commentaire='$_POST[id_commentaire]' AND type='$_POST[type_commentaire]' ")->fetchColumn(); 





echo json_encode(['msg' => $msg, 'nbLike' => $nbLike]);



 
?>
