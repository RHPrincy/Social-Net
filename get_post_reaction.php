<?php
    echo "<div class='mt-2 text-center'>";
    // echo "<button onclick='showReactionForm({$post_row['post_id']}, \"publication\")' class='bg-blue-500 px-2 rounded text-white'>Réagir</button>";
    // Masque le formulaire par défaut
    echo "<div id='reaction_form_publication_{$post_row['post_id']}' class='mt-2 hidden'>";
        echo "<form method='post' action='reaction.php' class='flex justify-center items-center'>";
            // ID de la publication
            echo "<input type='hidden' name='post_id' value='{$post_row['post_id']}'>"; 
            echo "<select name='reaction_type' class='border border-gray-300 rounded-md p-1' required>";
                echo "<option value=''>Choisir une réaction</option>";
                // Remplit le menu déroulant avec les types de réactions
                foreach (['like', 'love', 'haha', 'angry', 'wow', 'sad'] as $reaction) {
                    // ucfirst() en sert à convertir la première lettre d'une chaîne de caractères en majuscule, tout en laissant les autres lettres inchangée
                    echo "<option value='{$reaction}'>" . ucfirst($reaction) . "</option>";
                }
            echo "</select>";
            echo "<button type='submit' class='ml-2 bg-blue-500 text-white py-1 px-3 rounded'>Réagir</button>";
        echo "</form>";
    echo "</div>";
    echo "</div>";
?>