<?php
// --- Kanisos Book a Table PHP Handler ---

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo 'Error: Only POST requests are allowed.';
  exit;
}

// Receiving email address must be set to a real address
// Set your real receiving email address below
$receiving_email_address = 'nicksterg9@gmail.com';
if ($receiving_email_address === 'contact@example.com' || !filter_var($receiving_email_address, FILTER_VALIDATE_EMAIL)) {
  http_response_code(500);
  echo 'Error: The receiving email address is not set. Please update book-a-table.php.';
  exit;
}

// Check for required PHP Email Form library
$php_email_form = '../assets/vendor/php-email-form/php-email-form.php';
if (!file_exists($php_email_form)) {
  http_response_code(500);
  echo 'Error: Unable to load the PHP Email Form library. Please upload it to assets/vendor/php-email-form/php-email-form.php.';
  exit;
}
include($php_email_form);

$book_a_table = new PHP_Email_Form;
$book_a_table->ajax = true;
$book_a_table->to = $receiving_email_address;
$book_a_table->from_name = $_POST['name'] ?? '';
$book_a_table->from_email = $_POST['email'] ?? '';
$book_a_table->subject = "New table booking request from the website";

// Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
/*
$book_a_table->smtp = array(
  'host' => 'example.com',
  'username' => 'example',
  'password' => 'pass',
  'port' => '587'
);
*/

$book_a_table->add_message($_POST['name'] ?? '', 'Name');
$book_a_table->add_message($_POST['email'] ?? '', 'Email');
$book_a_table->add_message($_POST['phone'] ?? '', 'Phone', 4);
$book_a_table->add_message($_POST['date'] ?? '', 'Date', 4);
$book_a_table->add_message($_POST['time'] ?? '', 'Time', 4);
$book_a_table->add_message($_POST['people'] ?? '', '# of people', 1);
if (isset($_POST['occasion'])) {
  $book_a_table->add_message($_POST['occasion'], 'Occasion');
}
$book_a_table->add_message($_POST['message'] ?? '', 'Message');

echo $book_a_table->send();
?>
