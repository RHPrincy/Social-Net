<?php
include("config.php"); 
include("session.php");

// Préparer une requête pour récupérer les publications avec les détails des utilisateurs
$stmt = $conn->prepare("SELECT publication.id AS post_id, publication.contenu, publication.date, compte.nom, compte.prenom 
                         FROM publication 
                         LEFT JOIN compte ON compte.id = publication.id_compte 
                         ORDER BY publication.date DESC");
$stmt->execute(); 
$posts = $stmt->fetchAll(PDO::FETCH_ASSOC); 

if ($posts) {
    foreach ($posts as $post_row) {
        $posted_by = htmlspecialchars($post_row['nom'] . " " . $post_row['prenom']);
        
        echo "<div class='bg-white shadow-md rounded-lg p-10 mb-4 mx-auto max-w-md'>";
            // Inclure le fichier pour afficher la publication
            include('fetch_post.php'); 
            include('fetch_post_reaction.php');
            // Inclure le fichier pour afficher le formulaire de commentaire
            include('post_comment.php');

            // Récupérer et afficher les commentaires associés à la publication
            $stmt = $conn->prepare("SELECT comments.id_commentaire, comments.contenu, comments.date, compte.nom, compte.prenom 
                                    FROM comments 
                                    LEFT JOIN compte ON compte.id = comments.id_compte 
                                    WHERE id_publication = {$post_row['post_id']} 
                                    ORDER BY comments.date DESC");
            $stmt->execute();
            $comments = $stmt->fetchAll(PDO::FETCH_ASSOC); 

            if ($comments) {
                echo "<div class='mt-4 border-t pt-4'>";
                    echo "<h4 class='font-semibold text-center'>Commentaires :</h4>";
                    foreach ($comments as $comment_row) {
                        echo "<div class='mt-2 bg-gray-100 p-2 rounded'>";
                            // Inclure le fichier pour afficher le commentaire
                            include('fetch_comment.php'); 
                            // Inclure le fichier pour afficher les réactions au commentaire
                            include('fetch_comment_reaction.php');
                        echo "</div>"; // Fin du conteneur de commentaire
                    }
                echo "</div>";
            }

        echo "</div>";
    }
} else {
    echo "<p class='text-center'>Aucune publication à afficher.</p>";
}
?>
