CART

CREATE TABLE IF NOT EXISTS cart (
  id INT AUTO_INCREMENT PRIMARY KEY,
  username VARCHAR(255),
  product_id INT,
  added_on TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (product_id) REFERENCES products(id)
);


PRODUCTS

CREATE TABLE IF NOT EXISTS products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255),
  category VARCHAR(100),
  price DECIMAL(10,2)
);


INSERT INTO products (name, category, price) VALUES
('Adjustable Dumbbells', 'Gym Equipment', 1999.99),
('Yoga Mat', 'Fitness Accessories', 499.00),
('Resistance Bands', 'Fitness Accessories', 699.50),
('Cricket Bat', 'Sports Gear', 1299.99),
('Football', 'Sports Gear', 899.00),
('Treadmill', 'Gym Equipment', 35999.00),
('Pull-up Bar', 'Gym Equipment', 1599.75),
('Boxing Gloves', 'Sports Gear', 1299.50),
('Skipping Rope', 'Fitness Accessories', 299.00),
('Kettlebell 10kg', 'Gym Equipment', 1099.00);




DATABASE



CREATE DATABASE IF NOT EXISTS myproject;

USE myproject;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);


ALTER TABLE users ADD email VARCHAR(255) NOT NULL AFTER id;




BMI 


CREATE TABLE bmi_data (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    name VARCHAR(100),
    age INT,
    height_cm FLOAT,
    weight_kg FLOAT,
    bmi FLOAT,
    bmi_category VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);



QUERIES


CREATE TABLE queries (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100),
    name VARCHAR(100),
    email VARCHAR(100),
    issue TEXT
);




🎙️ Final Script for 6-Minute Project Video Presentation – Retro.fit

Hello everyone,

This is my project on fitness and sports, titled Retro.fit — a complete fitness and sports website built using HTML, Tailwind CSS, PHP, MySQL, and JavaScript.

Let me walk you through the website and explain its key features.

🟩 Starting with the Homepage (index.php):

When you land on the homepage, you’ll see a sleek and modern layout. On the top-left corner, we have our brand name — Retro.fit. In the center of the navbar, you’ll find quick links like Home, Events, and Contact. On the right, there are two buttons — Register and Login — which take you to their respective pages.

This homepage sets the tone for the entire website, with a hero section welcoming users and a preview of what's offered.

🟦 Register and Login (register.php & login.php):

The register page allows new users to sign up by creating a username and password. Once registered, they can log in securely through the login page. This user authentication system is connected to a MySQL database, which stores all user credentials securely.

Upon successful login, users are redirected to our main content page — sat6.html.

🟨 Contact Page (contact.php):

This page includes a form where users can submit their queries by entering their name, email, and issue. The form is connected to the database, and the queries are stored under the logged-in username.

There's also a "View Your Query" button that allows logged-in users to see the last query they submitted. If a guest tries to use it, they won't see any results — ensuring personalized access.

🟧 Moving to the Main Page (sat6.html):

This is the core page of our platform — accessible after login.

The Fitness Section offers users insights into workout plans, nutrition, and diet tips. It’s designed to motivate users and help them maintain a balanced fitness routine.

Then we have the Challenges Section, where users can explore different fitness and sports challenges. These are designed to keep users engaged and push their limits.

Next, there's a BMI Calculator, where users can input their height and weight to calculate their Body Mass Index. This helps them understand their health category and track progress.

🟥 Sports Section (Scroll from navbar):

Clicking Sports in the navbar scrolls the user down to the sports section automatically. This section provides an overview of the various sports activities supported and promotes regular physical engagement.

🟪 Turf Booking System (turf.php):

One of the standout features is the Turf Booking System.

Users can view available turfs, select dates and time slots, and book them easily.

All bookings are stored in the database and can be viewed later by the same user.

This booking system is powered by PHP and MySQL and ensures that bookings are user-specific.

🟫 Store Page (store.php):

From the navbar, clicking Store opens a new page with a list of fitness and sports-related products.

Logged-in users can add items to their cart.

Each cart is tied to the user account, so every user sees only their own cart.

The data is fetched dynamically using PHP and MySQL, ensuring seamless shopping experience.

🟨 About Us & Plans Section (aboutus.php & plans.php):

In the About Us section, users can explore video-based courses to help them learn more about fitness and sports techniques.

We also have a Plans and Pricing section featuring 10 customizable plans.

Users can select a plan, enter their details, and submit it.

These plans are saved in the database and can be viewed anytime under that user account.

This makes it easy for users to track what plan they’re on and when their next payment is due.

🟦 Technologies Used:

Throughout the website, we’ve used:

HTML and Tailwind CSS for structure and styling,

PHP for server-side scripting and form handling,

MySQL for data storage and user-specific data management,

and JavaScript for dynamic behavior like scroll-to sections and form validation.

🎯 Summary:

In short, Retro.fit is a one-stop fitness and sports platform where users can:

Register and log in,

View and submit queries,

Explore workout plans, BMI, and challenges,

Book sports turfs and track them,

Shop for fitness gear and manage their cart,

Choose from various pricing plans,

And access video courses.

The project focuses heavily on personalized user experiences — thanks to dynamic PHP + MySQL integration.

