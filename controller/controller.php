<?php
// Appel des modèles
require_once('model/blogManager.php');
require_once('model/erreurManager.php');
require_once('model/commentManager.php');


class Controller 
{

	public function afficherAddArticle($id_article)
	{

		$blogManager = new \Blog\Index\Model\blogManager();
    
	    if($id_article != "none")
	    {
			list($articlesTotal) = $blogManager->getArticles("noPage", "noCateg", $id_article);
	    }
	  
		require('view/backend/add-article.php');
	}


	public function afficherPanneauAdmin()
	{

		$blogManager = new \Blog\Index\Model\blogManager();
		$commentManager = new \Blog\Index\Model\commentManager();

		list($articlesTotal) = $blogManager->getArticles("all", "noCateg", "all");
		list($signalerCommentaireTotal) = $commentManager->getSignalerCommentaire();

		require('view/backend/admin.php');
	}


	// Gestion des erreurs 404, 500 etc..

	public function erreur($erreur)
	{

		$erreurManager = new \Blog\Index\Model\erreurManager();

		$erreur = $erreurManager->getErreur($erreur);
		require('view/frontend/affichageErreur.php');
	}

	// Gestion de l'affichage du blog et des commentaires

	public function afficherBlog($numeroPage,  $categorie, $idArticle, $view)
	{


		$blogManager = new \Blog\Index\Model\blogManager();
		$commentManager = new \Blog\Index\Model\commentManager();

		list($articlesTotal, $nombreDePages, $categTotal, $commentairesTotal) = $blogManager->getArticles($numeroPage, $categorie, $idArticle);

        if($idArticle != "all")
        {
        	$commentairesTotal = $commentManager->readComment($idArticle);
        }

		if($numeroPage == "noPage")
		{
		    $numeroPage = 1;

		}
		else
		{
		    $numeroPage = $numeroPage;
		}

		$categorie = $categorie;


		require('view/frontend/'.$view.'.php');


	}

	public function deleteArticle()
	{

		$blogManager = new \Blog\Index\Model\blogManager();
		$response = $blogManager->deleteArticle();

		echo json_encode(["msg" => $response]);
	}



	public function addComment()
	{

		$commentManager = new \Blog\Index\Model\commentManager();
		$response = $commentManager->addComment();
        
        echo json_encode(["errorAjoutCommentaire" => $response]);

	}


	public function deleteCommentaire()
	{

		$commentManager = new \Blog\Index\Model\commentManager();
		$response = $commentManager->annulerSignalement();
		$response2 = $commentManager->deleteCommentaire();

        echo json_encode(["msg" => $response, "msg2" => $response2]);

	}
 
	public function signalerCommentaire()
	{

		$commentManager = new \Blog\Index\Model\commentManager();
		$response = $commentManager->signalerCommentaire();

        echo json_encode(["msg" => $response]);

	}

	public function annulerSignalement()
	{

		$commentManager = new \Blog\Index\Model\commentManager();
		$response = $commentManager->annulerSignalement();

        echo json_encode(["msg" => $response]);

	}


	public function addArticle()
	{


		$blogManager = new \Blog\Index\Model\blogManager();
		$response = $blogManager->addArticle();

        echo json_encode(["msg" => $response]);

	}


	public function updateArticle()
	{

		$blogManager = new \Blog\Index\Model\blogManager();
		$response = $blogManager->updateArticle();

        echo json_encode(["msg" => $response]);


	}

}
 





