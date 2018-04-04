<?php
session_start();

require('class/router_new.php');

// On récupère variable GET

$page = $_GET['page'];

if(empty($_GET['page']))
{
	$page = "index";
}

// Appel de la class MyRouter et affichage de l'URL

$routeur = new MyRouter();

$routeur->setGet($page);

$routeur->activeUrl();

