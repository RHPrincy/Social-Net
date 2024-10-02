<?php
echo "<div class='mt-2 bg-gray-100 p-2 rounded'>";
echo "<p><b>" . htmlspecialchars($comment_row['nom'] . " " . $comment_row['prenom']) . "</b></p>";
echo "<p class='text-sm text-gray-400'>{$comment_row['date']}</p>";
echo "<p>{$comment_row['contenu']}</p>";
echo "</div>";
?>
