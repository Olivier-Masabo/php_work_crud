<?php
/**
 * Dashboard Page
 * Main page after login - shows navigation to product management
 */

require_once 'db.php';

// Require login to access this page
requireLogin();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Inventory Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Inventory Management System</h1>
            <div class="user-info">
                <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                <a href="logout.php" class="btn btn-secondary">Logout</a>
            </div>
        </div>
        
        <div class="dashboard-content">
            <h2>Dashboard</h2>
            
            <div class="menu-cards">
                <div class="card">
                    <h3>Products</h3>
                    <p>Manage your inventory products</p>
                    <a href="products.php" class="btn btn-primary">View Products</a>
                </div>
                
                <div class="card">
                    <h3>Add Product</h3>
                    <p>Add a new product to inventory</p>
                    <a href="add_product.php" class="btn btn-primary">Add New Product</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

