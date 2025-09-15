<?php
require "db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name  = $_POST["name"] ?? "";
    $email = $_POST["email"] ?? "";
    $phone = $_POST["phone"] ?? "";

    if ($name && $email) {
        $stmt = $db->prepare("INSERT INTO contacts (name, email, phone) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $phone]);
        header("Location: view.php?success=1");
        exit;
    } else {
        echo "Name and Email are required.";
    }
}
?>