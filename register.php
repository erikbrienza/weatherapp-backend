<?php
// CORS + JSON
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');
header('Content-Type: application/json');

include 'config.php';

// Preflight
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit;
}
// Blocca subito tutto ciò che NON è POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed']);
    exit;
}

// Leggi JSON
$data = json_decode(file_get_contents('php://input'), true);

// Validazione
if (empty($data['name']) || empty($data['email']) || empty($data['password'])) {
    echo json_encode(['message' => 'Compila tutti i campi!']);
    exit;
}

// Logica di inserimento...
$name     = $data['name'];
$email    = $data['email'];
$password = password_hash($data['password'], PASSWORD_DEFAULT);

try {
    $stmt = $conn->prepare('INSERT INTO users (name,email,password) VALUES (:n,:e,:p)');
    $stmt->execute([':n'=>$name,':e'=>$email,':p'=>$password]);
    echo json_encode(['message' => 'Registrazione avvenuta con successo!']);
} catch (PDOException $e) {
    // gestione duplicati, ecc.
    $dup = $e->errorInfo[0]==='23505' ? 'Email già registrata.' : 'Errore durante la registrazione.';
    echo json_encode(['message'=>$dup]);
}