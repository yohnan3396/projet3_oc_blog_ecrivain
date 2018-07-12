<?php

namespace Blog\Index\Model;

require_once("model/Manager.php");


class connectAdminManager
{

    public function checkMdp()
    {


        if(isset($_POST['mdp']))
        {

            $hash = '$2y$10$h7XzUAJIR5jLw2ugt9EiVuxy4V.bBLL5etcQAqCzRpkrLVUzcHrHG';

            if (password_verify($_POST['mdp'], $hash)) 
            {
                $_SESSION['access'] = "142215CCBEB7291699E8922A5E8ED";

                $msg = "yes";
            } 
            else 
            {
                $msg = "Mot de passe incorrect.";       
            }





        
        }
        else
        {
            $msg = "Formulaire vide.";
        }

        return $msg;

        
    }


}




