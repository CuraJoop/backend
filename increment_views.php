
<?php
require_once 'config.php';

// Gérer les requêtes OPTIONS pour CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    http_response_code(200);
    exit;
}

header('Content-Type: application/json');

// Lire les données JSON envoyées par React
$data = json_decode(file_get_contents("php://input"), true);

// Vérifier si l'ID est fourni
if (!isset($data['id']) || !is_numeric($data['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'ID manquant ou invalide']);
    exit;
}

$id = (int)$data['id'];

try {
    // Incrémenter le compteur de vues
    $stmt = $pdo->prepare("UPDATE snippets SET views = views + 1 WHERE id = :id");
    $stmt->execute([':id' => $id]);

    // Vérifier si une ligne a été affectée
    if ($stmt->rowCount() > 0) {
        echo json_encode(['success' => true, 'message' => 'Vues incrémentées avec succès']);
    } else {
        http_response_code(404);
        echo json_encode(['error' => 'Snippet non trouvé']);
    }
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de l\'incrémentation : ' . $e->getMessage()]);
}
?>
