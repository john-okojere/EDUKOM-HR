<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load PHPMailer (Composer autoload)
require __DIR__ . '/vendor/autoload.php'; // If not using composer, manually require the PHPMailer classes here

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method Not Allowed');
}

// Anti-spam honeypot
if (!empty($_POST['website'])) {
    http_response_code(200);
    exit('OK');
}

// Sanitize & validate inputs
$name    = htmlspecialchars(trim($_POST['name'] ?? ''), ENT_QUOTES, 'UTF-8');
$email   = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
$subject = htmlspecialchars(trim($_POST['subject'] ?? ''), ENT_QUOTES, 'UTF-8');
$message = htmlspecialchars(trim($_POST['message'] ?? ''), ENT_QUOTES, 'UTF-8');

if (!$name || !$email || !$message) {
    header('Location: /#contact?sent=0');
    exit;
}

// Configure PHPMailer
$mail = new PHPMailer(true);
try {
    $mail->isSMTP();
    $mail->Host       = 'smtp.yourhost.com';     // ✅ CHANGE THIS
    $mail->SMTPAuth   = true;
    $mail->Username   = 'no-reply@edukom.ng';    // ✅ CHANGE THIS
    $mail->Password   = 'YOUR_SMTP_PASSWORD';    // ✅ CHANGE THIS
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Or ENCRYPTION_SMTPS for port 465
    $mail->Port       = 587;

    $mail->setFrom('no-reply@edukom.ng', 'Edukom HR Website');
    $mail->addAddress('info@edukom.ng', 'Edukom HR');  // ✅ Where messages should go
    $mail->addReplyTo($email, $name);

    $mail->Subject = $subject ?: 'New Contact Form Submission';
    $mail->Body    = "<p><strong>Name:</strong> {$name}</p>
                      <p><strong>Email:</strong> {$email}</p>
                      <p><strong>Message:</strong><br>" . nl2br($message) . "</p>";
    $mail->AltBody = "Name: {$name}\nEmail: {$email}\nMessage:\n{$message}";

    $mail->isHTML(true);
    $mail->send();

    header('Location: /#contact?sent=1');
} catch (Exception $e) {
    error_log("Mailer Error: " . $mail->ErrorInfo);
    header('Location: /#contact?sent=0');
}
exit;
