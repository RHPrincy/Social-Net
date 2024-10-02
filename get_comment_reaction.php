<?php
    // Formulaire de réaction pour le commentaire
    echo "<div class='mt-2 text-center border'>";
    echo "<button onclick='showReactionForm({$comment_row['id_commentaire']}, \"commentaire\")' class='bg-blue-500 px-2 rounded text-white'>Réagir</button>";
    
    echo "<div id='reaction_form_commentaire_{$comment_row['id_commentaire']}' class='mt-2 hidden'>";
        echo "<form method='post' action='reaction.php' class='flex justify-center items-center'>";
            echo "<input type='hidden' name='comment_id' value='{$comment_row['id_commentaire']}'>";
            echo "<select name='reaction_type' class='border border-gray-300 rounded-md p-1' required>";
                echo "<option value=''>Choisir une réaction</option>";
                // Remplit le menu déroulant avec les types de réactions
                foreach (['like', 'love', 'haha', 'angry', 'wow', 'sad'] as $reaction) {
                    echo "<option value='{$reaction}'>" . ucfirst($reaction) . "</option>";
                }
            echo "</select>";
            // Bouton pour soumettre le formulaire de réaction pour le commentaire
            echo "<button type='submit' class='ml-2 bg-blue-500 text-white py-1 px-3 rounded'>Réagir</button>";
        echo "</form>";
        echo "</div>";
    echo "</div>";
echo "</div>";
?>
