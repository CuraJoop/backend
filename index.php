<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

// Exemple de snippets
$snippets = [
    [
        "title" => "Premier snippet",
        "code" => "console.log('Hello World');",
        "language" => "JavaScript"
    ],
    [
        "title" => "Deuxième snippet",
        "code" => "print('Bonjour le monde')",
        "language" => "Python"
    ]
];

echo json_encode($snippets);
?>
