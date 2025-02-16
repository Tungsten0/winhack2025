<?php
// Start the session
session_start();

// Include your database connection
include '../config/db_connection.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize input
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['pass']);

    // Check if input is not empty
    if (!empty($username) && !empty($email) && !empty($password)) {
        // Check if email or username already exists
        $query = "SELECT * FROM users WHERE email = ? OR username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email or username already exists
            echo "Email or Username already taken.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user into the database
            $insert_query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param('sss', $username, $email, $hashed_password);

            if ($insert_stmt->execute()) {
                // Registration successful, set login cookie and redirect
                setcookie('login', true, time() + (86400 * 30), '/'); // 30 days
                setcookie('page', 'main', time() + (86400 * 30), '/');
                header('Location: ../index.php');
                exit();
            } else {
                echo "Error: " . $conn->error;
            }
        }
    } else {
        echo "Please fill in all fields.";
    }
} else {
    // If not a POST request, redirect to index.php
    header('Location: ../index.php');
    exit();
}
?>
