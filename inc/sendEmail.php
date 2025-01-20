<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../vendor/autoload.php'; // Include PHPMailer

// Replace this with your own email address
$siteOwnersEmail = 'kaustubhsrv@gmail.com';

if ($_POST) {
    $name = trim(stripslashes($_POST['contactName']));
    $email = trim(stripslashes($_POST['contactEmail']));
    $subject = trim(stripslashes($_POST['contactSubject']));
    $contact_message = trim(stripslashes($_POST['contactMessage']));

    // Simple validation
    $errors = [];
    if (strlen($name) < 2) {
        $errors['name'] = "Please enter your name.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Please enter a valid email address.";
    }
    if (strlen($contact_message) < 15) {
        $errors['message'] = "Please enter a message with at least 15 characters.";
    }

    if (empty($errors)) {
        $mail = new PHPMailer(true);
        try {
            // SMTP configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'kaustubhsrv@gmail.com'; // Your Gmail address
            $mail->Password = 'vvig pwfz mses wyoj';    // Gmail app password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Email headers and content
            $mail->setFrom($email, $name);
            $mail->addAddress($siteOwnersEmail); // Your email address to receive the message
            $mail->Subject = $subject ?: 'Contact Form Submission';
            $mail->Body = "Name: $name\nEmail: $email\n\nMessage:\n$contact_message";

            // Send the email
            $mail->send();
            echo "OK";
        } catch (Exception $e) {
            echo "Error sending email: {$mail->ErrorInfo}";
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "<br />";
        }
    }
} else {
    echo "Invalid request.";
}
