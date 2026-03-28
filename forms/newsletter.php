<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  exit('Method Not Allowed');
}

$receiving_email_address = 'info@kanisos.be';

$email = trim($_POST['email'] ?? '');

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  http_response_code(400);
  exit('Please provide a valid email address.');
}

$subject = 'New Subscription: ' . $email;
$body = "Newsletter subscription request\n\nEmail: {$email}\n";
$headers = [
  'From: ' . $email,
  'Reply-To: ' . $email,
  'Content-Type: text/plain; charset=UTF-8'
];

if (mail($receiving_email_address, $subject, $body, implode("\r\n", $headers))) {
  exit('OK');
}

http_response_code(500);
exit('Unable to process your subscription right now.');
?>
