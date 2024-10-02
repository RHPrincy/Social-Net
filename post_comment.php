<form class="mt-4" onsubmit="event.preventDefault(); postComment(<?php echo $post_row['post_id']; ?>, this.comment.value); this.reset();">
    <input type="text" name="comment" placeholder="Ajouter un commentaire" required class="border rounded p-2 w-full" />
    <button type="submit" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded">Commenter</button>
</form>
