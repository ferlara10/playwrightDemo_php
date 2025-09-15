<?php
// db.php - database connection
$dbFile = __DIR__ . "/contacts.db";

try {
    $db = new PDO("sqlite:" . $dbFile);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create table if not exists
    $db->exec("CREATE TABLE IF NOT EXISTS contacts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        email TEXT NOT NULL,
        phone TEXT
    )");
} catch (Exception $e) {
    die("Database error: " . $e->getMessage());
}
?>