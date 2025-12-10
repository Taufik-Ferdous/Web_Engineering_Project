<?php
session_start();

// Handle logout
if (isset($_GET['logout'])) {
  session_unset();
  session_destroy();
  header('Location: index.php');
  exit;
}

$login_error = "";

// Handle login form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'login') {
  $email = trim($_POST['email'] ?? '');
  $password = trim($_POST['password'] ?? '');

  // Demo login credentials (you can change these or later move to DB)
  $valid_email = 'admin@easybreak.com';
  $valid_password = '123456';

  if ($email === $valid_email && $password === $valid_password) {
    $_SESSION['user_email'] = $email;

    // PRG pattern to avoid resubmission
    header('Location: index.php');
    exit;
  } else {
    $login_error = "Invalid email or password.";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>EasyBreak Travel - Home</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="index.css" />
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
          <li><a href="index.php" class="nav-link active">Home</a></li>
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
      <a href="#tours-preview" class="btn primary-btn">Book Now</a>
    </div>
  </header>

  <main>
    <!-- Hero Section -->
    <section class="hero">
      <div class="container hero-grid">
        <div class="hero-text">
          <p class="subtitle">Trusted Travel Agency in Bangladesh</p>
          <h1>Explore Your Travel</h1>
          <p class="hero-desc">
            Discover unforgettable journeys, curated experiences, and hidden gems
            across Bangladesh with EasyBreak.
          </p>
          <div class="hero-actions">
            <a href="tours.php" class="btn primary-btn">View Tours</a>
            <a href="contact.php" class="btn ghost-btn">Contact Us</a>
          </div>
        </div>
        <div class="hero-image-wrapper">
          <img
            src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=900&q=80"
            alt="Mountain travel"
            class="hero-image"
          />
        </div>
      </div>
    </section>

    <!-- Choose Your Destination (preview) -->
    <section class="section" id="destinations-preview">
      <div class="container">
        <header class="section-header">
          <h2>Choose Your Destination</h2>
          <p>Discover the most beautiful places to visit across Bangladesh.</p>
        </header>

        <div class="card-grid destination-grid">
          <a href="destination.php?id=coxbazar" class="destination-card">
            <img
              src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQLgfcqUkBbnjtQ21T8FY_vkuzCarfckf-nVQ&s"
              alt="Cox's Bazar Sea Beach"
            />
            <div class="card-body">
              <h3>Cox's Bazar, Chattogram</h3>
              <p>Perfect for beach holidays and sea lovers.</p>
            </div>
          </a>

          <a href="destination.php?id=sylhet" class="destination-card">
            <img
              src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9TjQjsU5jch6qu6atTSi1DxiTq-KBDG8n_g&s"
              alt="Sylhet tea gardens"
            />
            <div class="card-body">
              <h3>Sylhet &amp; Srimangal</h3>
              <p>Green tea gardens, haor, and peaceful countryside.</p>
            </div>
          </a>

          <a href="destination.php?id=bandarban" class="destination-card">
            <img
              src="https://thumbs.dreamstime.com/b/landscape-debotakhum-waterfall-road-bandarban-251564263.jpg"
              alt="Bandarban hills"
            />
            <div class="card-body">
              <h3>Bandarban, Hill Tracts</h3>
              <p>Misty hills and adventurous trekking routes.</p>
            </div>
          </a>
        </div>

        <div class="center">
          <a href="destinations.php" class="btn ghost-btn">View All Destinations</a>
        </div>
      </div>
    </section>

    <!-- Popular Tours (preview) -->
    <section class="section" id="tours-preview">
      <div class="container">
        <header class="section-header">
          <h2>Most Popular Tours in Bangladesh</h2>
          <p>Carefully designed itineraries for beach, hills, and forest lovers.</p>
        </header>

        <div class="card-grid tour-grid">
          <!-- Cox's Bazar Tour -->
          <a href="book.php?tour=coxbazar" class="tour-card-link">
            <article class="tour-card">
              <div class="tour-badge">3 Days</div>
              <h3>Cox’s Bazar Beach Escape</h3>
              <p class="tour-location">Cox's Bazar, Chattogram</p>
              <p class="price">From ৳9,999</p>
              <p>
                Relax by the sea, enjoy sunset views, and explore nearby beaches with a
                comfortable stay.
              </p>
              <span class="tour-cta">Book this tour →</span>
            </article>
          </a>

          <!-- Sylhet Tour -->
          <a href="book.php?tour=sylhet" class="tour-card-link">
            <article class="tour-card">
              <div class="tour-badge">3 Days</div>
              <h3>Sylhet Tea Garden Retreat</h3>
              <p class="tour-location">Sylhet &amp; Srimangal</p>
              <p class="price">From ৳8,500</p>
              <p>
                Visit tea estates, Ratargul Swamp Forest, and taste famous 7-layer tea.
              </p>
              <span class="tour-cta">Book this tour →</span>
            </article>
          </a>

          <!-- Bandarban Tour -->
          <a href="book.php?tour=bandarban" class="tour-card-link">
            <article class="tour-card">
              <div class="tour-badge">4 Days</div>
              <h3>Bandarban Adventure Trail</h3>
              <p class="tour-location">Bandarban Hill Tracts</p>
              <p class="price">From ৳11,500</p>
              <p>
                Trek to viewpoints, visit waterfalls, and experience indigenous culture.
              </p>
              <span class="tour-cta">Book this tour →</span>
            </article>
          </a>
        </div>

        <div class="center">
          <a href="tours.php" class="btn ghost-btn">View All Tours</a>
        </div>
      </div>
    </section>

  </main>

  <footer class="footer">
    <div class="container footer-grid">
      <div>
        <h3>EasyBreak</h3>
        <p>
          Your trusted partner for unforgettable journeys across Bangladesh,
          from city escapes to nature getaways.
        </p>
      </div>
      <div>
        <h4>Quick Links</h4>
        <ul>
          <li><a href="about.html">About</a></li>
          <li><a href="tours.html">Tours</a></li>
          <li><a href="destinations.html">Destinations</a></li>
          <li><a href="blog.php">Blog</a></li>
        </ul>
      </div>
      <div>
        <h4>Contact</h4>
        <p>Email: hello@easybreak.com</p>
        <p>Phone: +88 01234-456789</p>
      </div>
    </div>
    <div class="footer-bottom">
      © 2025 EasyBreak. All rights reserved.
    </div>
  </footer>

  <button class="go-top" data-go-top>↑</button>

  <script src="index.js" defer></script>
</body>
</html>
