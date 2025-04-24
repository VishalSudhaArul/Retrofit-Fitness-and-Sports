<?php
$conn = new mysqli("localhost", "root", "", "store");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$result = $conn->query("SELECT * FROM user_plans");
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Plans</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-900 text-white p-8">
    <h1 class="text-3xl font-bold mb-6">📊 View User Plans</h1>
    <table class="w-full bg-gray-800 rounded-xl shadow-lg">
        <thead>
            <tr class="bg-gray-700 text-left">
                <th class="p-3">Name</th>
                <th class="p-3">Phone</th>
                <th class="p-3">Plan</th>
                <th class="p-3">Last Payment Date</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr class="border-t border-gray-700">
                    <td class="p-3"><?= htmlspecialchars($row['name']) ?></td>
                    <td class="p-3"><?= htmlspecialchars($row['phone']) ?></td>
                    <td class="p-3"><?= htmlspecialchars($row['plan']) ?></td>
                    <td class="p-3"><?= htmlspecialchars($row['payment_due']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>
