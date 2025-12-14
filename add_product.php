<?php
/**
 * Add Product Page
 * Form to add new products with validation
 */

require_once 'db.php';

// Require login to access this page
requireLogin();

$error = '';
$success = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name = trim($_POST['product_name'] ?? '');
    $quantity = trim($_POST['quantity'] ?? '');
    $price = trim($_POST['price'] ?? '');
    
    // Form validation: Check for empty fields
    if (empty($product_name) || empty($quantity) || empty($price)) {
        $error = "Please fill in all fields.";
    } 
    // Validate quantity is numeric
    elseif (!is_numeric($quantity) || $quantity < 0) {
        $error = "Quantity must be a valid positive number.";
    }
    // Validate price is numeric
    elseif (!is_numeric($price) || $price < 0) {
        $error = "Price must be a valid positive number.";
    }
    else {
        try {
            $pdo = getDB();
            
            // Use prepared statement with named placeholders
            $stmt = $pdo->prepare("INSERT INTO products (product_name, quantity, price) VALUES (:product_name, :quantity, :price)");
            
            // Bind parameters using bindValue
            $stmt->bindValue(':product_name', $product_name, PDO::PARAM_STR);
            $stmt->bindValue(':quantity', (int)$quantity, PDO::PARAM_INT);
            $stmt->bindValue(':price', (float)$price, PDO::PARAM_STR);
            
            $stmt->execute();
            
            $success = "Product added successfully!";
            
            // Clear form fields
            $product_name = '';
            $quantity = '';
            $price = '';
        } catch (PDOException $e) {
            $error = "Failed to add product. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Inventory Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Add Product</h1>
            <div class="user-info">
                <a href="dashboard.php" class="btn btn-secondary">Dashboard</a>
                <a href="products.php" class="btn btn-secondary">View Products</a>
                <a href="logout.php" class="btn btn-secondary">Logout</a>
            </div>
        </div>
        
        <div class="content">
            <div class="form-wrapper">
                <h2>Add New Product</h2>
                
                <?php if ($error): ?>
                    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <form method="POST" action="add_product.php">
                    <div class="form-group">
                        <label for="product_name">Product Name:</label>
                        <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product_name ?? ''); ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($quantity ?? ''); ?>" min="0" step="1" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($price ?? ''); ?>" min="0" step="0.01" required>
                    </div>
                    
                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">Add Product</button>
                        <a href="products.php" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

