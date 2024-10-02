<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HOME</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="./output.css" rel="stylesheet">
    <?php include('config.php'); // Include database connection ?>
    <?php include('session.php'); // Include session handling ?>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="container mx-auto px-4 py-6">
        <div class="text-center mb-4 p-5 bg-gray-500">
            <p class="text-lg text-white">
                WELCOME! <?php echo htmlspecialchars($utilisateur); ?>
                <a href="logout.php" class="text-blue-500 hover:underline px-6"><button class="bg-blue-500 text-white py-1 px-3 rounded">Log Out</button></a>
            </p>
        </div>
        
        <form id="postForm" class="m-4 text-center">
            <textarea name="post_content" rows="4" placeholder="Publication" required class="w-full p-2 border border-gray-300 rounded-md"></textarea>
            <button type="submit" class="mt-2 bg-blue-500 text-white py-2 px-4 rounded">Partager la publication</button>
        </form>

        <div id="postsContainer"></div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Charge les publications au chargement de la page
            loadPosts(); 

            // AJAX pour publier une nouvelle publication
            document.getElementById('postForm').addEventListener('submit', function(event) {
                // Empêche le rechargement de la page
                event.preventDefault();

                var formData = new FormData(this);
                fetch('post.php', { // Script pour gérer la publication
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json(); // Assuming the server responds with JSON
                })
                .then(data => {
                const postContainer = document?.getElementById('postsContainer')
                console.log(postContainer);
                loadPosts();            
                })
                .catch(error => {
                console.error('Error:', error); // Handle any errors
                }); 
            });
        });

        // Fonction pour charger les publications
        function loadPosts() {
            fetch('fetch_posts.php') // Script pour récupérer les publications
                .then(response => response.text())
                .then(data => {
                    document.getElementById('postsContainer').innerHTML = data;
                });
        }

        // Fonction pour commenter une publication
        function postComment(postId, commentContent) {
            fetch('comment.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ post_id: postId, content: commentContent })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadPosts(); // Recharge les publications après le commentaire
                }
            });
        }

        // Fonction pour gérer les réactions
        function reactToPost(postId, reactionType) {
            fetch('reaction.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ post_id: postId, reaction_type: reactionType })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    loadPosts(); // Recharge les publications après la réaction
                }
            });
        }

        // Fonction pour afficher ou masquer le formulaire de réaction
        function showReactionForm(id, type) {
            var formId = type === "publication" ? 'reaction_form_publication_' + id : 'reaction_form_commentaire_' + id;
            var form = document.getElementById(formId);
            form.classList.toggle('hidden');
        }
    </script>
</body>
</html>
