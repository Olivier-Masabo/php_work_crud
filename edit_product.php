<?php
/**
 * Edit Product Page
 * Form to edit existing products with validation
 */

require_once 'db.php';

// Require login to access this page
requireLogin();

$error = '';
$success = '';
$product = null;

// Get product ID from URL
$product_id = $_GET['id'] ?? 0;

// Validate product ID
if (empty($product_id) || !is_numeric($product_id)) {
    header("Location: products.php");
    exit();
}

try {
    $pdo = getDB();
    
    // Fetch product using prepared statement
    $stmt = $pdo->prepare("SELECT id, product_name, quantity, price FROM products WHERE id = :id");
    $stmt->bindParam(':id', $product_id, PDO::PARAM_INT);
    $stmt->execute();
    
    $product = $stmt->fetch();
    
    // If product not found, redirect
    if (!$product) {
        header("Location: products.php");
        exit();
    }
} catch (PDOException $e) {
    $error = "Failed to load product. Please try again.";
}

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
            $stmt = $pdo->prepare("UPDATE products SET product_name = :product_name, quantity = :quantity, price = :price WHERE id = :id");
            
            // Bind parameters using bindValue
            $stmt->bindValue(':product_name', $product_name, PDO::PARAM_STR);
            $stmt->bindValue(':quantity', (int)$quantity, PDO::PARAM_INT);
            $stmt->bindValue(':price', (float)$price, PDO::PARAM_STR);
            $stmt->bindValue(':id', $product_id, PDO::PARAM_INT);
            
            $stmt->execute();
            
            $success = "Product updated successfully!";
            
            // Update product array to reflect changes
            $product['product_name'] = $product_name;
            $product['quantity'] = $quantity;
            $product['price'] = $price;
        } catch (PDOException $e) {
            $error = "Failed to update product. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - Inventory Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Edit Product</h1>
            <div class="user-info">
                <a href="dashboard.php" class="btn btn-secondary">Dashboard</a>
                <a href="products.php" class="btn btn-secondary">View Products</a>
                <a href="logout.php" class="btn btn-secondary">Logout</a>
            </div>
        </div>
        
        <div class="content">
            <div class="form-wrapper">
                <h2>Edit Product</h2>
                
                <?php if ($error): ?>
                    <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="success-message"><?php echo htmlspecialchars($success); ?></div>
                <?php endif; ?>
                
                <?php if ($product): ?>
                    <form method="POST" action="edit_product.php?id=<?php echo $product['id']; ?>">
                        <div class="form-group">
                            <label for="product_name">Product Name:</label>
                            <input type="text" id="product_name" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="quantity">Quantity:</label>
                            <input type="number" id="quantity" name="quantity" value="<?php echo htmlspecialchars($product['quantity']); ?>" min="0" step="1" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="number" id="price" name="price" value="<?php echo htmlspecialchars($product['price']); ?>" min="0" step="0.01" required>
                        </div>
                        
                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Update Product</button>
                            <a href="products.php" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>

