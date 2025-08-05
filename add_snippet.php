
<?php
require_once 'config.php';

// Gérer les requêtes OPTIONS pour CORS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
    http_response_code(200);
    exit;
}

header('Content-Type: application/json');

// Lire les données JSON envoyées par React
$data = json_decode(file_get_contents("php://input"), true);

// Vérifier les champs requis
if (
    !isset($data['title']) ||
    !isset($data['description']) ||
    !isset($data['category']) ||
    !isset($data['code'])
) {
    http_response_code(400);
    echo json_encode(['error' => 'Champs manquants']);
    exit;
}

$title = $data['title'];
$description = $data['description'];
$category = in_array($data['category'], ['PHP', 'HTML', 'CSS']) ? $data['category'] : 'PHP';
$code = $data['code'];
$tags = isset($data['tags']) ? implode(',', $data['tags']) : '';
$favorite = isset($data['favorite']) ? (int)$data['favorite'] : 0;
$views = 0;

try {
    if (isset($data['id']) && $data['id']) {
        // Mise à jour d'un snippet existant
        $stmt = $pdo->prepare("UPDATE snippets SET title = :title, description = :description, category = :category, code = :code, tags = :tags, favorite = :favorite, updated_at = NOW() WHERE id = :id");
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':category' => $category,
            ':code' => $code,
            ':tags' => $tags,
            ':favorite' => $favorite,
            ':id' => $data['id']
        ]);
    } else {
        // Ajout d'un nouveau snippet
        $stmt = $pdo->prepare("INSERT INTO snippets (title, description, category, code, tags, favorite, views, created_at, updated_at) VALUES (:title, :description, :category, :code, :tags, :favorite, :views, NOW(), NOW())");
        $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':category' => $category,
            ':code' => $code,
            ':tags' => $tags,
            ':favorite' => $favorite,
            ':views' => $views
        ]);
    }

    echo json_encode(['success' => true, 'message' => 'Snippet ajouté avec succès']);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Erreur lors de l\'ajout : ' . $e->getMessage()]);
}
?>
