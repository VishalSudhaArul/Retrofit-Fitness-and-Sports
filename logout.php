<?php
session_start();

if (isset($_GET['confirm']) && $_GET['confirm'] == 'yes') {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout Confirmation</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 h-screen flex items-center justify-center text-white">

    <!-- Modal Background -->
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <!-- Modal Box -->
        <div class="bg-gray-800 text-white rounded-2xl shadow-lg p-8 w-96 text-center">
            <h2 class="text-2xl font-bold mb-4">Are you sure you want to logout?</h2>
            <div class="flex justify-center space-x-4">
                <a href="logout.php?confirm=yes" class="bg-cyan-500 hover:bg-cyan-600 text-white px-6 py-2 rounded-xl font-semibold transition duration-300">Yes</a>
                <a href="check_session.php" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-xl font-semibold transition duration-300">No</a>
            </div>
        </div>
    </div>

</body>
</html>
