<?php
// Function to sanitize user input
function sanitizeInput($input)
{
    return htmlspecialchars(trim($input));
}

// Function to validate email format
function isValidEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Function to validate username format (alphanumeric and underscores only)
function isValidUsername($username)
{
    return preg_match('/^[a-zA-Z0-9_]+$/', $username);
}

// Function to generate hashed password
function generateHash($password)
{
    return password_hash($password, PASSWORD_DEFAULT);
}

// Function to verify hashed password
function verifyHash($password, $hash)
{
    return password_verify($password, $hash);
}

// Function to start session
function startSession()
{
    session_start();
}

// Function to set session variables
function setSession($key, $value)
{
    $_SESSION[$key] = $value;
}

// Function to get session variable
function getSession($key)
{
    return $_SESSION[$key] ?? null;
}

// Function to check if user is logged in
function isLoggedIn()
{
    return isset($_SESSION['user_id']);
}

// Function to redirect to a specific page
function redirectTo($page)
{
    header("Location: $page");
    exit;
}
