<?php
// Start the session
session_start();

// Include your database connection
include '../config/db_connection.php';

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get and sanitize input
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['pass']);

    // Check if input is not empty
    if (!empty($email) && !empty($password)) {
        // Prepare and execute the query
        $query = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the user exists
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set login cookie
                setcookie('login', true, time() + (86400 * 30), '/'); // 30 days
                setcookie('page', 'main', time() + (86400 * 30), '/');
                // Redirect to the main page
                header('Location: ../index.php');
                exit();
            } else {
                // Invalid password
                echo "Invalid email or password.";
            }
        } else {
            // User not found
            echo "Invalid email or password.";
        }
    } else {
        echo "Please fill in all fields.";
    }
} else {
    // If not a POST request, redirect to index.php
    header('Location: ../index.php');
    exit();
}

