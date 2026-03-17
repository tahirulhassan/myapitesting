<?php

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "myapitesting_post";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}

// Sirf POST request allow ho
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Safe way to get POST data
    $name = isset($_POST["name"]) ? trim($_POST["name"]) : "";
    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
    $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

    // Empty fields check
    if (empty($name) || empty($email) || empty($password)) {
        echo "All fields are required";
        exit();
    }

    // Prepared statement
    $sql = "INSERT INTO user (name, email, password) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt) {

        mysqli_stmt_bind_param($stmt, "sss", $name, $email, $password);

        if (mysqli_stmt_execute($stmt)) {
            echo "User inserted successfully";
        } else {
            echo "Insert error: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);

    } else {
        echo "Prepare failed: " . mysqli_error($conn);
    }

} else {
    echo "Invalid request method";
}

mysqli_close($conn);

?>