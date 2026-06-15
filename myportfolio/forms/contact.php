<?php
/**
 * Requires the "PHP Email Form" library.
 * The "PHP Email Form" library is available only in the pro version of the template.
 * The library should be uploaded to: vendor/php-email-form/php-email-form.php
 * For more info and help: https://bootstrapmade.com/php-email-form/
 */

// Replace contact@example.com with your real receiving email address
$receiving_email_address = 'zainkhankhattak3@gmail.com';

// Ensure the library exists before including it
if (file_exists($php_email_form = '../assets/vendor/php-email-form/php-email-form.php')) {
    include($php_email_form);
} else {
    die('Unable to load the "PHP Email Form" Library!');
}

// Check if the form is submitted via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and validate input data
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = filter_var(trim($_POST['subject']), FILTER_SANITIZE_STRING);
    $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);

    // Basic validation to check if all fields are filled
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        die('Please complete all fields.');
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die('Please provide a valid email address.');
    }

    // Create the contact form instance
    $contact = new PHP_Email_Form;
    $contact->ajax = true;

    // Set up the email details
    $contact->to = $receiving_email_address;
    $contact->from_name = $name;
    $contact->from_email = $email;
    $contact->subject = $subject;

    // Uncomment below code if you want to use SMTP to send emails. You need to enter your correct SMTP credentials
    /*
    $contact->smtp = array(
      'host' => 'example.com',
      'username' => 'example',
      'password' => 'pass',
      'port' => '587'
    );
    */

    // Add message content to the email
    $contact->add_message($name, 'From');
    $contact->add_message($email, 'Email');
    $contact->add_message($message, 'Message', 10);

    // Send the email and return the result
    $send_status = $contact->send();

    if ($send_status) {
        echo 'Your message has been sent successfully!';
    } else {
        echo 'Failed to send your message. Please try again later.';
    }
} else {
    // If the form is not submitted via POST
    echo 'Invalid request.';
}
?>
