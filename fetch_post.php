<?php
// Afficher les informations de la publication
echo "<p><b>{$posted_by}</b></p>"; 
echo "<p class='text-sm text-gray-400'>{$post_row['date']}</p>";

// Conteneur pour le contenu de la publication
echo "<div class='bg-blue-500 px-2 text-sm text-white py-6 rounded'>";
echo "<p class='text-center'>{$post_row['contenu']}</p>";
echo "</div>";
?>
