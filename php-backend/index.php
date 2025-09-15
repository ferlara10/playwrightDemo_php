<?php
session_start();

// Initialize contacts array in session if not already set
if (!isset($_SESSION['contacts'])) {
    $_SESSION['contacts'] = [];
}

// Handle add contact
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {
    $name  = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);

    if ($name && $email && $phone) {
        $id = uniqid(); // unique contact ID
        $_SESSION['contacts'][] = [
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'phone' => $phone
        ];
    }
}

// Handle delete contact
if (isset($_GET['delete'])) {
    $idToDelete = $_GET['delete'];
    $_SESSION['contacts'] = array_filter($_SESSION['contacts'], function ($contact) use ($idToDelete) {
        return $contact['id'] !== $idToDelete;
    });
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Contact Manager</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        form { margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f4f4f4; }
        a.delete-btn { color: red; text-decoration: none; }
    </style>
</head>
<body>
    <h1>Contact Manager</h1>

    <h2>Add Contact</h2>
    <form method="post" action="">
        <input type="hidden" name="add" value="1">
        <label>Name: <input type="text" name="name" required></label>
        <label>Email: <input type="email" name="email" required></label>
        <label>Phone: <input type="text" name="phone" required></label>
        <button type="submit">Add</button>
    </form>

    <h2>Contact List</h2>
    <table>
        <tr>
            <th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Actions</th>
        </tr>
        <?php foreach ($_SESSION['contacts'] as $contact): ?>
        <tr>
            <td><?= htmlspecialchars($contact['id']) ?></td>
            <td><?= htmlspecialchars($contact['name']) ?></td>
            <td><?= htmlspecialchars($contact['email']) ?></td>
            <td><?= htmlspecialchars($contact['phone']) ?></td>
            <td><a class="delete-btn" href="?delete=<?= $contact['id'] ?>" onclick="return confirm('Delete this contact?');">Delete</a></td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>