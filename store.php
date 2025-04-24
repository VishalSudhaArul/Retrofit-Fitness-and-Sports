<?php

session_start();
$username = isset($_SESSION["username"]) ? $_SESSION["username"] : "guest";

// Database connection
$conn = new mysqli("localhost", "root", "", "myproject");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Add to Cart
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_id'])) {
  $username = isset($_SESSION["username"]) ? $_SESSION["username"] : "guest"; // static for now
  $product_id = $_POST['product_id'];

  // ✅ Check if product exists before inserting
  $check = $conn->prepare("SELECT id FROM products WHERE id = ?");
  $check->bind_param("i", $product_id);
  $check->execute();
  $result = $check->get_result();

  if ($result->num_rows > 0) {
      // Product exists, safe to insert
      $stmt = $conn->prepare("INSERT INTO cart (username, product_id) VALUES (?, ?)");
      $stmt->bind_param("si", $username, $product_id);
      $stmt->execute();
      $stmt->close();
  } else {
      echo "<script>alert('Invalid product!');</script>";
  }

  $check->close();
}


// Fetch products
$products = $conn->query("SELECT * FROM products");
// Fetch cart items for the user
$stmt = $conn->prepare("
    SELECT products.name, products.price, products.category
    FROM cart
    JOIN products ON cart.product_id = products.id
    WHERE cart.username = ?
");
$stmt->bind_param("s", $username);
$stmt->execute();
$cart_items = $stmt->get_result();


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Store - Retro.fit</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <script>
  function toggleCart() {
    document.getElementById("cartPanel").classList.toggle("hidden");
  }
</script>


<script>
  function toggleCart() {
    const cart = document.getElementById("cartPanel");
    cart.classList.toggle("hidden");
  }
</script>



</head>
<body class="bg-gray-900 text-white">

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
  </ul>

  <!-- Right: GetApp -->
  <div>
  <a href="logout.php">
    <button class="text-white px-5 py-2 rounded-lg font-semibold shadow-md border transition hover:bg-white hover:text-black">
      LOGOUT
    </button>
  </a>
</div>

</nav>



<!-- Store Content -->
<div class="p-6">
  <!-- Title + Cart Button -->
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold">🏋️ Store - Gym & Sports Equipment</h1>
    <button onclick="toggleCart()" class="bg-yellow-500 hover:bg-yellow-400 text-black px-4 py-2 rounded shadow">
      🛒 View Cart
    </button>


    <!-- Order Button -->
<button onclick="openBookingConfirmation()" class="bg-yellow-500 hover:bg-yellow-400 text-black px-4 py-2 rounded shadow">
  🛒 Order Now
</button>

<!-- Confirmation Box -->
<div id="bookingBox" class="hidden bg-gray-800 p-6 rounded-lg mt-6 shadow-lg">
  <h2 class="text-xl font-bold mb-4">Confirm Booking</h2>
  <p class="text-white mb-4">Are you sure you want to confirm your booking?</p>
  <button onclick="bookNow()" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded mr-2">Book Now</button>
  <button onclick="closeBookingBox()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Cancel</button>
</div>

<!-- Success Popup -->
<div id="bookingSuccess" class="hidden fixed top-1/3 left-1/2 transform -translate-x-1/2 bg-green-700 text-white px-6 py-4 rounded-lg shadow-lg z-50">
  ✅ Your order will be executed and we will reach you soon.
</div>

<script>
function openBookingConfirmation() {
  document.getElementById('bookingBox').classList.remove('hidden');
}

function closeBookingBox() {
  document.getElementById('bookingBox').classList.add('hidden');
}

function bookNow() {
  document.getElementById('bookingBox').classList.add('hidden');
  document.getElementById('bookingSuccess').classList.remove('hidden');
  
  // Hide message after 4 seconds
  setTimeout(() => {
    document.getElementById('bookingSuccess').classList.add('hidden');
  }, 4000);

  // Optionally send email or redirect here
}
</script>




  </div>

  <!-- Flex layout: Products + Cart Side-by-side -->
  <div class="flex flex-col lg:flex-row gap-6">
    <!-- Products Grid -->
    <div class="w-full lg:w-2/3 grid grid-cols-1 md:grid-cols-2 gap-6">
      <?php while ($row = $products->fetch_assoc()): ?>
        <div class="bg-gray-800 rounded-2xl p-4 shadow-lg">
          <h2 class="text-xl font-bold mb-2"><?= htmlspecialchars($row['name']) ?></h2>
          <p class="text-gray-300 mb-2"><?= htmlspecialchars($row['category']) ?></p>
          <p class="text-green-400 font-semibold mb-4">₹<?= number_format($row['price'], 2) ?></p>
          <form method="POST">
            <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
            <button type="submit" class="bg-yellow-400 hover:bg-yellow-500 px-4 py-2 rounded text-white">Add to Cart</button>
          </form>
        </div>
      <?php endwhile; ?>
    </div>

    <!-- Cart Panel -->
    <div id="cartPanel" class="hidden w-full lg:w-1/3 bg-gray-800 p-4 rounded-2xl shadow-lg h-fit">
      <h2 class="text-2xl font-bold mb-4">🛒 Your Cart</h2>
      <?php if ($cart_items->num_rows > 0): ?>
        <ul class="space-y-2">
          <?php while ($item = $cart_items->fetch_assoc()): ?>
            <li class="border-b border-gray-700 pb-2">
              <div class="flex justify-between">
                <div>
                  <span class="font-semibold"><?= htmlspecialchars($item['name']) ?></span>
                  <span class="text-gray-400">(<?= htmlspecialchars($item['category']) ?>)</span>
                </div>
                <div class="text-green-400">₹<?= number_format($item['price'], 2) ?></div>
              </div>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php else: ?>
        <p class="text-gray-400">Your cart is empty.</p>
      <?php endif; ?>
    </div>
  </div>
</div>



<!-- Hidden Cart Panel -->
<div id="cartPanel" class="hidden bg-gray-800 p-4 rounded-2xl shadow-lg mb-10 max-w-md ml-auto">
  <h2 class="text-2xl font-bold mb-4">🛒 Your Cart</h2>
  <?php if ($cart_items->num_rows > 0): ?>
    <ul class="space-y-2">
      <?php while ($item = $cart_items->fetch_assoc()): ?>
        <li class="border-b border-gray-700 pb-2">
          <div class="flex justify-between">
            <div>
              <span class="font-semibold"><?= htmlspecialchars($item['name']) ?></span>
              <span class="text-gray-400">(<?= htmlspecialchars($item['category']) ?>)</span>
            </div>
            <div class="text-green-400">₹<?= number_format($item['price'], 2) ?></div>
          </div>
        </li>
      <?php endwhile; ?>
    </ul>
  <?php else: ?>
    <p class="text-gray-400">Your cart is empty.</p>
  <?php endif; ?>
</div>


  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php while ($row = $products->fetch_assoc()): ?>
      <div class="bg-gray-800 rounded-2xl p-4 shadow-lg">
        <h2 class="text-xl font-bold mb-2"><?= htmlspecialchars($row['name']) ?></h2>
        <p class="text-gray-300 mb-2"><?= htmlspecialchars($row['category']) ?></p>
        <p class="text-green-400 font-semibold mb-4">₹<?= number_format($row['price'], 2) ?></p>
        <form method="POST">
          <input type="hidden" name="product_id" value="<?= $row['id'] ?>">
          <button type="submit" class="bg-green-500 hover:bg-green-600 px-4 py-2 rounded text-white">Add to Cart</button>
        </form>
      </div>
    <?php endwhile; ?>
  </div>
</div>


<?php if ($cart_items->num_rows > 0): ?>
  <!-- Cart List Here -->
  <button onclick="openPaymentModal()" class="mt-4 bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded text-white">
    Proceed to Payment
  </button>
<?php endif; ?>



</body>
</html>


