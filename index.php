<?php 
session_start();
$is_logged_in = isset($_COOKIE['login']) && $_COOKIE['login'] == true;

$page = isset($_COOKIE['page']) ? $_COOKIE['page'] : 'main';

// If not logged in, force to login page
if (!$is_logged_in) {
	if ($page !== 'register') {
			$page = 'login';
	}
} else {
	// If logged in, only allow main or error pages
	if ($page !== 'main') {
			$page = 'error';
	}
}

// Clear the page cookie after reading it to prevent caching issues
setcookie('page', '', time() - 3600, '/');
?>

<!DOCTYPE html>
<html lang="en">
<?php include 'components/head.php'; ?>
<body>

<div class="limiter" style="background: #9053c7;
  background: -webkit-linear-gradient(-135deg, #c850c0, #4158d0);
  background: -o-linear-gradient(-135deg, #c850c0, #4158d0);
  background: -moz-linear-gradient(-135deg, #c850c0, #4158d0);
  background: linear-gradient(-135deg, #c850c0, #4158d0);">
		<?php
				// Load content based on the page parameter
				if ($page == 'login') {	// Render the login form
					?><div class="container-login100"> <?php
					include 'pages/login.php';
					?></div> <?php
				} elseif ($page == 'register') {	// Render the register form
					?><div class="container-login100"> <?php
					include 'pages/register.php';
					?></div> <?php
				}elseif ($page == 'main') {	// Render the main page
					include 'pages/main.php';
				} else {	// Render the error page for unknown routes
					include 'pages/error.php';
				}
				?>
	</div>
	
<?php include 'components/include_scripts.php'; ?>

</body>
</html>