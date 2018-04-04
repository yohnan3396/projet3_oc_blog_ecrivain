<?php

namespace Blog\Index\Model;

require_once("model/Manager.php");

// Pour les vues lesArticles.php & articleIndividuel.php

class commentManager extends Manager
{


    public function addComment($parameters)
    {
        // Connexion à la base de données
        $db = $this->dbConnect();
     

        if(isset($_POST['pseudo']) AND isset($_POST['commentaire']) AND is_numeric($_POST['id_article']))
        {
     

        // Vérifications 

        if(strlen($_POST['pseudo']) >= 3 AND strlen($_POST['commentaire']) >= 10)
        {

            $temps = time();
            $adresse_ip = $_SERVER['REMOTE_ADDR'];

            $inserer = $db->prepare("INSERT INTO blog_commentaires(commentaire, temps, pseudo, id_article, ip)
                VALUES(:commentaire, :temps, :pseudo, :id_article, :ip)");
            $inserer->execute(array(
                "commentaire" => htmlspecialchars($_POST['commentaire']),
                "temps" => $temps,
                "pseudo" => htmlspecialchars($_POST['pseudo']),
                "id_article" => $_POST['id_article'],
                "ip" => $adresse_ip,
            ));

             $msg = "ok";


        }
        else
        {
            $msg = "Le pseudo doit faire minimum 3 caractères et le commentaires 10 caractères.";
        }

        }
        else
        {
        
            $msg = "Erreur";

        }

     return $msg;

    }



}

