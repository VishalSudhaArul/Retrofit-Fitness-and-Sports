<?php
session_start();
$conn = new mysqli("localhost", "root", "", "myproject");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_SESSION['username'] ?? 'guest';

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirm'])) {
    // Get user's email
    $stmt = $conn->prepare("SELECT email FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $email = ($row = $result->fetch_assoc()) ? $row['email'] : '';

    if (!$email) {
        echo "No email found for user!";
        exit;
    }

    // Get cart items
    $stmt = $conn->prepare("
        SELECT products.name, products.price
        FROM cart
        JOIN products ON cart.product_id = products.id
        WHERE cart.username = ?
    ");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $items = $stmt->get_result();

    $total = 0;
    $message = "Hello $username,\n\nThank you for your purchase on Retro.fit. Here’s your cart summary:\n\n";

    while ($item = $items->fetch_assoc()) {
        $message .= $item['name'] . " - ₹" . number_format($item['price'], 2) . "\n";
        $total += $item['price'];
    }

    $message .= "\nTotal Amount: ₹" . number_format($total, 2);
    $message .= "\n\nStay fit, Stay retro!\nTeam Retro.fit";

    // Send Email
    $subject = "Retro.fit - Payment Confirmation";
    $headers = "From: retrofit@yourdomain.com";

    if (mail($email, $subject, $message, $headers)) {
        echo "<script>alert('Payment Successful! Confirmation sent to your email.'); window.location='store.php';</script>";
    } else {
        echo "Failed to send email.";
    }
}


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // If using Composer

// Create an instance of PHPMailer
$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;
    $mail->Username = 'your_email@gmail.com';  // Your Gmail
    $mail->Password = 'your_16_char_app_password';  // Your app password
    $mail->SMTPSecure = 'tls'; 
    $mail->Port = 587;

    // Recipients
    $mail->setFrom('your_email@gmail.com', 'Retro.fit Store');
    $mail->addAddress($user_email, $username); // Recipient’s email

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Payment Confirmation - Retro.fit Store';
    $mail->Body = "Hi <b>$username</b>,<br>Your payment was successful.<br><br><b>Order Details:</b><br>$orderDetails<br><br>Thank you for shopping with us!";

    $mail->send();
    echo "<script>alert('Payment successful! Confirmation email sent.');</script>";
} catch (Exception $e) {
    echo "<script>alert('Payment done, but email failed: {$mail->ErrorInfo}');</script>";
}



?>
