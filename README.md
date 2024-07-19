# Explanation of the refactor I made:

On class/ folder: 

- Abstract Base Class: The AbstractBaseEntity (AbstractBaseEntity.php) class contains common properties (id, body, createdAt) and their respective getter and setter methods.

- Inheritance: Both Comment and News classes extend the AbstractBaseEntity, inheriting the common properties and methods. Each class then adds its specific properties and methods.

- This pattern reduces code duplication and centralizes the common functionality, making the code more maintainable and easier to extend in the future.

On utils/ folder and index.php:

1. Dependency Injection:
    - I created a single instance of the `DB` class and pass this database connection instance to both `CommentManager` and `NewsManager`. This ensures that both managers use the same database connection, promoting consistency and reducing the risk of connection issues.
    - Dependency injection also makes the code more testable by allowing us to pass mock objects for unit testing.

2. Singleton Pattern:
    - The `getInstance` method in both `CommentManager` and `NewsManager` ensures that only one instance of each manager is created. This pattern helps in managing resources efficiently and ensures a single point of access to each manager.

3. Separation of Concerns:
    - By passing the `DB` instance and `CommentManager` to the `NewsManager`, we separate the responsibilities of managing news and comments. This makes the codebase more modular and easier to maintain.
    - The `DB` class is responsible solely for database connections and queries, while `NewsManager` and `CommentManager` handle their respective entities.

4. Encapsulation:
    - The database connection details are encapsulated within the `DB` class, and the `getConnection` method provides a clean interface for accessing the PDO instance.
    - The `CommentManager` and `NewsManager` classes encapsulate the logic for handling comments and news, respectively. This separation makes the code more organized and easier to understand.

5. Modularity:
    - Each class has a clear, distinct responsibility. The `DB` class manages the database connection, `CommentManager` handles operations related to comments, and `NewsManager` deals with news-related operations. This modularity improves code readability and maintainability.

6. Improved Maintainability:
    - By using design patterns such as Singleton and Dependency Injection, the code becomes more maintainable. Changes to the database connection logic or the way managers are instantiated can be made in one place, reducing the likelihood of introducing bugs.

This refactor enhances the overall structure of the code, making it more robust, testable, and maintainable.

To improve the index.php file, we can use Dependency Injection to pass the DB instance to the NewsManager and CommentManager This approach ensures better modularity and testability. 

# PHP test

## 1. Installation

  - create an empty database named "phptest" on your MySQL server
  - import the dbdump.sql in the "phptest" database
  - put your MySQL server credentials in the constructor of DB class
  - you can test the demo script in your shell: "php index.php"

## 2. Expectations

This simple application works, but with very old-style monolithic codebase, so do anything you want with it, to make it:

  - easier to work with
  - more maintainable