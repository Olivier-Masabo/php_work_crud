<?php
/**
 * Products Page
 * Displays all products with edit and delete options
 */

require_once 'db.php';

// Require login to access this page
requireLogin();

$products = [];
$error = '';
$success = '';

// Check for success/error messages from URL parameters
if (isset($_GET['success']) && $_GET['success'] === 'deleted') {
    $success = "Product deleted successfully!";
}
if (isset($_GET['error'])) {
    $error = htmlspecialchars($_GET['error']);
}

try {
    $pdo = getDB();
    
    // Use prepared statement to fetch all products
    $stmt = $pdo->prepare("SELECT id, product_name, quantity, price FROM products ORDER BY id DESC");
    $stmt->execute();
    
    $products = $stmt->fetchAll();
} catch (PDOException $e) {
    $error = "Failed to load products. Please try again.";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Inventory Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Products Management</h1>
            <div class="user-info">
                <a href="dashboard.php" class="btn btn-secondary">Dashboard</a>
                <a href="logout.php" class="btn btn-secondary">Logout</a>
            </div>
        </div>
        
        <div class="content">
            <div class="page-header">
                <h2>All Products</h2>
                <a href="add_product.php" class="btn btn-primary">Add New Product</a>
            </div>
            
            <?php if ($error): ?>
                <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <?php if ($success): ?>
                <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
            <?php endif; ?>
            
            <?php if (empty($products)): ?>
                <div class="info-message">No products found. <a href="add_product.php">Add your first product</a></div>
            <?php else: ?>
                <table class="products-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($product['id']); ?></td>
                                <td><?php echo htmlspecialchars($product['product_name']); ?></td>
                                <td><?php echo htmlspecialchars($product['quantity']); ?></td>
                                <td>$<?php echo number_format($product['price'], 2); ?></td>
                                <td class="actions">
                                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="btn btn-small btn-edit">Edit</a>
                                    <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="btn btn-small btn-delete">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

