<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Retro.fit - Home</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    html {
      scroll-behavior: smooth;
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Navbar -->
  <nav class="bg-white shadow-md py-4 px-8 flex justify-between items-center">
    <!-- Left: Logo -->
    <div class="text-2xl font-bold text-blue-600">
      <a href="sat6.html">Retro.fit</a>
    </div>

    <!-- Center: Menu -->
    <ul class="flex space-x-8 text-lg font-medium">
      <li><a href="sat6.html" class="text-gray-700 hover:text-blue-600 transition">Home</a></li>
      <li><a href="#eventsSection" onclick="scrollToEvents()" class="text-gray-700 hover:text-blue-600 transition">Events</a></li>
      <li><a href="contact.php" class="text-gray-700 hover:text-blue-600 transition">Contact</a></li>
    </ul>

    <!-- Right: Buttons -->
    <div class="flex space-x-4">
      <a href="register.php" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Register</a>
      <a href="login.php" class="bg-gray-800 text-white px-4 py-2 rounded hover:bg-gray-900 transition">Login</a>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="text-center py-20 bg-gradient-to-r from-blue-100 to-blue-200">
    <h1 class="text-5xl font-bold text-gray-800 mb-6">Welcome to Retro.fit</h1>
    <p class="text-xl text-gray-600 mb-8 px-4 md:px-0">
      Your ultimate destination for fitness, sports, and a healthy lifestyle.  
      Join our community, take part in exciting challenges, and achieve your fitness goals.
    </p>

    <!-- Feature Cards -->
    <div class="flex flex-col md:flex-row justify-center items-center gap-6 px-6 md:px-0 mb-12">
      <div class="bg-white p-6 rounded-xl shadow-md w-full md:w-1/4">
        <h2 class="text-2xl font-semibold text-blue-600 mb-2">🏋️‍♂️ Fitness</h2>
        <p class="text-gray-600">Track your workouts, stay motivated, and become your best self.</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-md w-full md:w-1/4">
        <h2 class="text-2xl font-semibold text-blue-600 mb-2">⚽ Sports</h2>
        <p class="text-gray-600">Book turfs, join teams, and enjoy sports like never before.</p>
      </div>
      <div class="bg-white p-6 rounded-xl shadow-md w-full md:w-1/4">
        <h2 class="text-2xl font-semibold text-blue-600 mb-2">🔥 Challenges</h2>
        <p class="text-gray-600">Take on exciting fitness challenges and win rewards.</p>
      </div>
    </div>

    <!-- Call to Action -->
    <a href="register.php" class="inline-block bg-blue-600 text-white px-8 py-3 rounded-full text-lg font-semibold hover:bg-blue-700 transition">
      Get Started Now
    </a>
  </section>

  <!-- Events Section -->
  <section id="eventsSection" class="py-20 bg-white">
    <h2 class="text-4xl font-bold text-center text-blue-700 mb-10">Upcoming Events</h2>
    <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 px-6">

      <!-- Event 1 -->
      <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-xl transition">
        <h3 class="text-2xl font-semibold text-gray-800 mb-2">🏃 5K Power Run</h3>
        <p class="text-gray-600">Push your limits in our high-energy early morning city run challenge.</p>
      </div>

      <!-- Event 2 -->
      <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-xl transition">
        <h3 class="text-2xl font-semibold text-gray-800 mb-2">💪 Muscle-Up Masterclass</h3>
        <p class="text-gray-600">Advanced training by certified trainers focusing on strength & endurance.</p>
      </div>

      <!-- Event 3 -->
      <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-xl transition">
        <h3 class="text-2xl font-semibold text-gray-800 mb-2">⚽ Turf Football League</h3>
        <p class="text-gray-600">Join a 6-week football tournament with prizes, stats tracking, and more.</p>
      </div>

      <!-- Event 4 -->
      <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-xl transition">
        <h3 class="text-2xl font-semibold text-gray-800 mb-2">🧘 Sunrise Yoga Retreat</h3>
        <p class="text-gray-600">Detox your mind and body in a 3-day outdoor wellness experience.</p>
      </div>

      <!-- Event 5 -->
      <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-xl transition">
        <h3 class="text-2xl font-semibold text-gray-800 mb-2">🚴 Spin & Sweat Challenge</h3>
        <p class="text-gray-600">Indoor cycling battles with team-based competitions and music themes.</p>
      </div>

      <!-- Event 6 -->
      <div class="bg-gray-100 p-6 rounded-xl shadow hover:shadow-xl transition">
        <h3 class="text-2xl font-semibold text-gray-800 mb-2">🥊 Boxing Bootcamp</h3>
        <p class="text-gray-600">Get trained like a pro in our intense fitness + self-defense boxing series.</p>
      </div>
      
    </div>
  </section>

  <!-- JS Scroll Function -->
  <script>
    function scrollToEvents() {
      document.getElementById("eventsSection").scrollIntoView({ behavior: "smooth" });
    }
  </script>

  <!-- Footer -->
<footer class="bg-black text-white py-12 px-6 md:px-20">
  <div class="max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-4 gap-8">

    <!-- Description -->
    <div>
      <h3 class="text-2xl font-bold mb-4">Retro.fit</h3>
      <p class="text-sm text-gray-400">
        At Retro.fit, we make workouts fun, sports accessible, and health a daily habit. Book turfs, join fitness challenges, track progress, and #LevelUpYourGame
      </p>
    </div>

    <!-- Links Column 1 -->
    <div class="text-sm space-y-2">
      <a href="#" class="block text-gray-300 hover:text-white">Retro.fit for Business</a>
      <a href="#" class="block text-gray-300 hover:text-white">Retro.fit Franchise</a>
      <a href="#" class="block text-gray-300 hover:text-white">Corporate Partnerships</a>
      <a href="#" class="block text-gray-300 hover:text-white">Turf Pass Network</a>
      <a href="#" class="block text-gray-300 hover:text-white">T&C for Business</a>
    </div>

    <!-- Links Column 2 -->
    <div class="text-sm space-y-2">
      <a href="#" class="block text-gray-300 hover:text-white">Partner.fit</a>
      <a href="contact.php" class="block text-gray-300 hover:text-white">Contact Us</a>
      <a href="#" class="block text-gray-300 hover:text-white">Blogs</a>
      <a href="#" class="block text-gray-300 hover:text-white">Privacy Policy</a>
      <a href="retro_bmi.php" class="block text-gray-300 hover:text-white">BMI Calculator</a>
    </div>

    <!-- App Links + Socials -->
    <div class="space-y-4">
      <div class="space-y-2">
        <a href="#" class="block">
          <img src="https://developer.apple.com/assets/elements/badges/download-on-the-app-store.svg" alt="App Store" class="w-36">
        </a>
        <a href="#" class="block">
          <img src="https://upload.wikimedia.org/wikipedia/commons/7/78/Google_Play_Store_badge_EN.svg" alt="Google Play" class="w-36">
        </a>
      </div>
      <div class="flex space-x-4 mt-4 text-gray-400 text-xl">
        <a href="#"><i class="fab fa-facebook-f hover:text-white"></i></a>
        <a href="#"><i class="fab fa-x-twitter hover:text-white"></i></a>
        <a href="#"><i class="fab fa-instagram hover:text-white"></i></a>
        <a href="#"><i class="fab fa-youtube hover:text-white"></i></a>
        <a href="#"><i class="fab fa-linkedin-in hover:text-white"></i></a>
      </div>
    </div>

  </div>
</footer>

<!-- Font Awesome CDN -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>


</body>
</html>
