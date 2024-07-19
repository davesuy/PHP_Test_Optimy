<?php


define('ROOT', __DIR__);

require_once(ROOT . '/utils/DB.php');
require_once(ROOT . '/utils/NewsManager.php');
require_once(ROOT . '/utils/CommentManager.php');

// Get the DB instance
$db = DB::getInstance()->getConnection();

// Create instances of NewsManager and CommentManager
$commentManager = CommentManager::getInstance($db);
$newsManager = NewsManager::getInstance($db, $commentManager);

// List and display news and comments
foreach ($newsManager->listNews() as $news) {
    echo("############ NEWS " . $news->getTitle() . " ############\n");
    echo($news->getBody() . "\n");
    foreach ($commentManager->listComments() as $comment) {
        if ($comment->getNewsId() == $news->getId()) {
            echo("Comment " . $comment->getId() . " : " . $comment->getBody() . "\n");
        }
    }
}

// Example of listing comments
$comments = $commentManager->listComments();
/**

1. **Initialization**: The `DB::getInstance()` method is used to obtain a single instance of the database connection.

2. **Usage of Repositories**:
   - `NewsManager::getInstance($db)` and `CommentManager::getInstance($db)` are used to obtain singleton instances of the utils, passing the database connection (`$db`) to each instance.
   - The `listNews()` method of `NewsManager` retrieves all news items, and for each news item, it lists associated comments using the `listComments()` method of `CommentManager`.

3. **Separate Usage Example**:
   - Demonstrates how to separately use `CommentManager` to list comments without iterating through news items again.

### Notes:

- **Singleton Pattern**: Ensures that only one instance of `DB`, `NewsManager`, and `CommentManager` exists throughout the application.
- **Repository Pattern**: Encapsulates data access logic (`listNews()`, `listComments()`, `addComment()`, `addNews()`, etc.) within dedicated repository classes, promoting separation of concerns and enhancing maintainability.

By structuring your code in this manner, you adhere to best practices in PHP development, focusing on modularity and maintainability through design patterns. Adjust the `ROOT` constant and file paths (`require_once` statements) as necessary based on your project structure.
 *
 */