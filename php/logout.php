<?php
// Clear the login cookie and redirect to login
setcookie('login', '', time() - 3600, '/');
header('Location: index.php');
exit;
?>