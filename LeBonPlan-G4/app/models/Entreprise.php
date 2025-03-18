<?php
namespace App\Models;

class Entreprise
{
    public function getAll()
    {
        // Cette méthode va récupérer toutes les entreprises depuis la base de données.
        // On retourne ici un tableau d'entreprises fictif pour l'exemple.
        return [
            ['id' => 1, 'nom' => 'Entreprise A'],
            ['id' => 2, 'nom' => 'Entreprise B'],
            ['id' => 3, 'nom' => 'Entreprise C']
        ];
    }
}