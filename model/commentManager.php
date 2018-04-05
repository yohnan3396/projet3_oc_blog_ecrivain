<?php

namespace Blog\Index\Model;

require_once("model/Manager.php");

// Pour les vues lesArticles.php & articleIndividuel.php

class commentManager extends Manager
{


    public function signalerCommentaire()
    {

    $db = $this->dbConnect();
    
        if(isset($_POST['idCommentaireSignalement']) AND is_numeric($_POST['idCommentaireSignalement']))
        {

             // Connexion à la base de données


            $temps = time();
            $inserer = $db->prepare("INSERT INTO signaler_commentaire(id_commentaire, temps)
                VALUES(:id_commentaire, :temps)");
            $inserer->execute(array(
                "id_commentaire" => htmlspecialchars($_POST['idCommentaireSignalement']),
                "temps" => $temps,
            ));



            $msg = "yes";

        
        }
        else
        {
            $msg = "Un problème est survenu";
        }

        return $msg;

        

    }


    public function addComment()
    {
        // Connexion à la base de données
        $db = $this->dbConnect();
     

        if(isset($_POST['pseudo']) AND isset($_POST['commentaire']) AND is_numeric($_POST['idArticle']))
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
                "id_article" => $_POST['idArticle'],
                "ip" => $adresse_ip,
            ));

             $msg = "yes";


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


    public function getSignalerCommentaire()
    {
    

            $db = $this->dbConnect();
     

            $signalerCommentaires = $db->prepare("SELECT s.id_commentaire, s.temps, c.id, c.commentaire, c.pseudo, c.id_article FROM signaler_commentaire s INNER JOIN blog_commentaire c ON s.id_commentaire=c.id ");
            $signalerCommentaires->execute(array());       
            while ($signalerCommentaire = $signalerCommentaires->fetch())
            { 
     
                $signalerCommentaireX = new signalerCommentaire();
                $signalerCommentaireX->setId($signalerCommentaire['id']);
                $signalerCommentaireX->setIdCommentaire($signalerCommentaire['id_commentaire']);
                $signalerCommentaireX->setDate($signalerCommentaire['temps']);
                $signalerCommentaireX->setCommentaire($signalerCommentaire['commentaire']);
                $signalerCommentaireX->setPseudo($signalerCommentaire['pseudo']);
                $signalerCommentaireX->setIdArticle($signalerCommentaire['id_article']);
                $signalerCommentaireTotal[] = $signalerCommentaireX; // tableau d'objet
                 

            } 
            $signalerCommentaires->closeCursor();



            return $signalerCommentaireTotal; 

    }    

    public function deleteCommentaire()
    {

        // Connexion à la base de données
        $db = $this->dbConnect();

        $sql = "DELETE FROM blog_commentaires WHERE id = ?  ";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($_POST['id']));

        $msg = "ok";

        return $msg; 

    }


    public function annulerSignalement()
    {

        // Connexion à la base de données
        $db = $this->dbConnect();

        $sql = "DELETE FROM signaler_commentaire WHERE id = ?  ";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($_POST['id_signalement']));

        $msg = "ok";

        return $msg; 

    }


}




class signalerCommentaire
{


    private $id;
    private $commentaire;
    private $pseudo;
    private $temps;
    private $id_article;
    private $id_commentaire;

     public function getIdArticle()
    {
        return $this->id_article;
    }
   
    public function setIdArticle($id_article)
    {
        $this->id_article = $id_article;
    }


    public function getId()
    {
        return $this->id;
    }
   
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getIdCommentaire()
    {
        return $this->id_commentaire;
    }
   
    public function setIdCommentaire($id_commentaire)
    {
        $this->id_commentaire = $id_commentaire;
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



    public function getDate()
    {

        return $this->temps;
    }

    public function setDate($temps)
    {
        $temps = date('d/m/Y - h:i:s', $temps);             
        $this->temps = $temps;
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


