<?php
include("config.php"); 
include("session.php"); 

$input = json_decode(file_get_contents('php://input'), true);

if (isset($input['content'])) {
    $comment = $input['content'];
    $post_id = $input['post_id'];

    $stmt = $conn->prepare("INSERT INTO comments (contenu, id_compte, id_publication, date) VALUES (:contenu, :id_compte, :id_publication, NOW())");
    $stmt->execute(['contenu' => $comment, 'id_compte' => $user_id, 'id_publication' => $post_id]);
    
    echo json_encode(['success' => true]);
    exit();
}
?>
