<!DOCTYPE html>
<html>
<head>
    <title>Add Contact</title>
</head>
<body>
    <h1>Add a New Contact</h1>
    <form method="POST" action="save.php">
        <label>Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Phone:</label><br>
        <input type="text" name="phone"><br><br>

        <button type="submit">Save Contact</button>
    </form>
    <br>
    <a href="index.php">⬅ Back to Home</a>
</body>
</html>