<?php
session_start();
include('config.php'); // Inclure la connexion à la base de données

$user_id = $_SESSION['id'];
header('Content-Type: application/json'); // Définir le type de contenu sur JSON

// Vérifier si la méthode de requête est POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $post_content = $_POST['post_content'];

    // Préparer une requête SQL pour insérer une nouvelle publication
    $stmt = $conn->prepare("INSERT INTO publication (contenu, date, id_compte) VALUES (:contenu, NOW(), :id_compte)");
    
    // Exécuter la requête en liant les valeurs de contenu et d'identifiant de compte
    $stmt->execute(['contenu' => $post_content, 'id_compte' => $user_id]);

    // Récupérer l'ID de la dernière insertion
    $lastInsertId = $conn->lastInsertId();

    // Préparer une requête pour récupérer les détails de la dernière insertion
    $stmtSelect = $conn->prepare("SELECT * FROM publication WHERE id = :id");
    $stmtSelect->execute(['id' => $lastInsertId]);

    // Récupérer le résultat
    $publication = $stmtSelect->fetch(PDO::FETCH_ASSOC);

    // Récupérer les détails du compte de l'utilisateur qui a publié
    $stmtSelect = $conn->prepare("SELECT * FROM compte WHERE id = :id");
    $stmtSelect->execute(['id' => $publication['id_compte']]);
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

    // Envoyer une réponse de succès
    echo json_encode(['status' => 'success', 'data' => $data]);
} else {
    // Envoyer une réponse d'erreur pour les requêtes non-POST
    echo json_encode(['status' => 'error', 'message' => 'Méthode de requête invalide']);
}
?>
