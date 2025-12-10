<?php
session_start();
require_once 'config.php';

// Map tour codes to titles
$tours = [
    'coxbazar'  => 'Cox’s Bazar Beach Escape',
    'sylhet'    => 'Sylhet Tea Garden Retreat',
    'bandarban' => 'Bandarban Adventure Trail',
];

$tour_code = $_GET['tour'] ?? '';
$tour_code = strtolower($tour_code);

$tour_title = $tours[$tour_code] ?? 'Custom Tour Request';

$errors = [];
$success = "";

// Pre-fill if logged in
$prefill_name  = $_SESSION['user_name']  ?? '';
$prefill_email = $_SESSION['user_email'] ?? '';

// Initialize form values
$full_name   = $prefill_name;
$email       = $prefill_email;
$phone       = "";
$travel_date = "";
$people      = 1;
$notes       = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tour_code  = $_POST['tour_code'] ?? '';
    $tour_title = $_POST['tour_title'] ?? 'Custom Tour Request';

    $full_name   = trim($_POST['full_name'] ?? '');
    $email       = trim($_POST['email'] ?? '');
    $phone       = trim($_POST['phone'] ?? '');
    $travel_date = trim($_POST['travel_date'] ?? '');
    $people      = (int)($_POST['people'] ?? 1);
    $notes       = trim($_POST['special_requests'] ?? '');

    if ($full_name === '' || $email === '') {
        $errors[] = "Name and Email are required.";
    }

    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }

    if ($people < 1) {
        $errors[] = "Number of people must be at least 1.";
    }

    if (!$errors) {
        $user_email = $_SESSION['user_email'] ?? null;

        $stmt = $conn->prepare(
          "INSERT INTO bookings (tour_code, tour_title, full_name, email, phone, travel_date, people, special_requests, user_email)
           VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)"
        );

        if ($stmt) {
            $travel_date_db = $travel_date !== '' ? $travel_date : null;

            $stmt->bind_param(
                "ssssssiss",
                $tour_code,
                $tour_title,
                $full_name,
                $email,
                $phone,
                $travel_date_db,
                $people,
                $notes,
                $user_email
            );

            if ($stmt->execute()) {
                $success = "Thank you! Your booking request has been submitted. We will contact you soon.";
                // Reset form fields after success (keep tour info)
                $full_name   = $prefill_name;
                $email       = $prefill_email;
                $phone       = "";
                $travel_date = "";
                $people      = 1;
                $notes       = "";
            } else {
                $errors[] = "Something went wrong while saving your booking. Please try again.";
            }

            $stmt->close();
        } else {
            $errors[] = "Failed to prepare booking request.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Book Tour - EasyBreak</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Main site styles -->
  <link rel="stylesheet" href="index.css" />
  <!-- Booking-specific styles -->
  <link rel="stylesheet" href="book.css" />
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
          <li><a href="contact.php" class="nav-link">Contact Us</a></li>
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
    <section class="section">
      <div class="container booking-wrapper">
        <div class="booking-card">
          <h2>Book: <?php echo htmlspecialchars($tour_title); ?></h2>
          <p class="booking-subtitle">
            Fill in your details and we’ll contact you to confirm your booking and payment.
          </p>

          <?php if ($success): ?>
            <div class="booking-status success">
              <?php echo htmlspecialchars($success); ?>
            </div>
          <?php endif; ?>

          <?php if ($errors): ?>
            <div class="booking-status error">
              <strong>Please fix the following:</strong>
              <ul>
                <?php foreach ($errors as $e): ?>
                  <li><?php echo htmlspecialchars($e); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form method="post" class="booking-form" novalidate>
            <input type="hidden" name="tour_code" value="<?php echo htmlspecialchars($tour_code); ?>" />
            <input type="hidden" name="tour_title" value="<?php echo htmlspecialchars($tour_title); ?>" />

            <div class="form-group">
              <label for="full_name">Full Name *</label>
              <input
                type="text"
                id="full_name"
                name="full_name"
                required
                value="<?php echo htmlspecialchars($full_name); ?>"
              />
            </div>

            <div class="form-group">
              <label for="email">Email *</label>
              <input
                type="email"
                id="email"
                name="email"
                required
                value="<?php echo htmlspecialchars($email); ?>"
              />
            </div>

            <div class="form-group">
              <label for="phone">Phone</label>
              <input
                type="tel"
                id="phone"
                name="phone"
                value="<?php echo htmlspecialchars($phone); ?>"
              />
            </div>

            <div class="form-group">
              <label for="travel_date">Preferred Travel Date</label>
              <input
                type="date"
                id="travel_date"
                name="travel_date"
                value="<?php echo htmlspecialchars($travel_date); ?>"
              />
            </div>

            <div class="form-group">
              <label for="people">Number of People</label>
              <input
                type="number"
                id="people"
                name="people"
                min="1"
                value="<?php echo htmlspecialchars($people); ?>"
              />
            </div>

            <div class="form-group">
              <label for="special_requests">Special Requests (optional)</label>
              <textarea
                id="special_requests"
                name="special_requests"
                rows="3"
              ><?php echo htmlspecialchars($notes); ?></textarea>
            </div>

            <button type="submit" class="btn primary-btn">Submit Booking Request</button>
          </form>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container footer-bottom">
      © 2025 EasyBreak. All rights reserved.
    </div>
  </footer>

  <script src="index.js" defer></script>
</body>
</html>
