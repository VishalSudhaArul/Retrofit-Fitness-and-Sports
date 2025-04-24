<?php
session_start();

if (!isset($_SESSION['username'])) {
    // Redirect if not logged in
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];


$username = $_SESSION['username'];


$username = $_SESSION['username'];
$mysqli = new mysqli("localhost", "root", "", "myproject");

$message = "";

// Handle BMI submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['submit_bmi'])) {
    $name = $_POST['name'];
    $age = $_POST['age'];
    $height = $_POST['height'];
    $weight = $_POST['weight'];

    $height_m = $height / 100;
    $bmi = round($weight / ($height_m * $height_m), 2);

    if ($bmi < 18.5) $category = "Underweight";
    else if ($bmi < 24.9) $category = "Normal";
    else if ($bmi < 29.9) $category = "Overweight";
    else $category = "Obese";

    $stmt = $mysqli->prepare("INSERT INTO bmi_data (username, name, age, height_cm, weight_kg, bmi, bmi_category) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiddds", $username, $name, $age, $height, $weight, $bmi, $category);
    $stmt->execute();
    $stmt->close();

    $message = "BMI Recorded: $bmi ($category)";
}

// Get user BMI data
$result = $mysqli->query("SELECT * FROM bmi_data WHERE username = '$username' ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Retro BMI Calculator</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function toggleBMIView() {
      const panel = document.getElementById("bmiPanel");
      panel.classList.toggle("hidden");
    }
  </script>
</head>
<body class="bg-gray-900 text-white">

  <!-- Navbar -->
  <nav class="w-full bg-[#0a0f1a] text-white fixed top-0 z-50 bg-black">
    <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
      
      <!-- Left: Logo -->
      <div class="text-2xl font-bold">
        Retro.<span class="text-yellow-400">fit</span>
      </div>

      <!-- Center: Navigation Links -->
      <div class="hidden md:flex space-x-10 text-lg">
        <a href="sat6.html" class="hover:text-yellow-400">HOME</a>
        <a href="store.php" class="hover:text-yellow-400">STORE</a>
        <a href="plans.php" class="hover:text-yellow-400">PLANS</a>
      </div>

      <!-- Right: Logout Button -->
      <div>
  <a href="logout.php">
    <button class="border border-white px-4 py-1 rounded hover:bg-white hover:text-black transition">
      LOGOUT
    </button>
  </a>
</div>

  </nav>

  <!-- Left: Form -->
  <div class="pt-24 px-6 max-w-2xl mx-auto">
  <h1 class="text-3xl font-bold mb-6">Retro BMI Calculator</h1>

    <?php if (!empty($message)): ?>
      <div class="bg-green-600 text-white p-4 rounded mb-4"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
      <input name="name" placeholder="Your Name" required class="w-full p-2 rounded bg-gray-800 border border-gray-600" />
      <input name="age" type="number" placeholder="Age" required class="w-full p-2 rounded bg-gray-800 border border-gray-600" />
      <input name="height" type="number" step="any" placeholder="Height (cm)" required class="w-full p-2 rounded bg-gray-800 border border-gray-600" />
      <input name="weight" type="number" step="any" placeholder="Weight (kg)" required class="w-full p-2 rounded bg-gray-800 border border-gray-600" />
      <button name="submit_bmi" class="bg-yellow-400 text-black font-bold px-6 py-2 rounded hover:bg-yellow-500">Calculate BMI</button>
    </form>
  </div>
<center>
  <!-- Right: View BMI -->
  <div class="w-1/4 p-6  border-l border-gray-700 flex flex-col items-center">
    <button onclick="toggleBMIView()" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded font-semibold mb-4">
      View BMI
    </button>

    <div id="bmiPanel" class="hidden w-full overflow-y-auto max-h-[75vh]">
      <h2 class="text-xl font-semibold mb-4 text-center">Your BMI Records</h2>

      <?php if ($result->num_rows > 0): ?>
        <div class="space-y-4">
          <?php while ($row = $result->fetch_assoc()): ?>
            <div class="bg-gray-800 p-4 rounded shadow">
              <p><strong>Name:</strong> <?= $row['name'] ?></p>
              <p><strong>Age:</strong> <?= $row['age'] ?></p>
              <p><strong>Height:</strong> <?= $row['height_cm'] ?> cm</p>
              <p><strong>Weight:</strong> <?= $row['weight_kg'] ?> kg</p>
              <p><strong>BMI:</strong> <?= $row['bmi'] ?> (<?= $row['bmi_category'] ?>)</p>
              <p class="text-sm text-gray-400"><?= $row['created_at'] ?></p>
            </div>
          <?php endwhile; ?>
        </div>
      <?php else: ?>
        <p class="text-gray-400 text-center">No records found.</p>
      <?php endif; ?>
    </div>
  </div>
      </center>
</body>
</html>
