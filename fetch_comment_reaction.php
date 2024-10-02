<?php
$reaction_counts = [];
$reaction_stmt = $conn->prepare("SELECT type, COUNT(*) AS count FROM reaction_commentaire WHERE id_commentaire = :comment_id GROUP BY type");
$reaction_stmt->bindParam(':comment_id', $comment_row['id_commentaire']);
$reaction_stmt->execute();

while ($row = $reaction_stmt->fetch(PDO::FETCH_ASSOC)) {
    $reaction_counts[$row['type']] = $row['count'];
}

echo "<div class='flex justify-center space-x-6 mt-3'>";
foreach (['like', 'love', 'haha', 'sad', 'angry'] as $reaction) {
    $count = isset($reaction_counts[$reaction]) ? $reaction_counts[$reaction] : 0;
    echo "<button onclick=\"reactToPost({$comment_row['id_commentaire']}, '{$reaction}')\" class='bg-gray-300 p-1 rounded'>{$reaction} ({$count})</button>";
}
echo "</div>";
?>
