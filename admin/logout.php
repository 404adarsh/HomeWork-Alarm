<?php
// Destroy all sessions
session_start();
session_destroy();

// Unset all cookies
foreach ($_COOKIE as $key => $value) {
    setcookie($key, '', time() - 3600, '/'); // Setting a past time deletes the cookie
    unset($_COOKIE[$key]);
}

// Redirect to a page after destroying sessions and unsetting cookies
header("Location: ../index.php");
exit();
?>
