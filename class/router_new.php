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


                            afficherBlog($numeroPage,  $categorie, $idArticle, "articleIndividuel");

                    }




            }
            elseif($page == "requete") {

            if(isset($_POST['req']))
            {
            
                $req = $_POST['req']; 

                if($req == "addComment")
                {
                        
                    $controller = new Controller;
                    $controller->addComment($_POST);            
                
                
                }


            }

                       
            }
            elseif($page == "blog-admin") {
                
               $controller = new Controller;
               $controller->afficherPanneauAdmin();
                       
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
