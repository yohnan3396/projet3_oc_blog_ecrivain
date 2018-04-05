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


    public function readComment($idArticle)
    {
    

            $db = $this->dbConnect();
     

            $commentaires = $db->prepare("SELECT * FROM blog_commentaires WHERE id_article = ? ");
            $commentaires->execute(array($idArticle));       
            while ($commentaire = $commentaires->fetch())
            { 
     
                $commentairesX = new Commentaire();
                $commentairesX->setId($commentaire['id']);
                $commentairesX->setCommentaire($commentaire['commentaire']);
                $commentairesX->setPseudo($commentaire['pseudo']);
                $commentairesX->setTemps($commentaire['temps']);
                $commentairesTotal[] = $commentairesX; // tableau d'objet
                 

            } 
            $commentaires->closeCursor();

            return $commentairesTotal; 

    }


}



class Commentaire
{


    private $id;
    private $commentaire;
    private $pseudo;
    private $temps;

 
    public function getId()
    {
        return $this->id;
    }
   
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getCommentaire()
    {
        return $this->commentaire;
    }

    public function setCommentaire($commentaire)
    {

        $this->commentaire = $commentaire;
    }


    public function getPseudo()
    {
        return $this->pseudo;
    }

    public function setPseudo($pseudo)
    {
        $this->pseudo = $pseudo;
    }



    public function getTemps()
    {

        return $this->temps;
    }

    public function setTemps($temps)
    {
        $temps = date('d/m/Y - h:i:s', $temps);             
        $this->temps = $temps;
    }




}


