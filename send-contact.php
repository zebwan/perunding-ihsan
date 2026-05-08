<?php
// Basic security: only accept POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header('Location: contact.html');
  exit;
}

// Collect form fields
$name         = trim($_POST['name'] ?? '');
$organisation = trim($_POST['organisation'] ?? '');
$email        = trim($_POST['email'] ?? '');
$phone        = trim($_POST['phone'] ?? '');
$projectType  = trim($_POST['project-type'] ?? '');
$location     = trim($_POST['location'] ?? '');
$message      = trim($_POST['message'] ?? '');

// Simple validation – you can extend if needed
if ($name === '' || $email === '' || $message === '') {
  $error = 'Please fill in the required fields.';
}

// Email config
$to      = 'azmiali89@gmail.com'; // your uncle's email
$subject = 'Website enquiry from Perunding Ihsan';

// Build email body
$bodyLines = [
  "A new enquiry was submitted from the Perunding Ihsan website:",
  "",
  "Name:          {$name}",
  "Organisation:  {$organisation}",
  "Email:         {$email}",
  "Phone:         {$phone}",
  "Project type:  {$projectType}",
  "Location:      {$location}",
  "",
  "Message:",
  $message,
  "",
  "----",
  "Sent on: " . date('d-m-Y H:i'),
];

$body = implode("\n", $bodyLines);

// Email headers
// Tip: replace no-reply@yourdomain.com with an email under your own domain
$fromAddress = 'no-reply@yourdomain.com';

$headers  = "From: Perunding Ihsan Website <{$fromAddress}>\r\n";
if ($email !== '') {
  $headers .= "Reply-To: {$email}\r\n";
}
$headers .= "X-Mailer: PHP/" . phpversion();

// Send email (if no validation error)
$sent = false;
if (empty($error)) {
  $sent = @mail($to, $subject, $body, $headers);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Enquiry status – Perunding Ihsan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <style>
    body{
      margin:0;
      padding:0;
      font-family:system-ui,-apple-system,BlinkMacSystemFont,"Segoe UI",sans-serif;
      background:#020617;
      color:#f9fafb;
      display:flex;
      align-items:center;
      justify-content:center;
      min-height:100vh;
    }
    .card{
      max-width:440px;
      width:100%;
      background:#0b1020;
      border-radius:18px;
      padding:22px 22px 18px;
      box-shadow:0 22px 55px rgba(0,0,0,0.7);
      border:1px solid rgba(55,65,81,0.9);
      text-align:left;
    }
    h1{
      margin:0 0 10px;
      font-size:1.4rem;
    }
    p{
      margin:0 0 8px;
      font-size:.95rem;
      line-height:1.6;
    }
    .btn{
      display:inline-flex;
      margin-top:12px;
      padding:8px 16px;
      border-radius:999px;
      background:linear-gradient(135deg,#f97316,#fde047);
      color:#111827;
      font-size:.8rem;
      font-weight:600;
      text-decoration:none;
      letter-spacing:.16em;
      text-transform:uppercase;
    }
  </style>
</head>
<body>
  <div class="card">
    <?php if (!empty($error)): ?>
      <h1>There’s a problem with the form.</h1>
      <p><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></p>
      <p>Please go back and check your details.</p>
    <?php elseif ($sent): ?>
      <h1>Thank you for your enquiry.</h1>
      <p>Your message has been sent to Perunding Ihsan.</p>
      <p>The team will review the details and respond using the contact information you provided.</p>
    <?php else: ?>
      <h1>Unable to send your message.</h1>
      <p>The email could not be sent. Please try again later or contact the office directly using the phone numbers on the Contact page.</p>
    <?php endif; ?>

    <a class="btn" href="contact.html">Back to Contact page</a>
  </div>
</body>
</html>
