<?php
namespace Blog\Index\Model;

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