<?php
require_once('controller/controller.php');

class MyRouter
{

    private $page;

    public function setGet($page)
    {
         $this->page = $page;
    }

    public function activeUrl()
    {

        $page = $this->page;

        try {
            if (isset($page)) 
            {
 
                if ($page == 'articleIndividuel') {
                 
                    if (isset($_GET['idArticle']) && is_numeric($_GET['idArticle']))
                    {
                      
                        $categorie = "noCateg";
                        $numeroPage = "noPage";
                        $idArticle = $_GET['idArticle'];

                        $controller = new Controller;
                        $controller->afficherBlog($numeroPage,  $categorie, $idArticle, "articleIndividuel");
                    }

            }
            elseif($page == "addComment") {

            if(isset($_POST['idArticle']) AND is_numeric($_POST['idArticle']))
            {
                    $controller = new Controller;
                    $controller->addComment();            
            }

                       
            }
            elseif($page == "signalerCommentaire") {


            if(isset($_POST['idCommentaireSignalement']) AND is_numeric($_POST['idCommentaireSignalement']))
            {
                    $controller = new Controller;
                    $controller->signalerCommentaire();            
            }

                       
            }
            elseif($page == "deleteArticle") {


            if(isset($_POST['id']) AND is_numeric($_POST['id']))
            {
    
                    $controller = new Controller;
                    $controller->deleteArticle();            

            }

                       
            }
            elseif($page == "annulerSignalement") {


            if(isset($_POST['id']) AND is_numeric($_POST['id']))
            {
   
                    $controller = new Controller;
                    $controller->annulerSignalement();            

            }

                       
            }
            elseif($page == "deleteCommentaire") {


            if(isset($_POST['id']) AND is_numeric($_POST['id']))
            {
   
                    $controller = new Controller;
                    $controller->deleteCommentaire();            

            }

                       
            }
            elseif($page == "blog-admin") {
                
               $controller = new Controller;
               $controller->afficherPanneauAdmin();
                       
            }
            elseif($page == "add-article") {
                
               $controller = new Controller;

               if(isset($_GET['id_article']) AND is_numeric($_GET['id_article']))
               {
                 $id_article = $_GET['id_article'];
               }
               else
               {
                 $id_article = "none";
               }

               $controller->afficherAddArticle($id_article);
                       
            }
            elseif($page == "reqAddArticle") {
                
               $controller = new Controller;

            if(isset($_POST['idArticle']) AND is_numeric($_POST['idArticle']))
            {
                 $controller->updateArticle();
            }
            else
            {
                 $controller->addArticle();
            }
              
                       
            }
            elseif($page == 'index')
            {
       

                    if (isset($_GET['categ']))
                    {
                         $categorie = $_GET['categ'];
                    }
                    else 
                    {
                          $categorie = "noCateg";
                    }

                    if (isset($_GET['numeroPage']) && $_GET['numeroPage'] > 0) {

                            $numeroPage = $_GET['numeroPage'];
                    }
                    else 
                    {

                         $numeroPage = "noPage";
                    }

                    $idArticle = "all";
                    
                    $controller = new Controller;
                    $controller->afficherBlog($numeroPage,  $categorie, $idArticle, "lesArticles");

            }
            else
            {

                    $erreur = 404;
                    $controller = new Controller;
                    $controller->erreur($erreur);

            }
        }
    }
        catch(Exception $e) {
            echo 'Erreur : ' . $e->getMessage();
        }

        
    }

}
