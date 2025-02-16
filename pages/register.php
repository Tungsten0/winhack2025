<?php
// Include database connection
include 'config/db_connection.php';

// Handle registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['register'])) {
    // Get and sanitize input for registration
    $username = filter_var(trim($_POST['username']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['pass']);

    if (!empty($username) && !empty($email) && !empty($password)) {
        $query = "SELECT * FROM users WHERE email = ? OR username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $email, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $error_message = "Email or Username already taken.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            $insert_query = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $insert_stmt = $conn->prepare($insert_query);
            $insert_stmt->bind_param('sss', $username, $email, $hashed_password);

            if ($insert_stmt->execute()) {
                // Set cookies for successful registration and login
                setcookie('login', true, time() + (86400 * 30), '/');
                setcookie('page', 'main', time() + (86400 * 30), '/');
                header('Location: index.php'); // Redirect to the main page
                exit();
            } else {
                $error_message = "Error: " . $conn->error;
            }
        }
    } else {
        $error_message = "Please fill in all fields.";
    }
}
?>

<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="images/img-01.png" alt="IMG">
				</div>

				<form class="login100-form validate-form" action="php/register.php" method="POST">
        <span class="login100-form-title">
						Welcome to StudyBunny
					</span>
					<span class="login100-form-title">
						Register
					</span>

          <div class="wrap-input100 validate-input" data-validate = "Please enter a valid username">
						<input class="input100" type="text" name="username" placeholder="username">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate = "Password is required">
						<input class="input100" type="password" name="pass" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>
					
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Sign Up
						</button>
					</div>

          <?php if (isset($error_message)) { echo "<p class='error'>$error_message</p>"; } ?>

					<div class="text-center p-t-12">
						<span class="txt1">
							Forgot
						</span>
						<a class="txt2" href="#">
							Username / Password?
						</a>
					</div>

					<div class="text-center p-t-136">
          <a class="txt2" href="#" onclick="setPageCookie('login');">
            Login
            <i class="fa fa-long-arrow-right m-l-5" aria-hidden="true"></i>
          </a>
					</div>
				</form>
			</div>
		</div>