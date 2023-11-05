<?php

namespace rtff\views;

namespace rtff\views;

class AdminView {

    /**
     * Displays a list of posts with the option to delete them.
     *
     * @param array $posts Array containing information about the posts.
     */
    public function showPosts(array $posts): void {
        ?>
        <h2>Manage Posts</h2>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li>
                    <strong><?= html_entity_decode(htmlspecialchars($post['title'] ?? '')) ?></strong>:
                    <?= html_entity_decode(htmlspecialchars($post['message'] ?? '')) ?>
                    <a href='/admin/delete-post?id=<?= htmlspecialchars($post['ticket_id']) ?>' style='color: red;'>Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
    }

    /**
     * Displays a list of users with the option to delete them.
     *
     * @param array $users Array containing information about the users.
     */
    public function showUsers(array $users): void {
        ?>
        <h2>Manage Users</h2>
        <ul>
            <?php foreach ($users as $user): ?>
                <li>
                    <strong><?= htmlspecialchars($user['display_name']) ?></strong> (ID: <?= htmlspecialchars($user['account_id']) ?>)
                    <a href='/admin/delete-user?id=<?= htmlspecialchars($user['account_id']) ?>' style='color: red;'>Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
    }

    /**
     * Displays a list of comments with the option to delete them.
     *
     * @param array $comments Array containing information about the comments.
     */
    public function showComments(array $comments): void {
        ?>
        <h2>Manage Comments</h2>
        <ul>
            <?php foreach ($comments as $comment): ?>
                <li>
                    <strong><?= htmlspecialchars($comment['text']) ?></strong> (ID: <?= htmlspecialchars($comment['comment_id']) ?>)
                    <a href='/admin/delete-comment?id=<?= htmlspecialchars($comment['comment_id']) ?>' style='color: red;'>Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
        <?php
    }


    /**
     * Displays a form to create a new category and a list of existing categories.
     *
     * @param array $categories Array containing information about the categories.
     */
    public function showCategories(array $categories): void {
        ?>
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <title>Category Management</title>
        </head>
        <body>
        <h1>Category Management</h1>

        <!-- Form to create a new category -->
        <h2>Add a New Category</h2>
        <form method="post" action="/admin/create-category">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required><br>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea><br>
            <input type="submit" value="Add">
        </form>

        <!-- List of existing categories -->
        <h2>Existing Categories</h2>
        <ul>
            <?php foreach ($categories as $category): ?>
                <li>
                    <strong><?= htmlspecialchars($category['title']) ?></strong>: <?= htmlspecialchars($category['description']) ?>
                    <!-- Link to delete a category -->
                    <a href='/admin/delete-category?id=<?= htmlspecialchars($category['category_id']) ?>' style='color: red;'>Delete</a>
                </li>
            <?php endforeach; ?>
        </ul>
        </body>
        </html>
        <?php
    }
}
