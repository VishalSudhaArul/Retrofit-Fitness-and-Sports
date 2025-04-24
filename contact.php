
<?php
session_start();


$userQuery = "";
 // Step 1A: Create a blank variable

// Step 1B: Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // (You can put your form-processing code here too — like saving to DB)

    // Set the message AFTER form submission
   // $userQuery = "<p id='successMessage' class='text-green-600 text-center mt-4'>✅ Your query has been successfully registered. You will be reached soon.</p>";
}
// Uncomment this block to enforce login check
// if (!isset($_SESSION['username'])) {
//     echo '
//     <div style="display: flex; flex-direction: column; justify-content: center; align-items: center; height: 100vh; font-family: sans-serif;">
//         <p style="font-size: 20px; margin-bottom: 20px;">Please log in first.</p>
//         <a href="login.php" style="padding: 10px 20px; background-color: #3b82f6; color: white; text-decoration: none; border-radius: 5px;">
//             Login
//         </a>
//     </div>';
//     exit;
// }

$host = "localhost";
$user = "root";
$password = "";
$dbname = "myproject";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$userQuery = "";
if (isset($_POST['submit'])) {
    $username = $_SESSION['username'] ?? 'Guest';
    $name = $_POST['name'];
    $email = $_POST['email'];
    $issue = $_POST['issue'];

    $stmt = $conn->prepare("INSERT INTO queries (username, name, email, issue) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $username, $name, $email, $issue);
    $stmt->execute();
   // $userQuery = "<p id='successMessage' class='text-green-600 text-center mt-4'>✅ Your query has been successfully registered. You will be reached soon.</p>";
    $stmt->close();
}

if (isset($_POST['view'])) {
    $username = $_SESSION['username'] ?? 'Guest';
    $sql = "SELECT name, email, issue FROM queries WHERE username = ? ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $userQuery = "<div class='mt-4 p-4 border bg-gray-100'>
            <p><strong>Name:</strong> {$row['name']}</p>
            <p><strong>Email:</strong> {$row['email']}</p>
            <p><strong>Issue:</strong> {$row['issue']}</p>
        </div>";
    } else {
        $userQuery = "<p class='text-red-600 text-center'>No queries found!</p>";
    }
    $stmt->close();
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Contact Us</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex justify-center items-center min-h-screen bg-gray-900">

<!-- Sticky Top Navbar -->
<div style="
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    background-color: black;
    padding: 15px 0;
    color: white;
    font-family: sans-serif;
    z-index: 1000;
">
    <div style="display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: auto;">
        
        <!-- Left: Brand -->
        <div style="font-size: 24px; font-weight: bold; padding-left: 20px;">
            Retro.fit
        </div>

        <!-- Center: Navigation Links -->
        <div style="display: flex; gap: 30px; font-size: 18px;">
            <a href="index.php" style="color: white; text-decoration: none; ">HOME</a>
            <a href="store.php" style="color: white; text-decoration: none;">STORE</a>
            <a href="retro_bmi.php" style="color: white; text-decoration: none;">BMI</a>
            <a href="plans.php" style="color: white; text-decoration: none;">PLANS</a>
        </div>

        <!-- Right: Logout -->
        <div style="padding-right: 20px;">
            <a href="logout.php" style="background-color: black; padding: 8px 16px; color: white; text-decoration: none; border-radius: 5px;">
                LOGOUT
            </a>
        </div>

    </div>
</div>

<!-- Padding to avoid content hiding behind navbar -->
<div style="padding-top: 80px;"></div>


    <div class="bg-white p-8 rounded shadow-md w-full max-w-lg">
        <h1 class="text-2xl font-bold text-center mb-4">Contact Us</h1>
        <form method="POST">
            <input type="text" name="name" placeholder="Your Name" class="w-full mb-3 p-2 border rounded" required>
            <input type="email" name="email" placeholder="Your Email" class="w-full mb-3 p-2 border rounded" required>
            <textarea name="issue" placeholder="Describe your issue" rows="4" class="w-full mb-3 p-2 border rounded" required></textarea>
            <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 w-full">
                Submit
            </button>
        </form>

        <form method="POST" class="mt-4">
            <button type="submit" name="view" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800 w-full">
                View Your Query
            </button>
        </form>
        <?php
if (!empty($userQuery)) {
    echo $userQuery;
}
?>

    </div>
   

</body>
</html>
