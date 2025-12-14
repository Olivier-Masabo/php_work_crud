<?php
/**
 * Delete Product Page
 * Handles product deletion with exception handling
 */

require_once 'db.php';

// Require login to access this page
requireLogin();

$error = '';
$success = '';

// Get product ID from URL
$product_id = $_GET['id'] ?? 0;

// Validate product ID
if (empty($product_id) || !is_numeric($product_id)) {
    header("Location: products.php");
    exit();
}

// Handle deletion
try {
    $pdo = getDB();
    
    // Use prepared statement with named placeholder
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
    $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    
    // Check if any row was affected
    if ($stmt->rowCount() > 0) {
        $success = "Product deleted successfully!";
    } else {
        $error = "Product not found.";
    }
} catch (PDOException $e) {
    $error = "Failed to delete product. Please try again.";
}

// Redirect after a short delay or immediately
if ($success) {
    header("Location: products.php?success=deleted");
    exit();
} else {
    header("Location: products.php?error=" . urlencode($error));
    exit();
}

