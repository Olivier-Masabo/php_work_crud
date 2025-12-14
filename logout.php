<?php
/**
 * Logout Page
 * Destroys session and redirects to login
 */

require_once 'db.php';

// Destroy session
session_destroy();

// Redirect to login page
header("Location: login.php");
exit();

