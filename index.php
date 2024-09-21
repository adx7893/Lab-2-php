<?php
// Start the session to store book entries
session_start();

// Book class definition
class Book {
    private $title;
    private $author;
    private $year;

    public function __construct($title, $author, $year) {
        $this->setTitle($title);
        $this->setAuthor($author);
        $this->setYear($year);
    }

    public function setTitle($title) {
        if (empty($title)) {
            throw new Exception("Title cannot be empty.");
        }
        $this->title = htmlspecialchars($title);
    }

    public function setAuthor($author) {
        if (empty($author)) {
            throw new Exception("Author cannot be empty.");
        }
        $this->author = htmlspecialchars($author);
    }

    public function setYear($year) {
        if (!is_numeric($year) || $year <= 0) {
            throw new Exception("Year must be a valid positive number.");
        }
        $this->year = htmlspecialchars($year);
    }

    public function getTitle() {
        return $this->title;
    }

    public function getAuthor() {
        return $this->author;
    }

    public function getYear() {
        return $this->year;
    }
}

// Handling form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $book = new Book($_POST['title'], $_POST['author'], $_POST['year']);
        
        if (!isset($_SESSION['books'])) {
            $_SESSION['books'] = []; // Initialize if not already set
        }

        $_SESSION['books'][] = $book; // Store the book object in session

        $_SESSION['success'] = "Book successfully added!";
        header("Location: book.php");
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: book.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Info System</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f9f9f9;
        }
        h1 {
            color: #333;
        }
        .container {
            max-width: 500px; /* Limit width for better layout */
            margin: auto; /* Center the container */
            padding: 20px;
            background-color: #fff;
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
        input[type="text"],
        input[type="number"] {
            width: 96%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 100%; /* Full width button */
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
        }
        .error, .success {
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
        .error {
            color: red;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
        }
        .success {
            color: green;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            text-align: center;
            padding: 10px;
            border-radius: 4px;
            cursor: pointer;
            width: 96%; /* Full width button */
        }
        a:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Book Info System</h1>

        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <form action="" method="post">
            <label for="title">Book Title:</label>
            <input type="text" name="title" id="title" required>

            <label for="author">Author:</label>
            <input type="text" name="author" id="author" required>

            <label for="year">Publication Year:</label>
            <input type="number" name="year" id="year" required>

            <input type="submit" value="Submit">
        </form>

        <a href="book.php">View Submitted Books</a>
    </div>
</body>
</html>