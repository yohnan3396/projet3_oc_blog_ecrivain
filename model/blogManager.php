<?php

namespace Blog\Index\Model;

require_once("model/Manager.php");

// Pour les vues lesArticles.php & articleIndividuel.php

class blogManager extends Manager
{


    public function getArticles($numeroPage, $categorie, $idArticle)
    {
        // Connexion à la base de données
        $db = $this->dbConnect();

        $nombreDarticlesParPage = 20; 

        if ($numeroPage == "noPage")
        {
            $numeroPage = 1;
        }



        // Si on a qu'un seul article (article individuel)
        if($idArticle != "all")
        {
            $reqWhereCount = "AND id='".$idArticle."'";	
            $reqWhere = "AND b.id='".$idArticle."'";
        }
        else
        {
            $reqWhereCount = "";
            $reqWhere = "";
        }

        // Si on filtre par les catégories dans la vue lesArticles.php
        if($categorie != "noCateg")
        {
            $nbArticles = $db->query("SELECT COUNT(*) FROM blog WHERE categorie_id='$categorie' $reqWhereCount ")->fetchColumn();     
        }
        else
        {
            $nbArticles = $db->query("SELECT COUNT(*) FROM blog WHERE 1=1 $reqWhereCount")->fetchColumn();    
        }


        // Gestion des pages dans la vue lesArticles.php 

        $totalDesArticles = $nbArticles;

        $nombreDePages  = ceil($totalDesArticles / $nombreDarticlesParPage); 

        $premierMessageAafficher = ($numeroPage - 1) * $nombreDarticlesParPage;

        // On récupère les contenu d'un ou des articles
        // Si on filtre avec une catégorie

        if($categorie != "noCateg")
        {
             $articles = $db->prepare("SELECT b.id_membre, b.titre, b.contenu_html, b.url_photo, b.id, b.date_creation, b.date_modification, b.categorie_id, b.title_alt_photo, b.description_courte, c.categorie FROM blog b INNER JOIN blog_categories c ON b.categorie_id=c.id  WHERE categorie_id = ? $reqWhere ORDER by ID DESC LIMIT " . $premierMessageAafficher . ', ' . $nombreDarticlesParPage);	
             $articles->execute(array($categorie));       
        }
        else
        {

            $articles = $db->prepare("SELECT b.id_membre, b.titre, b.contenu_html, b.url_photo, b.id, b.date_creation, b.date_modification, b.categorie_id, b.title_alt_photo, b.description_courte, c.categorie FROM blog b  INNER JOIN blog_categories c ON b.categorie_id=c.id  WHERE 1=1 $reqWhere ORDER by ID DESC LIMIT " . $premierMessageAafficher . ', ' . $nombreDarticlesParPage);  
            $articles->execute(array());    
        }


        // Création d'un tableau d'objet contenant les informations d'un ou plusieurs articles 
        while ($article = $articles->fetch())
        { 


            $articleX = new Article();
            $articleX->setId($article['id']);
            $articleX->setTitre($article['titre']);
            $articleX->setDate($article['date_creation']);
            $articleX->setDescriptionCourte($article['description_courte']);
            $articleX->setTitreAltPhoto($article['title_alt_photo']);
            $articleX->setContenuArticle($article['contenu_html']);
            $articlesTotal[] = $articleX; // tableau d'objet
             

        }
        $articles->closeCursor();


        // On récupère les commentaires si on est sur la vue articleIndividuel.php

         if($idArticle != "all")
        {

                   // On récupère les catégories pour la vue lesArticles.php afin de pouvoir effectuer le trie par catégorie.

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

        }



        // On récupère les catégories pour la vue lesArticles.php afin de pouvoir effectuer le trie par catégorie.

        $categoriesReq = $db->prepare("SELECT * FROM blog_categories ");
        $categoriesReq->execute(array());       
        while ($categorieReq = $categoriesReq->fetch())
        { 
 
            $categX = new Categorie();
            $categX->setName($categorieReq['categorie']);
            $categX->setId($categorieReq['id']);
            $categTotal[] = $categX; // tableau d'objet
             

        } 
        $categoriesReq->closeCursor();


       // On renvoie un tableau contenant toutes les informations.


        return array($articlesTotal, $nombreDePages, $categTotal, $commentairesTotal);
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
        $this->temps = $temps;
    }




}



class Categorie
{


    private $id;
    private $name;

 
    public function getId()
    {
        return $this->id;
    }
   
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }


}





class Article
{


    private $id;
    private $titre;
    private $date_creation;
    private $description_courte;
    private $title_alt_photo;
    private $contenu_html;
 
    public function getId()
    {
        return $this->id;
    }
   
    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitre()
    {
        return $this->titre;
    }

    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    public function getDate()
    {
        return $this->date_creation;
    }

    public function setDate($date)
    {
        $this->date_creation = $date;
    }

    public function getDescriptionCourte()
    {
        return $this->description_courte;
    }

    public function setDescriptionCourte($description_courte)
    {
        $this->description_courte = $description_courte;
    }
 
    public function getTitreAltPhoto()
    {
        return $this->title_alt_photo;
    }

    public function setTitreAltPhoto($title_alt_photo)
    {
        $this->title_alt_photo = $title_alt_photo;
    }

    public function getContenuArticle()
    {
        return $this->contenu_html;
    }

    public function setContenuArticle($contenu_html)
    {
        $this->contenu_html = $contenu_html;
    }



}