<?php
// Appel des modèles
require_once('model/blogManager.php');
require_once('model/erreurManager.php');
require_once('model/commentManager.php');


class Controller 
{

	// Affichage du panneau administration

	public function afficherPanneauAdmin()
	{

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

	public function deleteArticle($id)
	{


		$blogManager = new \Blog\Index\Model\blogManager();

		$blogManager->deleteArticle($id);

	}

	public function addArticle($parameters)
	{


		$blogManager = new \Blog\Index\Model\blogManager();
		$blogManager->addArticle($parameters);


	}


	public function updateArticle($parameters)
	{


		$blogManager = new \Blog\Index\Model\blogManager();
		$blogManager->updateArticle($parameters);


	}



	public function addComment()
	{

		$commentManager = new \Blog\Index\Model\commentManager();
		$response = $commentManager->addComment();
        
        echo json_encode(["errorAjoutCommentaire" => $response]);

	}


	public function deleteComment($id)
	{

		$commentManager = new \Blog\Index\Model\commentManager();
		$commentManager->addComment($id);

	}
 
	public function signalerCommentaire()
	{

		$commentManager = new \Blog\Index\Model\commentManager();
		$response = $commentManager->signalerCommentaire();

        echo json_encode(["msg" => $response]);

	}


}
 





