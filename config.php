<?php
// config.php
// Database configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'my22';

// Create a connection to the database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Search function
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM php_functions WHERE name LIKE '%$search%' OR params LIKE '%$search%'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<h2>Search Results:</h2>";
        echo "<ul>";
        while($row = $result->fetch_assoc()) {
            echo "<li><strong>" . $row["name"] . "</strong> (";
            echo implode(", ", explode(", ", $row["params"])) . ")</li>";
        }
        echo "</ul>";
    } else {
        echo "<h2>No results found.</h2>";
    }
}

// Close connection
$conn->close();
?>