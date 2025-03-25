<?php 
// config.php

// Activer l'affichage des erreurs (TEMPORAIRE, à désactiver en production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Durée de la session en secondes (ex : 3600 = 1 heure)
$session_lifetime = 3600;

// Ne modifier les paramètres de session que si aucune session n'est active
if (session_status() === PHP_SESSION_NONE) {
    ini_set('session.gc_maxlifetime', $session_lifetime);
    session_set_cookie_params($session_lifetime);
    session_start();
}

// Connexion PDO à la base de données
define('DB_HOST', '168.63.6.6');  // Remplace par l'IP de ton serveur
define('DB_NAME', 'stage_db');     // Nom de la base de données
define('DB_USER', 'hedi-rihani');  // Utilisateur MySQL
define('DB_PASS', 'G4@CESIweb');   // Mot de passe MySQL

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8", DB_USER, DB_PASS, $options);
} catch (PDOException $e) {
    // Enregistrer l'erreur dans un fichier log
    error_log("Erreur de connexion PDO : " . $e->getMessage(), 3, __DIR__ . "/error.log");
    
    // Affichage d'un message d'erreur générique pour les utilisateurs
    die("Une erreur est survenue. Contactez l'administrateur.");
}
?>
