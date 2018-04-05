<?php

namespace Blog\Index\Model;

require_once("model/Manager.php");

// Pour les vues lesArticles.php & articleIndividuel.php

class blogManager extends Manager
{

    public function addArticle()
    {
        // Connexion à la base de données
        $db = $this->dbConnect();
     

        if(isset($_POST['contenu_html']))
        {
     

            $temps = time();

            $inserer = $db->prepare("INSERT INTO blog(titre, url_photo, contenu_html, date_creation, date_modification, id_membre, categorie_id, title_alt_photo, description_courte)
                VALUES(:titre, :url_photo, :contenu_html, :date_creation, :date_modification, :id_membre, :categorie_id, :title_alt_photo, :description_courte)");
            $inserer->execute(array(
                "titre" => htmlspecialchars($_POST['titre']),
                "url_photo" => htmlspecialchars($_POST['url_image']),
                "contenu_html" => $_POST['contenu_html'],
                "date_creation" => $temps,
                "date_modification" => "",
                "id_membre" => "1",
                "categorie_id" => htmlspecialchars($_POST['categorie_id']),
                "title_alt_photo" => htmlspecialchars($_POST['texte_remplacement_img']),
                "description_courte" => htmlspecialchars($_POST['description_courte']),
            ));

             $msg = "yes";



        }
        else
        {
        
            $msg = "Erreur";

        }

     return $msg;

    }



    public function deleteArticle()
    {
        // Connexion à la base de données
        $db = $this->dbConnect();

        $sql = "DELETE FROM blog WHERE id = ?  ";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($_POST['id']));

        $msg = "ok";

        return $msg; 

    }


    public function getArticles($numeroPage, $categorie, $idArticle)
    {
        // Connexion à la base de données
        $db = $this->dbConnect();

        $nombreDarticlesParPage = 20; 

        if ($numeroPage == "noPage")
        {
            $numeroPage = 1;
        }
        elseif($numeroPage == "all")
        {
        $numeroPage = 1;
        $nombreDarticlesParPage = 9999;     
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
            $articleX->setUrlImage($article['url_photo']);
            $articleX->setCategorieName($article['categorie']);
            $articleX->setCategorieID($article['categorie_id']);
            $articlesTotal[] = $articleX; // tableau d'objet
             

        }
        $articles->closeCursor();


 


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
    private $url_photo;
    private $categorie_name;
    private $categorie_id;
 



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
        $date = date("d/m/Y", $date);
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


    public function getUrlImage()
    {
        return $this->url_photo;
    }
   
    public function setUrlImage($url_photo)
    {
        $this->url_photo = $url_photo;
    }

    public function getCategorieName()
    {
        return $this->categorie_name;
    }
   
    public function setCategorieName($categorie_name)
    {
        $this->categorie_name = $categorie_name;
    }

    public function getCategorieID()
    {
        return $this->categorie_id;
    }
   
    public function setCategorieID($categorie_id)
    {
        $this->categorie_id = $categorie_id;
    }



}