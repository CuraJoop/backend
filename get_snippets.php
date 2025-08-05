<?php
require_once 'config.php';

try {
    $stmt = $pdo->query('SELECT id, title, description, category, code, tags, favorite, views, created_at, updated_at FROM snippets ORDER BY created_at DESC');
    $snippets = $stmt->fetchAll();
    // Convertir les tags en tableau
    foreach ($snippets as &$snippet) {
        $snippet['tags'] = $snippet['tags'] ? explode(',', $snippet['tags']) : [];
    }
    echo json_encode($snippets);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>