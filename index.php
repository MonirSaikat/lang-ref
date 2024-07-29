<?php

$functions = get_defined_functions();
$dsn = 'mysql:host=localhost;dbname=my22';
$username = 'root';
$password = '';

try {
  $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
  echo 'Connection failed: ' . $e->getMessage();
}

// Truncate the table before inserting new data
$stmt = $pdo->prepare("TRUNCATE TABLE php_functions");
$stmt->execute();

$stmt = $pdo->prepare("INSERT INTO php_functions (name, params, return_type) VALUES (:name, :params, :return_type)");

// Sort the functions array by name in alphabetical order
$all_functions = array_merge($functions['user'], $functions['internal']);
sort($all_functions);

foreach ($all_functions as $function) {
  $reflection = new ReflectionFunction($function);
  $params_array = array();
  foreach ($reflection->getParameters() as $param) {
    $params_array[] = $param->getName();
  }
  $params = implode(', ', $params_array);
  $return_type = $reflection->getReturnType();
  $name = $function;

  $stmt->bindParam(':name', $name);
  $stmt->bindParam(':params', $params);
  $stmt->bindParam(':return_type', $return_type);
  $stmt->execute();
}

$stmt->closeCursor();
$pdo = null;
