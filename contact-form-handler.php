<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

require 'vendor/autoload.php'; // Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Check if the form was submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars(trim($_POST['contactName']));
    $email = filter_var(trim($_POST['contactEmail']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['contactSubject']));
    $message = htmlspecialchars(trim($_POST['contactMessage']));

    // Simple validation (you can add more validation as needed)
    if (empty($name) || empty($email) || empty($message)) {
        echo "All fields are required.";
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
        exit;
    }

    // Create PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // SMTP server configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Replace with your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'kaustubhsrv@gmail.com'; // Replace with your email address
        $mail->Password = '23@$azpqR'; // Replace with your app password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Sender and recipient
        $mail->setFrom($email, $name); // Sender's email and name
        $mail->addAddress('kaustubhsrv@example.com'); // Replace with your email address

        // Email content
        $mail->isHTML(false); // Plain text email
        $mail->Subject = $subject ?: 'No Subject'; // Fallback if subject is empty
        $mail->Body = "Name: $name\nEmail: $email\n\nMessage:\n$message";

        // Send the email
        $mail->send();
        echo "Success"; // Success response for AJAX
    } catch (Exception $e) {
        echo "Error sending email: {$mail->ErrorInfo}";
    }
} else {
    echo "Invalid request.";
}
?>
