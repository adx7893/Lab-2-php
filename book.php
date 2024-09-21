<?php
// Start the session to display messages
session_start();

// Function to reset books
if (isset($_POST['reset'])) {
    unset($_SESSION['books']); // Clear all books
    $_SESSION['success'] = "All books have been removed.";
    header("Location: book.php");
    exit();
}

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

    public static function displayBooks($books) {
        if (!empty($books)) {
            echo '<table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Publication Year</th>
                        </tr>
                    </thead>
                    <tbody>';
            foreach ($books as $book) {
                if ($book instanceof Book) {
                    echo "<tr>
                            <td>{$book->getTitle()}</td>
                            <td>{$book->getAuthor()}</td>
                            <td>{$book->getYear()}</td>
                          </tr>";
                }
            }
            echo '</tbody></table>';
        } else {
            echo "<p>No books submitted yet.</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        .container {
            max-width: 600px; /* Limit the width of the box */
            margin: auto; /* Center the container */
            padding: 20px;
            background-color: #fff;
            border-radius: 10px; /* Rounded corners */
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        a, button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }
        a {
            background-color: #28a745;
        }
        a:hover {
            background-color: #218838;
        }
        button {
            background-color: #dc3545; /* Red for reset button */
            margin-left: 10px;
        }
        button:hover {
            background-color: #c82333;
        }
        p {
            color: #666;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Submitted Books</h1>
        <?php if (isset($_SESSION['success'])): ?>
            <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
        <?php endif; ?>
        
        <?php
            if (isset($_SESSION['books'])) {
                Book::displayBooks($_SESSION['books']);
            } else {
                echo "<p>No books submitted yet.</p>";
            }
        ?>
        <form method="post" style="display: inline;">
            <button type="submit" name="reset">Reset All Data</button>
        </form>
        <a href="index.php">Submit Another Book</a>
    </div>
</body>
</html>