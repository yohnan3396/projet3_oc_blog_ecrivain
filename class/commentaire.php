<?php
namespace Blog\Index\Model;

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


