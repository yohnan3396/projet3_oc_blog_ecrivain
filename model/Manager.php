<?php
namespace Blog\Index\Model;

// Connexion à la base de données

class Manager
{
    protected function dbConnect()
    {
       
       $db = new \PDO('mysql:host=db724355510.db.1and1.com;dbname=db724355510;charset=utf8', 'dbo724355510', 'Keeway183396;');
        return $db;
    }

}

