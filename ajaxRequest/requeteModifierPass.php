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
$pass = $donneesMembreCo['pass'];
}





if(isset($_POST['ancien_pass']) AND isset($_POST['new_pass']) AND isset($_POST['new_pass_confirm']))
{

if(!empty($_POST['ancien_pass']) AND !empty($_POST['new_pass']) AND !empty($_POST['new_pass_confirm']))
{


if (password_verify($_POST['ancien_pass'], $pass)) {

if($_POST['new_pass'] == $_POST['new_pass_confirm'])
{

if(strlen($_POST['new_pass']) > 5)
{

$options = [
    'cost' => 12,
];

$passcrypt = password_hash($_POST['new_pass'], PASSWORD_BCRYPT, $options)."\n";




$req = $db->prepare("UPDATE user_temp SET pass = :pass WHERE id='$idMembreCo' ");
$req->execute(array(
  'pass' => $passcrypt,
  ));




$errorModifierPass = "yes";


$id = $db->lastInsertId();

}
else
{
$errorModifierPass = $language[$langueAffichage]['Mdp_6_mini']; 
}
}
else
{
$errorModifierPass = $language[$langueAffichage]['Mdp_correspondance'];   
}


}
else
{
$errorModifierPass = $language[$langueAffichage]['Mdp_errone'];  
}



}
else
{
    $errorModifierPass  = $language[$langueAffichage]['Au_moins_un_champs_vide'];   
}


}
else
{
    $errorModifierPass  = $language[$langueAffichage]['Probleme_survenu'];   
}




}
else
{
    $errorModifierPass  = $language[$langueAffichage]['Vous_devez_etre_connecte'];
}


echo json_encode(['errorModifierPass' => $errorModifierPass, 'id' => $id]);



 
?>
