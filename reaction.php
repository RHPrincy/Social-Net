<?php
include("config.php"); 
include("session.php");

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['reaction_type'])) {
    $reaction_type = $input['reaction_type'];

    if (isset($input['post_id'])) {
        $post_id = $input['post_id'];
        $stmt = $conn->prepare("INSERT INTO reaction_publication (id_publication, id_compte, type) VALUES (:post_id, :user_id, :reaction_type) ON DUPLICATE KEY UPDATE type = :reaction_type");
        $stmt->bindParam(':post_id', $post_id);
    } elseif (isset($input['comment_id'])) {
        $comment_id = $input['comment_id'];
        $stmt = $conn->prepare("INSERT INTO reaction_commentaire (id_commentaire, id_compte, type) VALUES (:comment_id, :user_id, :reaction_type) ON DUPLICATE KEY UPDATE type = :reaction_type");
        $stmt->bindParam(':comment_id', $comment_id);
    }

    if ($stmt) {
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':reaction_type', $reaction_type);
        $stmt->execute();

        echo json_encode(['success' => true]);
        exit();
    }
}
?>
