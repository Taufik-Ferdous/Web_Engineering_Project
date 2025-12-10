<?php
session_start();
require_once 'config.php'; // use same DB connection as login/book

// Form status messages
$success_msg = "";
$error_msg   = "";

// Keep field values so the form doesn’t go blank on error
$name    = "";
$email   = "";
$phone   = "";
$message = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $message = trim($_POST['message'] ?? '');

    // Validation
    if ($name === '' || $email === '' || $message === '') {
        $error_msg = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_msg = "Please enter a valid email.";
    } else {
        // Logged-in user email (if any)
        $user_email = $_SESSION['user_email'] ?? null;

        // Insert into database
        $stmt = $conn->prepare(
            "INSERT INTO contact_messages (name, email, phone, message, user_email)
             VALUES (?, ?, ?, ?, ?)"
        );

        if ($stmt) {
            $stmt->bind_param("sssss", $name, $email, $phone, $message, $user_email);

            if ($stmt->execute()) {
                $success_msg = "Your message has been sent successfully! We’ll get back to you soon.";

                // Clear form fields after success
                $name = $email = $phone = $message = "";
            } else {
                $error_msg = "Something went wrong while saving your message. Please try again.";
            }

            $stmt->close();
        } else {
            $error_msg = "Failed to prepare database statement.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>EasyBreak Travel - Contact Us</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="contact.css" />
</head>
<body>
  <header class="header" data-header>
    <div class="container">
      <a href="index.php" class="logo">EasyBreak</a>

      <button class="nav-toggle" data-nav-toggle-btn aria-label="Toggle navigation">
        ☰
      </button>

      <nav class="navbar">
        <ul class="nav-list">
          <li><a href="index.php" class="nav-link">Home</a></li>
          <li><a href="tours.php" class="nav-link">Tours</a></li>
          <li><a href="destinations.php" class="nav-link">Destinations</a></li>
          <li><a href="blog.php" class="nav-link">Blog</a></li>
          <li><a href="contact.php" class="nav-link active">Contact Us</a></li>
          <li><a href="about.php" class="nav-link">About Us</a></li>

          <?php if (!empty($_SESSION['user_email'])): ?>
          <?php if (($_SESSION['user_role'] ?? 'user') === 'admin'): ?>
          <li><a href="admin_dashboard.php" class="nav-link">Admin</a></li>
          <?php endif; ?>

          <li class="nav-link nav-user">
          Logged in as <?php echo htmlspecialchars($_SESSION['user_email']); ?>
          </li>
          <li><a href="logout.php" class="nav-link">Logout</a></li>
          <?php else: ?>
          <li><a href="login.php" class="nav-link">Login / Sign Up</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>

  <main class="page">
    <section class="hero">
      <div class="container">
        <h1>Contact Us</h1>
        <p>
          Have questions or ready to start planning your trip? Reach out and our team
          will get back to you within 24 hours.
        </p>
      </div>
    </section>

    <section class="section">
      <div class="container contact-grid">
        <div class="card">
          <h2>Get in Touch</h2>
          <p>
            Fill out the form and we’ll help you customize your dream itinerary.
          </p>

          <?php if ($success_msg): ?>
            <p class="status success"><?php echo htmlspecialchars($success_msg); ?></p>
          <?php endif; ?>

          <?php if ($error_msg): ?>
            <p class="status error"><?php echo htmlspecialchars($error_msg); ?></p>
          <?php endif; ?>

          <form method="POST" action="contact.php">
            <div class="field">
              <label for="name">Full Name</label>
              <input
                type="text"
                id="name"
                name="name"
                required
                value="<?php echo htmlspecialchars($name); ?>"
              />
            </div>

            <div class="field">
              <label for="email">Email Address</label>
              <input
                type="email"
                id="email"
                name="email"
                required
                value="<?php echo htmlspecialchars($email); ?>"
              />
            </div>

            <div class="field">
              <label for="phone">Phone Number</label>
              <input
                type="tel"
                id="phone"
                name="phone"
                value="<?php echo htmlspecialchars($phone); ?>"
              />
            </div>

            <div class="field">
              <label for="message">Message</label>
              <textarea
                id="message"
                name="message"
                rows="4"
                required
              ><?php echo htmlspecialchars($message); ?></textarea>
            </div>

            <button type="submit" class="btn primary-btn">Send Message</button>
          </form>
        </div>

        <div class="card info-card">
          <h2>Contact Details</h2>
          <ul class="info-list">
            <li>
              <strong>Email</strong><br />
              hello@EasyBreak.com
            </li>
            <li>
              <strong>Phone</strong><br />
              +88 01234-456789
            </li>
            <li>
              <strong>Whatsapp</strong><br />
              +88 01234-456789
            </li>
            <li>
              <strong>Office Hours</strong><br />
              Monday–Friday, 9:00 AM – 6:00 PM
            </li>
          </ul>

          <h3>Office Address</h3>
          <p>
            123 Mirpur Lane<br />
            EasyBreak, Dhaka 1216<br />
            Bangladesh
          </p>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container footer-bottom">
      © 2025 EasyBreak. All rights reserved.
    </div>
  </footer>

  <script src="contact.js" defer></script>
</body>
</html>
