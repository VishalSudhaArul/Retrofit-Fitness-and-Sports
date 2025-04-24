<?php


ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();
$host = "localhost";
$user = "root";
$pass = "";
$db = "myproject";

$conn = new mysqli($host, $user, $pass, $db);
$login_error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($storedPassword);
        $stmt->fetch();

        if ($password === $storedPassword) { // simple compare
            $_SESSION["username"] = $username;
            header("Location: sat6.html");
            exit();
        } else {
            echo "❌ Incorrect password!";
        }
    } else {
        echo "❌ Username not found!";
    }
}
?>

<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white min-h-screen flex items-center justify-center">
    <div class="bg-gray-800 p-8 rounded-2xl shadow-lg w-full max-w-md">
        <h2 class="text-3xl font-bold mb-6 text-center">Login to Your Account</h2>

        <?php if ($login_error != ""): ?>
            <div class="bg-red-500 text-white p-3 rounded mb-4 text-center">
                <?php echo $login_error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php" class="space-y-4">
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
                Login
            </button>
        </form>
        <p class="mt-4 text-center text-sm text-gray-400">
    Don't have an account? <a href="register.php" class="text-indigo-400 hover:underline">Register here</a>
</p>
<p class="mt-2 text-center text-sm text-gray-400">
    Forgot your password? <a href="contact.php" class="text-indigo-400 hover:underline">Contact us</a>
</p>

    </div>
</body>
</html>

