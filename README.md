# Simple Inventory Management System

A simple and secure PHP-based inventory management system for managing products with admin authentication.

##  Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Database Setup](#database-setup)
- [Configuration](#configuration)
- [Usage Guide](#usage-guide)
- [File Structure](#file-structure)
- [Security Features](#security-features)
- [Default Credentials](#default-credentials)
- [Troubleshooting](#troubleshooting)

##  Features

- **User Authentication**
  - Secure admin login with password hashing
  - User registration for new admin accounts
  - Session-based security
  - Logout functionality

- **Product Management (CRUD)**
  - Add new products
  - View all products in a table
  - Edit existing products
  - Delete products

- **Security**
  - PDO with prepared statements (prevents SQL injection)
  - Password hashing using PHP's `password_hash()`
  - Session management for protected pages
  - Form validation

- **User Interface**
  - Clean and simple design
  - Responsive layout
  - Clear success/error messages
  - Easy navigation

##  Requirements

- **Server**: XAMPP, WAMP, LAMP, or any PHP server
- **PHP**: Version 7.4 or higher
- **MySQL**: Version 5.7 or higher
- **Web Browser**: Any modern browser (Chrome, Firefox, Edge, etc.)

##  Installation

### Step 1: Download/Clone Files

Place all project files in your web server directory:
- **XAMPP**: `C:\xampp\htdocs\Deploy\`
- **WAMP**: `C:\wamp64\www\Deploy\`
- **LAMP**: `/var/www/html/Deploy/`

### Step 2: Database Setup

1. Start your MySQL server (via XAMPP Control Panel, WAMP, etc.)

2. Open phpMyAdmin (usually at `http://localhost/phpmyadmin`)

3. Create a new database:
   - Click "New" in the left sidebar
   - Database name: `inventory_db`
   - Collation: `utf8mb4_general_ci`
   - Click "Create"

4. Import the SQL file:
   - Select the `inventory_db` database
   - Click the "Import" tab
   - Choose file: `database.sql`
   - Click "Go"

   **OR** manually run the SQL commands from `database.sql` in the SQL tab

### Step 3: Configuration

1. Open `db.php` in a text editor

2. Update database credentials if needed (default XAMPP settings):
   ```php
   define('DB_HOST', 'localhost');
   define('DB_NAME', 'inventory_db');
   define('DB_USER', 'root');
   define('DB_PASS', '');  // Change if you have a MySQL password
   ```

3. Save the file

### Step 4: Access the System

1. Start Apache and MySQL in XAMPP/WAMP

2. Open your browser and navigate to:
   ```
   http://localhost/Deploy/login.php
   ```

3. Login with default credentials (see below)

##  Database Setup

The system uses 2 tables:

### 1. `users` Table
- `id` - Primary key (auto-increment)
- `username` - Unique username
- `password` - Hashed password

### 2. `products` Table
- `id` - Primary key (auto-increment)
- `product_name` - Product name
- `quantity` - Stock quantity (integer)
- `price` - Product price (decimal)

## Configuration

### Database Connection

Edit `db.php` to change database settings:

```php
define('DB_HOST', 'localhost');    // Database host
define('DB_NAME', 'inventory_db');  // Database name
define('DB_USER', 'root');          // Database username
define('DB_PASS', '');              // Database password
```

##  Usage Guide

### For Administrators

#### 1. **Login**
- Navigate to `login.php`
- Enter your username and password
- Click "Login"
- You'll be redirected to the dashboard

#### 2. **Register New Admin Account**
- Click "Register here" link on the login page
- Fill in:
  - Username (minimum 3 characters)
  - Password (minimum 6 characters)
  - Confirm Password
- Click "Register"
- Login with your new credentials

#### 3. **Dashboard**
- After login, you'll see the main dashboard
- Options:
  - **View Products**: See all products in the system
  - **Add New Product**: Create a new product entry

#### 4. **Add Product**
- Click "Add New Product" from dashboard or products page
- Fill in the form:
  - **Product Name**: Name of the product
  - **Quantity**: Stock quantity (must be a number ≥ 0)
  - **Price**: Product price (must be a number ≥ 0)
- Click "Add Product"
- You'll see a success message

#### 5. **View Products**
- Click "View Products" from dashboard
- See all products in a table format
- Each product shows:
  - ID
  - Product Name
  - Quantity
  - Price
  - Edit/Delete buttons

#### 6. **Edit Product**
- From the products page, click "Edit" next to any product
- Modify the product information
- Click "Update Product"
- Changes will be saved

#### 7. **Delete Product**
- From the products page, click "Delete" next to any product
- The product will be immediately deleted
- You'll see a confirmation message

#### 8. **Logout**
- Click "Logout" button from any page
- You'll be logged out and redirected to login page

##  File Structure

```
Deploy/
│
├── database.sql          # Database schema and default admin user
├── db.php                # Database connection and helper functions
├── login.php             # Admin login page
├── register.php          # Admin registration page
├── logout.php            # Logout handler
├── dashboard.php         # Main dashboard after login
├── products.php          # View all products
├── add_product.php       # Add new product form
├── edit_product.php      # Edit existing product form
├── delete_product.php    # Delete product handler
├── style.css             # Stylesheet for all pages
└── README.md             # This file
```

##  Security Features

### Implemented Security Measures:

1. **PDO Prepared Statements**
   - All database queries use prepared statements
   - Prevents SQL injection attacks
   - Uses named placeholders (`:parameter`)

2. **Password Security**
   - Passwords are hashed using `password_hash()`
   - Password verification using `password_verify()`
   - Never stored in plain text

3. **Session Management**
   - Protected pages check for active session
   - Automatic redirect to login if not authenticated
   - Session destroyed on logout

4. **Input Validation**
   - Form fields are validated before processing
   - Empty field checks
   - Numeric validation for quantity and price
   - Username uniqueness check

5. **Error Handling**
   - All database operations wrapped in try-catch blocks
   - User-friendly error messages
   - No sensitive information exposed

6. **XSS Protection**
   - All output uses `htmlspecialchars()`
   - Prevents cross-site scripting attacks

##  Default Credentials

After importing `database.sql`, you can login with:

- **Username**: `admin`
- **Password**: `admin123`

** Important**: Change the default password after first login for security!

##  Troubleshooting

### Problem: "Database connection failed"
**Solution**: 
- Check if MySQL is running
- Verify database credentials in `db.php`
- Ensure database `inventory_db` exists

### Problem: "Access Denied" or can't login
**Solution**:
- Verify database was imported correctly
- Check if default admin user exists in `users` table
- Try registering a new account

### Problem: Pages show blank or errors
**Solution**:
- Check PHP error logs
- Ensure PHP version is 7.4 or higher
- Verify all files are in the correct directory
- Check file permissions

### Problem: Can't add/edit products
**Solution**:
- Verify you're logged in (check session)
- Check if `products` table exists
- Verify database connection is working

### Problem: CSS not loading
**Solution**:
- Check if `style.css` is in the same directory
- Clear browser cache
- Check file permissions

##  Notes

- This is a simple system designed for learning and basic inventory management
- No JavaScript is used (pure PHP, HTML, CSS)
- All code is well-commented for educational purposes
- The system follows PHP best practices and security standards

##  For Two Users

### User 1: System Administrator
- Can login with default credentials or registered account
- Full access to all features
- Can manage products (add, edit, delete, view)
- Can register additional admin accounts

### User 2: Additional Administrator
- Must register first using `register.php`
- After registration, can login with their credentials
- Same access as User 1
- Can manage all products independently

**Note**: Both users share the same product database. All products are visible to all administrators.

##  Getting Started Checklist

- [ ] Install XAMPP/WAMP/LAMP
- [ ] Place files in web server directory
- [ ] Create database `inventory_db`
- [ ] Import `database.sql`
- [ ] Configure `db.php` if needed
- [ ] Start Apache and MySQL
- [ ] Access `http://localhost/Deploy/login.php`
- [ ] Login with admin/admin123
- [ ] Register second admin account (optional)
- [ ] Start managing products!

##  Support

If you encounter any issues:
1. Check the Troubleshooting section above
2. Verify all installation steps were completed
3. Check PHP and MySQL error logs
4. Ensure all file permissions are correct

---

**Version**: 1.0  
**Last Updated**: 2024  
**License**: Free to use for educational purposes


