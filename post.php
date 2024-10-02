<?php
   include('config.php'); // Include database connection 

session_start();
$user_id = $_SESSION['id'];
header('Content-Type: application/json'); // Set the content type to JSON

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $post_content = $_POST['post_content'];

        // Prépare une requête SQL pour insérer une nouvelle publication dans la base de données
        $stmt = $conn->prepare("INSERT INTO publication (contenu, date, id_compte) VALUES (:contenu, NOW(), :id_compte)");
        
        // Exécute la requête en liant les valeurs de contenu et d'identifiant de compte
        $stmt->execute(['contenu' => $post_content, 'id_compte' => $user_id]);

        // Create a response data array
        $lastInsertId = $conn->lastInsertId();

        // Préparer une requête pour récupérer les détails de la dernière insertion
        $stmtSelect = $conn->prepare("SELECT * FROM publication WHERE id = :id");
        $stmtSelect->execute(['id' => $lastInsertId]);

        // Récupérer le résultat
        $publication = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        $stmtSelect = $conn->prepare("SELECT * FROM compte WHERE id = :id");
        $stmtSelect->execute(['id' => $publication['id_compte'] ]);

        // Récupérer le résultat
        $compte = $stmtSelect->fetch(PDO::FETCH_ASSOC);

        // Préparer la réponse avec les données de la dernière insertion
        $data = [
            'id' => $publication['id'],
            'contenu' => $publication['contenu'],
            'date' => $publication['date'],
            'id_compte' => $publication['id_compte'],
            'nom' => $compte['nom'],
            'prenom' => $compte['prenom'],

        ];

            // Send a success response
            echo json_encode(['status' => 'success', 'data' => $data]);
            
        } else {
            // Send an error response for non-POST requests
            echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
