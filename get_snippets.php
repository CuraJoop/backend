<?php
// Activer les erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// En-têtes CORS
header('Access-Control-Allow-Origin: *'); // Autorise tous les domaines (ou remplace * par l'URL Netlify)
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

// Gérer les requêtes OPTIONS (pré-vérification CORS)
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

header('Content-Type: application/json');

require_once 'config.php';

try {
    $stmt = $pdo->query("SELECT * FROM snippets");
    $snippets = $stmt->fetchAll();
    // Convertir les champs favorite et tags
    foreach ($snippets as &$snippet) {
        $snippet['favorite'] = (bool)$snippet['favorite'];
        $snippet['tags'] = json_decode($snippet['tags'], true) ?? [];
    }
    echo json_encode($snippets);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur serveur : ' . $e->getMessage()]);
}
?>
