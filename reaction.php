<?php
include("config.php"); 
include("session.php");

// Lire les données JSON envoyées
$input = json_decode(file_get_contents('php://input'), true);

// Vérifier si le type de réaction est défini
if (isset($input['reaction_type'])) {
    $reaction_type = $input['reaction_type'];

    // Vérifier si la réaction concerne une publication ou un commentaire
    if (isset($input['post_id'])) {
        $post_id = $input['post_id'];
        // Préparer une requête pour insérer ou mettre à jour la réaction de publication
        $stmt = $conn->prepare("INSERT INTO reaction_publication (id_publication, id_compte, type) 
                                 VALUES (:post_id, :user_id, :reaction_type) 
                                 ON DUPLICATE KEY UPDATE type = :reaction_type");
        $stmt->bindParam(':post_id', $post_id);
    } elseif (isset($input['comment_id'])) {
        $comment_id = $input['comment_id'];
        // Préparer une requête pour insérer ou mettre à jour la réaction de commentaire
        $stmt = $conn->prepare("INSERT INTO reaction_commentaire (id_commentaire, id_compte, type) 
                                 VALUES (:comment_id, :user_id, :reaction_type) 
                                 ON DUPLICATE KEY UPDATE type = :reaction_type");
        $stmt->bindParam(':comment_id', $comment_id);
    }

    // Exécuter la requête si elle est préparée
    if ($stmt) {
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':reaction_type', $reaction_type);
        $stmt->execute();

        echo json_encode(['success' => true]); // Envoyer une réponse de succès
        exit();
    }
}
?>
