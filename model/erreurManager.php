<?php
namespace Blog\Index\Model;

class erreurManager
{

   public function getErreur($erreur)
   {


      switch($erreur)
      {
         case '400':
         $text =  'Échec de l\'analyse HTTP.';
         $erreur =  400;
         break;
         case '401':
         $text = 'Le pseudo ou le mot de passe n\'est pas correct !';
         $erreur =  401;
         break;
         case '402':
         $text = 'Le client doit reformuler sa demande avec les bonnes données de paiement.';
         $erreur =  402;
         break;
         case '403':
         $text = 'Requête interdite !';
         $erreur =  403;
         break;
         case '404':
         $text = 'La page n\'existe pas ou plus !';
         $erreur =  404;
         break;
         case '405':
         $text = 'Méthode non autorisée.';
         $erreur =  405;
         break;
         case '500':
         $text = 'Erreur interne au serveur ou serveur saturé.';
         $erreur =  500;
         break;
         case '501':
         $text = 'Le serveur ne supporte pas le service demandé.';
         $erreur =  501;
         break;
         case '502':
         $text = 'Mauvaise passerelle.';
         $erreur =  502;
         break;
         case '503':
         $text = ' Service indisponible.';
         $erreur =  503;
         break;
         case '504':
         $text = 'Trop de temps à la réponse.';
         $erreur =  504;
         break;
         case '505':
         $text = 'Version HTTP non supportée.';
         $erreur =  505;
         break;
         default:
         $text = 'Erreur !';
         $erreur =  "Indéfini";
      }

      return $erreur;

   }


}
?>