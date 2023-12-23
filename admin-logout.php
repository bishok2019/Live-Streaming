<?php
session_start(); // Start the session if not already started

// Destroy the session
session_destroy();

// Redirect the user to the login page or any other desired page
header("Location: adminvalidation.php");
exit;
?>
