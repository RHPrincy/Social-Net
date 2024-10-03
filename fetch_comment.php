<?php
// Afficher les informations du commentaire
    echo "<p><b>" . htmlspecialchars($comment_row['nom'] . " " . $comment_row['prenom']) . "</b></p>";
    echo "<p class='text-sm text-gray-400'>{$comment_row['date']}</p>";
    echo "<p>{$comment_row['contenu']}</p>";
?>
