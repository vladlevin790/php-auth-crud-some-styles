<?php

use src\classes\Post;

require_once "./src/classes/Post.php";

session_start();

$user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;

$newPostTitle = $_POST['new_post_title'] ?? '';
$newPostContent = $_POST['new_post_content'] ?? '';

if (!empty($newPostTitle) && !empty($newPostContent)) {
    $newPost = new Post($newPostTitle, $newPostContent, $user_id);
    $newPost->createPost();

    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

$updatePostTitle = $_POST['update_post_title'] ?? '';
$updatePostContent = $_POST['update_post_content'] ?? '';
$updatePostId = $_POST['update_post_id'] ?? '';

if (!empty($updatePostTitle) && !empty($updatePostContent) && !empty($updatePostId)) {
    $updatedPost = new Post($updatePostTitle, $updatePostContent, $user_id);
    $updatedPost->updatePost($updatePostId, $updatePostTitle, $updatePostContent);

    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $postIdToDelete = (int)$_GET['id'];
    $postToDelete = new Post("", "", $user_id);
    $postToDelete->deletePost($postIdToDelete);

    header("Location: {$_SERVER['PHP_SELF']}");
    exit();
}

$post = $user_id !== null ? new Post("", "", $user_id) : null;

$posts = $post ? $post->readPosts() : [];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <link href="./src/styles/main-page-styles.css" rel="stylesheet">
</head>
<body>
<header>
    <a href="quit.php">Выйти</a>
    <a href="index.php">Профиль</a>
</header>
<main>
<?php foreach ($posts as $post): ?>
    <article class="post">
        <h2><?= $post['title']; ?></h2>
        <p><?= $post['content']; ?></p>
        <?php if ($user_id == $post['user_id']): ?>
            <p class="editable">
                <button onclick="openModal('editModal<?= $post['id']; ?>')">Edit</button>
                <a href="?action=delete&id=<?= $post['id']; ?>">Delete</a>
            </p>
        <?php endif; ?>

    </article>

    <article id="editModal<?= $post['id']; ?>" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('editModal<?= $post['id']; ?>')">&times;</span>
            <form method="post" action="" class="edit-info-form">
                <label for="update_post_id">Post ID:</label>
                <input type="text" id="update_post_id" name="update_post_id" value="<?= $post['id']; ?>" readonly>
                <br>
                <label for="update_post_title">Title:</label>
                <input type="text" id="update_post_title" name="update_post_title" value="<?= $post['title']; ?>" required>
                <br>
                <label for="update_post_content">Content:</label>
                <textarea id="update_post_content" name="update_post_content" required><?= $post['content']; ?></textarea>
                <br>
                <input type="submit" value="Update Post">
            </form>
        </div>
    </article>
<?php endforeach; ?>

<form method="post" action="" class="new-post-form">
    <h2>Add New Post</h2>
    <label for="new_post_title">Title:</label>
    <input type="text" id="new_post_title" name="new_post_title" required>
    <br>
    <label for="new_post_content">Content:</label>
    <textarea id="new_post_content" name="new_post_content" required></textarea>
    <br>
    <input type="submit" value="Add Post">
</form>
</main>
<script>
    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
</script>
</body>
</html>
