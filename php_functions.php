<?php
// Database configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'my22';

// Create a connection to the database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

// Search function
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM php_functions WHERE name LIKE '%$search%' OR params LIKE '%$search%'";
    $result = $conn->query($sql);

    $functions = array();
    while($row = $result->fetch_assoc()) {
        $functions[] = array(
            'name'        => $row["name"],
            'return_type' => $row["return_type"],
            'params'      => explode(", ", $row["params"]),
            'summary'     => $row["summary"],
        );
    }

    echo json_encode($functions);
}

// Close connection
$conn->close();
?>