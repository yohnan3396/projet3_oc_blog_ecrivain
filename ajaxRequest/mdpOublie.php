<?php
include_once('connexionBDD.php'); // Connexion à la base de données
require('../language/traduction.php'); 
global $db;


if ((isset($_POST['emailMdpOublie']) && !empty($_POST['emailMdpOublie']))) 
{ 


$email = $_POST['emailMdpOublie'];

// On vérifie la validité de l'adresse e-mail

if(filter_var($email, FILTER_VALIDATE_EMAIL)){


$req = $db->prepare("SELECT COUNT(*) AS testemail FROM user_temp WHERE email = :email");                       
$req->execute(array('email' => $_POST['emailMdpOublie']));
$donnees = $req->fetch(PDO::FETCH_BOTH);  // On vérifie si l'email est bien présent dans la BDD.

// Si il est présent

if($donnees['testemail'] == 1)
{

        $query=$db->prepare('SELECT pass FROM user_temp WHERE email = :email');
        $query->bindValue(':email',$_POST['emailMdpOublie'], PDO::PARAM_STR);
        $query->execute();
        $data=$query->fetch();

// On récupère les informations du membre avec une requête préparé pour éviter les failles


// On génère un mot de passe alétoire de 10 caractères

    $characts    = 'abcdefghijklmnopqrstuvwxyz';
    $characts   .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';    
    $characts   .= '1234567890'; 
    $code_aleatoire      = ''; 

    for($i=0;$i < 10;$i++)    //10 est le nombre de caractères
    { 
        $code_aleatoire .= substr($characts,rand()%(strlen($characts)),1); 
    }


// On crypte ce mot de passe

$options = [
    'cost' => 12,
];


$passcrypt = password_hash($code_aleatoire, PASSWORD_BCRYPT, $options)."\n";

$req = $db->prepare("UPDATE user_temp SET pass = :pass WHERE  email='$_POST[emailMdpOublie]' ");
$req->execute(array(
  'pass' => $passcrypt,
  ));


$subject_ecrire = "LesKits.com - Réintialisation du mot de passe";

$contents = "<center><h1 style='font-size:25px; color:#4E4E4E;'>Réintialisation de votre mot de passe </h1></center>

<center><img src='https://leskits.com/assets/img/logo-kits-full.png'></center>

Bonjour, vous avez fait une demande pour récupérer votre mot de passe.
<p>

 Voici votre nouveau mot de passe : <b> $code_aleatoire </b><p>

 Une fois connecté, vous pourrez le modifier dans \"Mon profil / Changer mon mot de passe\".

<p>
     Bonne journée,<br>
     <br>
     L'équipe LesKits.com

<hr>

<small style='color:grey;'> Ceci est un e-mail automatique. Si cet e-mail ne vous est pas destiné, merci de ne pas en tenir compte. </small>

     ";



  // Envoie d'un e-mail

     $to  = $_POST['emailMdpOublie'];
     // Sujet
        $subject = $subject_ecrire;

     // message
     $message = $contents;

     // Pour envoyer un mail HTML, l'en-tête Content-type doit être défini
     $headers  = 'MIME-Version: 1.0' . "\r\n";
     $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";

     // En-têtes additionnels

     $headers .= "From: LesKits <contact@leskits.com>" . "\r\n";


     // Envoi
     mail($to, $subject, $message, $headers);

 $errorEmailOublie = "yes"; 
}
else
{

   $errorEmailOublie = $language[$langueAffichage]['Email_pas_presente_bdd'];


}

}

else {


 $errorEmailOublie = $language[$langueAffichage]['Email_invalide'];


}





}
else
{
$errorEmailOublie = $language[$langueAffichage]['Au_moins_un_champs_vide'];

}

 

 echo json_encode(['errorEmailOublie' => $errorEmailOublie ]);
 
?>
