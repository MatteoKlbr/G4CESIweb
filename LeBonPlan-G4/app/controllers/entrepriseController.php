<?php
// /app/controllers/EntrepriseController.php
namespace App\Controllers;

use App\Models\Entreprise;

class EntrepriseController
{
    public function index()
    {
        // Créer une instance du modèle Entreprise
        $entrepriseModel = new Entreprise();
        
        // Récupérer les données des entreprises
        $entreprises = $entrepriseModel->getAll();
        
        // Passer les données à la vue
        require_once '../app/views/entreprises.php';  // Afficher la vue entreprises.php
    }
}
