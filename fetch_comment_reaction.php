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
    
        // Définir les emojis correspondants
        $emoji = '';
        switch ($reaction) {
            case 'like':
                $emoji = '👍'; // Pouce en l'air
                break;
            case 'love':
                $emoji = '❤️'; // Cœur
                break;
            case 'haha':
                $emoji = '😂'; // Rire
                break;
            case 'sad':
                $emoji = '😢'; // Triste
                break;
            case 'angry':
                $emoji = '😡'; // En colère
                break;
        }
    
        echo "<button onclick=\"reactToComms({$comment_row['id_commentaire']}, '{$reaction}')\" class='border rounded'>{$emoji} ({$count})</button>";
    }
    
    echo "</div>";
?>