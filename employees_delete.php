<?php
require __DIR__ . '/db.php';
require_login();

$errors = [];
$notice = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id'] ?? 0);
    if ($id <= 0) {
        $errors[] = 'A valid employee ID is required to delete.';
    } else {
        try {
            $stmt = db()->prepare('DELETE FROM employees WHERE id = :id');
            $stmt->execute([':id' => $id]);
            $notice = 'Employee deleted (if existed).';
        } catch (Throwable $e) {
            $errors[] = 'Unable to delete employee right now.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Employee</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header class="topbar">
        <div>
            <strong>Employee Management</strong>
            <span class="muted">Delete employee</span>
        </div>
        <nav class="nav-links">
            <a class="button ghost" href="dashboard.php">Dashboard</a>
            <a class="button ghost" href="employees_list.php">View</a>
            <a class="button ghost" href="logout.php">Logout</a>
        </nav>
    </header>

    <main class="layout">
        <?php if ($notice): ?>
            <div class="alert success"><?php echo htmlspecialchars($notice); ?></div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert error">
                <?php foreach ($errors as $err): ?>
                    <div><?php echo htmlspecialchars($err); ?></div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <section class="card">
            <h2>Delete Employee</h2>
            <form method="post" class="form">
                <label>
                    Employee ID *
                    <input type="number" name="id" min="1" required>
                </label>
                <button type="submit" class="danger">Delete</button>
            </form>
            <p class="muted">Deletion is permanent.</p>
        </section>
    </main>
</body>
</html>
