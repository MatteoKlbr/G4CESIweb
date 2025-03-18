<?php
namespace App\Controllers;

class HomeController
{
    public function index()
    {
        // Logique pour afficher la page d'accueil
        require_once '../app/views/Accueil.php';
    }
}
