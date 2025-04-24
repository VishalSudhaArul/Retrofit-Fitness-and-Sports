<?php
// File path for storing bookings
$bookingsFile = 'bookings.json';

//JavaScript Object Notation (JSON) for storing and exchanging data

// Load existing bookings
$bookings = file_exists($bookingsFile) ? json_decode(file_get_contents($bookingsFile), true) : [];

// Handle booking form submission
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['book'])) {
    $newBooking = [
        "id" => time(),
        "name" => $_POST['name'],
        "phone" => $_POST['phone'],
        "email" => $_POST['email'],
        "turf" => $_POST['turf'],
        "hours" => $_POST['hours'],
        "total_amount" => $_POST['hours'] * $_POST['fee']
    ];
    $bookings[] = $newBooking;
    file_put_contents($bookingsFile, json_encode($bookings, JSON_PRETTY_PRINT));
}

// Handle deleting a booking
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['delete'])) {
    $bookings = array_filter($bookings, fn($b) => $b['id'] != $_POST['booking_id']);
    file_put_contents($bookingsFile, json_encode($bookings, JSON_PRETTY_PRINT));
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Turf Booking</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-950 text-white">

<!-- Header -->
<header class="bg-black text-white fixed w-full top-0 flex items-center justify-between px-6 py-4 shadow-md">
    <div class="text-3xl font-bold tracking-wide">Retro.fit</div>
    <nav class="flex space-x-6 text-lg">
        <a href="sat6.html" class="hover:text-yellow-400 transition">HOME</a>
        <a href="sat6.html" class="hover:text-yellow-400 transition">FITNESS</a>
        <a href="sat6.html" class="hover:text-yellow-400 transition">SPORTS</a>
    </nav>
    <button class="text-white px-5 py-2 rounded-lg font-semibold shadow-md border transition hover:bg-white hover:text-black">GET APP</button>

</header>
<br>
<!-- Booking Section -->
<section id="turf-booking" class="py-24 text-center">
    <h2 class="text-4xl font-bold text-yellow-400">Turf Booking</h2>
    <p class="text-gray-300 text-xl mt-2">Improve your body control, strength, and performance with expert-guided sports training programs. </p>
    <p class="text-gray-300 text-xl mt-2">Reserve your turf slot and enjoy your game.</p>

    <!-- Buttons -->
    <div class="mt-6 flex justify-center space-x-4">
        <button onclick="openBookingModal()" class="bg-yellow-400 text-black px-6 py-3 rounded-lg font-semibold shadow-md hover:bg-yellow-500 transition">📅 Book Your Slot</button>
        <button onclick="toggleBookedSlots()" class="bg-blue-500 text-white px-6 py-3 rounded-lg font-semibold shadow-md hover:bg-blue-600 transition">📋 View Booked Slots</button>
    </div>
</section>

<!-- Booking Modal -->
<div id="bookingModal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center hidden">
   <!-- <div class="bg-white text-black p-6 rounded-lg w-96 shadow-lg"> -->
    <div class="bg-white p-6 rounded-lg w-3/5 max-w-3xl text-black relative shadow-lg">
    <h2 class="text-3xl font-bold text-center text-gray-900">⚽ Retro.Fit Turf Booking</h2>
    <p class="text-center text-gray-600">Choose your preferred turf and book your slot.</p>
        <!--<h3 class="text-2xl font-bold text-center mb-3">Book Your Turf</h3> -->

        <form method="post">
            <label class="block font-semibold">Name:</label>
            <input type="text" name="name" required class="w-full p-2 border rounded-md mb-3">

            <label class="block font-semibold">Phone:</label>
            <input type="tel" name="phone" required class="w-full p-2 border rounded-md mb-3">

            <label class="block font-semibold">Email:</label>
            <input type="email" name="email" required class="w-full p-2 border rounded-md mb-3">

            <label class="block font-semibold">Choose Turf:</label>
            <select name="turf" id="turf" class="w-full p-2 border rounded-md mb-3" required onchange="updateFee()">
                <option value="Turf 1" data-fee="800">Turf 1 - ₹800/hr</option>
                <option value="Turf 2" data-fee="900">Turf 2 - ₹900/hr</option>
                <option value="Turf 3" data-fee="700">Turf 3 - ₹700/hr</option>
                <option value="Turf 4" data-fee="950">Turf 4 - ₹950/hr</option>
                <option value="Turf 5" data-fee="850">Turf 5 - ₹850/hr</option>
                <option value="Turf 6" data-fee="750">Turf 6 - ₹750/hr</option>
            </select>

            <label class="block font-semibold">Hours:</label>
            <input type="number" name="hours" id="hours" min="1" required class="w-full p-2 border rounded-md mb-3" oninput="calculateAmount()">

            <input type="hidden" name="fee" id="fee" value="800">

            <p class="text-lg font-bold">Total Amount: ₹<span id="totalAmount">0</span></p>

            <div class="flex justify-between mt-4">
                <button type="button" onclick="closeBookingModal()" class="bg-gray-400 text-white px-4 py-2 rounded-md">Cancel</button>
                <button type="submit" name="book" class="bg-green-500 text-white px-4 py-2 rounded-md">Confirm Booking</button>
            </div>
        </form>
    </div>
</div>



<!-- Display Booked Slots (Initially Hidden) -->
<section id="booked-slots" class="py-12 bg-gray-900 text-white hidden">
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
        <div class="bg-white text-black p-6 rounded-lg w-96 shadow-lg">
            <div class="flex justify-between items-center mb-3">
                <h2 class="text-2xl font-bold">📋 Booked Slots</h2>
                <button onclick="toggleBookedSlots()" class="text-gray-600 hover:text-gray-800">✖</button>
            </div>

            <div class="bg-gray-100 p-4 rounded-md max-h-60 overflow-y-auto">
                <?php if (empty($bookings)): ?>
                    <p class="text-gray-500 text-center">No bookings yet.</p>
                <?php else: ?>
                    <?php foreach ($bookings as $booking): ?>
                        <div class="bg-white p-3 rounded-md mb-3 shadow-md">
                            <p><strong>📍 Turf:</strong> <?= htmlspecialchars($booking['turf']) ?></p>
                            <p><strong>🧑 Name:</strong> <?= htmlspecialchars($booking['name']) ?></p>
                            <p><strong>📞 Phone:</strong> <?= htmlspecialchars($booking['phone']) ?></p>
                            <p><strong>📧 Email:</strong> <?= htmlspecialchars($booking['email']) ?></p>
                            <p><strong>⏳ Hours:</strong> <?= htmlspecialchars($booking['hours']) ?></p>
                            <p><strong>💰 Total:</strong> ₹<?= htmlspecialchars($booking['total_amount']) ?></p>

                            <!-- Delete Button -->
                            <form method="post" class="mt-2">
                                <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                <button type="submit" name="delete" class="bg-red-500 text-white px-4 py-2 rounded-md w-full flex items-center justify-center">
                                    ❌ Delete Booking
                                </button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>


<!-- JavaScript -->
<script>
function openBookingModal() {
    document.getElementById("bookingModal").classList.remove("hidden");
}
function closeBookingModal() {
    document.getElementById("bookingModal").classList.add("hidden");
}
function toggleBookedSlots() {
    let bookedSlots = document.getElementById("booked-slots");
    bookedSlots.classList.toggle("hidden");
}
function updateFee() {
    let turf = document.getElementById("turf");
    let selected = turf.options[turf.selectedIndex];
    document.getElementById("fee").value = selected.getAttribute("data-fee");
    calculateAmount();
}
function calculateAmount() {
    let hours = document.getElementById("hours").value;
    let fee = document.getElementById("fee").value;
    document.getElementById("totalAmount").innerText = hours * fee;
}
</script>


<!-- Turf Images Section -->
<section id="turfs" class="py-20 bg-gray-950 text-white">
    <h2 class="text-4xl font-bold text-center text-yellow-400">🏟️ Turfs Images</h2>
    <p class="text-lg text-center text-gray-300 mt-2">Choose your favorite turf and book a slot!</p>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 px-6 mt-8">
        <!-- Turf 1 -->
        <div class="bg-gray-900 rounded-lg shadow-lg overflow-hidden p-4 mx-4">
            <img src="turf1.jpg" alt="Turf 1" class="w-full h-52 object-cover rounded-lg">
            <div class="mt-4">
                <h3 class="text-xl font-semibold">Turf 1</h3>
                <p class="text-gray-400">Fee: ₹800/hr</p>
            </div>
        </div>

        <!-- Turf 2 -->
        <div class="bg-gray-900 rounded-lg shadow-lg overflow-hidden p-4 mx-4">
            <img src="turf2.jpg" alt="Turf 2" class="w-full h-52 object-cover rounded-lg">
            <div class="mt-4">
                <h3 class="text-xl font-semibold">Turf 2</h3>
                <p class="text-gray-400">Fee: ₹900/hr</p>
            </div>
        </div>

        <!-- Turf 3 -->
        <div class="bg-gray-900 rounded-lg shadow-lg overflow-hidden p-4 mx-4">
            <img src="turf3.webp" alt="Turf 3" class="w-full h-52 object-cover rounded-lg">
            <div class="mt-4">
                <h3 class="text-xl font-semibold">Turf 3</h3>
                <p class="text-gray-400">Fee: ₹700/hr</p>
            </div>
        </div>

        <!-- Turf 4 -->
        <div class="bg-gray-900 rounded-lg shadow-lg overflow-hidden p-4 mx-4">
            <img src="turf4.jpg" alt="Turf 4" class="w-full h-52 object-cover rounded-lg">
            <div class="mt-4">
                <h3 class="text-xl font-semibold">Turf 4</h3>
                <p class="text-gray-400">Fee: ₹950/hr</p>
            </div>
        </div>

        <!-- Turf 5 -->
        <div class="bg-gray-900 rounded-lg shadow-lg overflow-hidden p-4 mx-4">
            <img src="turf5.jpg" alt="Turf 5" class="w-full h-52 object-cover rounded-lg">
            <div class="mt-4">
                <h3 class="text-xl font-semibold">Turf 5</h3>
                <p class="text-gray-400">Fee: ₹850/hr</p>
            </div>
        </div>

        <!-- Turf 6 -->
        <div class="bg-gray-900 rounded-lg shadow-lg overflow-hidden p-4 mx-4">
            <img src="turf6.jpg" alt="Turf 6" class="w-full h-52 object-cover rounded-lg">
            <div class="mt-4">
                <h3 class="text-xl font-semibold">Turf 6</h3>
                <p class="text-gray-400">Fee: ₹750/hr</p>
            </div>
        </div>
    </div>
</section>



<footer class="bg-gray-100 text-black text-center p-4 mt-5 w-full">
    &copy; 2025 Fitness & Sport Ideas. All Rights Reserved.
</footer>



</body>
</html>
