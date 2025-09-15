<?php
require "db.php";
$contacts = $db->query("SELECT * FROM contacts ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>View Contacts</title>
</head>
<body>
    <h1>Contacts List</h1>
    <?php if (isset($_GET['success'])): ?>
        <p style="color:green;">✅ Contact saved successfully!</p>
    <?php endif; ?>

    <?php if (count($contacts) > 0): ?>
        <table border="1" cellpadding="8">
            <tr>
                <th>ID</th><th>Name</th><th>Email</th><th>Phone</th>
            </tr>
            <?php foreach ($contacts as $c): ?>
            <tr>
                <td><?= htmlspecialchars($c["id"]) ?></td>
                <td><?= htmlspecialchars($c["name"]) ?></td>
                <td><?= htmlspecialchars($c["email"]) ?></td>
                <td><?= htmlspecialchars($c["phone"]) ?></td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>No contacts found.</p>
    <?php endif; ?>

    <br>
    <a href="index.php">⬅ Back to Home</a>
</body>
</html>