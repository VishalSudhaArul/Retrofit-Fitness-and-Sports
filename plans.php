<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "store");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $plan = $_POST["plan"];
    $last_date = $_POST["last_date"];

    $stmt = $conn->prepare("INSERT INTO user_plans (name, phone, plan, last_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $phone, $plan, $last_date);
    $stmt->execute();
    $stmt->close();
}

// Fetch all submitted plans
$result = $conn->query("SELECT * FROM user_plans");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Plans & Pricing - Retro.fit</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-900 text-white p-6">


<nav class="flex justify-between items-center px-8 py-4 bg-gray-950 text-white">
  <!-- Left: Logo -->
  <div class="text-2xl font-bold">
    <a href="#">Retro.fit</a>
  </div>

  <!-- Center: Navigation links -->
  <ul class="flex space-x-6">
    <li><a href="sat6.html" class="hover:text-yellow-400 text-lg">HOME</a></li>
    <li><a href="store.php" class="hover:text-yellow-400 text-lg">STORE</a></li>
    <li><a href="plans.php" class="hover:text-yellow-400 text-lg">PLANS</a></li>
    <li><a href="turf_booking.php" class="hover:text-yellow-400 text-lg">BOOK TURF</a><li>
  </ul>

  <!-- Right: GetApp -->
  <div>
  <button class="text-white px-5 py-2 rounded-lg font-semibold shadow-md border transition hover:bg-white hover:text-black text-lg">GET APP</button>
  </div>
</nav>

<br>
<br>
<br>


  <!-- Choose Your Plan -->
  <div class="max-w-xl mx-auto bg-gray-800 p-6 rounded-xl shadow-lg mb-10">
    <h2 class="text-2xl font-bold mb-4 text-center">💪 Choose Your Plan</h2>
    <form method="POST" class="space-y-4">
      <input type="text" name="name" required placeholder="Your Name" class="w-full p-2 rounded bg-gray-700 text-white">
      <input type="text" name="phone" required placeholder="Phone Number" class="w-full p-2 rounded bg-gray-700 text-white">
      
      <select name="plan" required class="w-full p-2 rounded bg-gray-700 text-white">
        <option value="">-- Select a Plan --</option>
        <option value="Basic Plan - ₹499/month">Basic Plan - ₹499/month</option>
        <option value="Standard Plan - ₹799/month">Standard Plan - ₹799/month</option>
        <option value="Pro Plan - ₹1199/month">Pro Plan - ₹1199/month</option>
        <option value="Gym Only - ₹699/month">Gym Only - ₹699/month</option>
        <option value="Sports Only - ₹599/month">Sports Only - ₹599/month</option>
        <option value="Combo Pack - ₹1299/month">Combo Pack - ₹1299/month</option>
        <option value="6-Month Pack - ₹4999">6-Month Pack - ₹4999</option>
        <option value="Yearly Plan - ₹8999">Yearly Plan - ₹8999</option>
        <option value="Personal Trainer - ₹1599/month">Personal Trainer - ₹1599/month</option>
        <option value="Diet Plan Add-on - ₹299/month">Diet Plan Add-on - ₹299/month</option>
      </select>

      <input type="date" name="last_date" required class="w-full p-2 rounded bg-gray-700 text-white">
        <p>Select Last date of Payment</p> 
      <button type="submit" class="w-full bg-green-600 hover:bg-green-700 p-2 rounded text-white font-semibold">
        ✅ Submit Plan
      </button>
    </form>
  </div>

  <!-- View Submitted Plans -->
  <div class="max-w-5xl mx-auto bg-gray-800 p-6 rounded-xl shadow-lg">
    <h2 class="text-2xl font-bold mb-4 text-center">📄 Submitted Plans</h2>
    <?php if ($result->num_rows > 0): ?>
      <table class="w-full table-auto border border-gray-700">
        <thead>
          <tr class="bg-gray-700">
            <th class="p-2">Name</th>
            <th class="p-2">Phone</th>
            <th class="p-2">Plan</th>
            <th class="p-2">Last Payment Date</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr class="border-t border-gray-600 text-center">
              <td class="p-2"><?= htmlspecialchars($row['name']) ?></td>
              <td class="p-2"><?= htmlspecialchars($row['phone']) ?></td>
              <td class="p-2"><?= htmlspecialchars($row['plan']) ?></td>
              <td class="p-2"><?= htmlspecialchars($row['last_date']) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p class="text-gray-400 text-center">No plans submitted yet.</p>
    <?php endif; ?>
  </div>

</body>
</html>
