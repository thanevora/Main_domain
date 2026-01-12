<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit;
}

// Get role from session
$session_role = $_SESSION['role'];
$permissions = include 'role_permissions.php';
$allowed_modules = $permissions[$session_role] ?? [];

// For all roles, redirect to FRONT_DASHBOARD.PHP only
header("Location: ../FRONT_DASHBOARD.PHP");
exit;