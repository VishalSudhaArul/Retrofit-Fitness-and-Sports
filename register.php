<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = "localhost";
$user = "root";
$pass = "";
$db = "myproject";

// Create a new database connection
$conn = new mysqli($host, $user, $pass, $db);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error_message = "";
$success_message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if the username already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $error_message = "Username or email already exists. Please choose a different one.";
    } else {
        // Insert the new user
        $stmt = $conn->prepare("INSERT INTO users (email, username, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $username, $password);
        $stmt->execute();

        $success_message = "Registered successfully. <a href='login.php' class='underline text-indigo-400'>Login Now</a>";
    }

    $stmt->close();
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 p-8 rounded-2xl shadow-lg w-full max-w-md">
        <h2 class="text-3xl font-bold mb-6 text-center">Create Your Account</h2>

        <?php if ($error_message != ""): ?>
            <div class="bg-red-500 text-white p-3 rounded mb-4 text-center">
                <?= $error_message; ?>
            </div>
        <?php elseif ($success_message != ""): ?>
            <div class="bg-green-500 text-white p-3 rounded mb-4 text-center">
                <?= $success_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="register.php" class="space-y-4">
            <div>
                <label for="email" class="block mb-1 text-sm font-semibold">Email</label>
                <input type="email" name="email" id="email" required
                       class="w-full px-4 py-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label for="username" class="block mb-1 text-sm font-semibold">Username</label>
                <input type="text" name="username" id="username" required
                       class="w-full px-4 py-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <div>
                <label for="password" class="block mb-1 text-sm font-semibold">Password</label>
                <input type="password" name="password" id="password" required
                       class="w-full px-4 py-2 rounded bg-gray-700 border border-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>
            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 rounded transition duration-200">
                Register
            </button>
        </form>
        <p class="mt-4 text-center text-sm text-gray-400">
            Already have an account? <a href="login.php" class="text-indigo-400 hover:underline">Login here</a>
        </p>
    </div>
</body>
</html>
