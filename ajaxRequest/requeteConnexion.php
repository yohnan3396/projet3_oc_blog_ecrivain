<?php
include_once('connexionBDD.php'); // Connexion à la base de données
require('../language/traduction.php'); 
global $db;

if(isset($_POST['emailConnexion']) AND isset($_POST['mdpConnexion']))
{

if(!empty($_POST['emailConnexion']) AND !empty($_POST['mdpConnexion']))
{

if(filter_var($_POST['emailConnexion'], FILTER_VALIDATE_EMAIL)){



  $presencEmail = $db->query("SELECT COUNT(*) FROM user_temp WHERE email='$_POST[emailConnexion]' ")->fetchColumn();
  if($presencEmail == 1){
  


        $query=$db->prepare('SELECT pass, id FROM user_temp WHERE email = :email');
        $query->bindValue(':email', htmlspecialchars($_POST['emailConnexion']), PDO::PARAM_STR);
        $query->execute();
        $data=$query->fetch();



// On vérifie le mot de passe
if (password_verify($_POST['mdpConnexion'], $data['pass'])) {

    session_start();
    $_SESSION['id'] = $_POST['emailConnexion'];
    $connexion = "yes";

}
else
{
$connexion = $language[$langueAffichage]['Mauvais_id_mdp'];  
}

  }
 else
 {
$connexion = $language[$langueAffichage]['Compte_inexistant']; 
 }





}
else
{
$connexion = $language[$langueAffichage]['Email_invalide'];
}

}
else
{
$connexion = $language[$langueAffichage]['Au_moins_un_champs_vide'];    
}


}
else
{
$connexion = $language[$langueAffichage]['Probleme_survenu'];;
}

echo json_encode(['connexion' => $connexion]); // On envoie les données en JSON.
?>