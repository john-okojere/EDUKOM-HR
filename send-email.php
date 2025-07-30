<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = "info@edukom.ng";  // Change this to your actual receiving email
    $subject = "New Contact Form Submission";

    $name = htmlspecialchars($_POST["name"]);
    $email = htmlspecialchars($_POST["email"]);
    $subject_input = htmlspecialchars($_POST["subject"]);
    $message = htmlspecialchars($_POST["message"]);

    $fullMessage = "Name: $name\nEmail: $email\nSubject: $subject_input\n\nMessage:\n$message";

    $headers = "From: $email\r\n" .
               "Reply-To: $email\r\n" .
               "X-Mailer: PHP/" . phpversion();

    if (mail($to, $subject, $fullMessage, $headers)) {
        echo "<script>alert('Message sent successfully!'); window.location.href = 'index.html';</script>";
    } else {
        echo "<script>alert('Error sending message. Please try again.'); window.history.back();</script>";
    }
}
?>
