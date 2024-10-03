<?php
    // Initialiser un tableau pour stocker les réactions
    $reaction_counts = [];
    // Préparer une requête pour récupérer les réactions du commentaire
    $reaction_stmt = $conn->prepare("SELECT type, COUNT(*) AS count 
                                    FROM reaction_commentaire 
                                    WHERE id_commentaire = :comment_id 
                                    GROUP BY type");
    $reaction_stmt->bindParam(':comment_id', $comment_row['id_commentaire']);
    $reaction_stmt->execute();

    // Remplir le tableau avec les comptes de chaque type de réaction
    while ($row = $reaction_stmt->fetch(PDO::FETCH_ASSOC)) {
        $reaction_counts[$row['type']] = $row['count'];
    }

    // Afficher les boutons de réaction
    echo "<div class='flex justify-center space-x-6 mt-3'>";
    foreach (['like', 'love', 'haha', 'sad', 'angry'] as $reaction) {
        $count = isset($reaction_counts[$reaction]) ? $reaction_counts[$reaction] : 0;
        echo "<button onclick=\"reactToComms({$comment_row['id_commentaire']}, '{$reaction}')\" class='bg-gray-300 p-1 rounded hover:bg-gray-400'>{$reaction} ({$count})</button>";
    }
    echo "</div>";
?>