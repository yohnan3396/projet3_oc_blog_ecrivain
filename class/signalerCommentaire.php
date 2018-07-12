<?php
namespace Blog\Index\Model;

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


