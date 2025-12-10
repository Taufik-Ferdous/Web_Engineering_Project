<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>EasyBreak Travel - Destination Details</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="destination.css" />
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
          <li><a href="destinations.php" class="nav-link active">Destinations</a></li>
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
    <section class="hero">
      <div class="container">
        <p class="breadcrumb"><a href="destinations.php">← Back to Destinations</a></p>
        <h1 id="dest-title">Destination Name</h1>
        <p id="dest-subtitle">Destination short description.</p>
      </div>
    </section>

    <section class="section">
      <div class="container detail-grid">
        <div>
          <img id="dest-image" src="" alt="" class="hero-image" />
        </div>
        <div>
          <h2>Overview</h2>
          <p id="dest-overview"></p>

          <h3>Highlights</h3>
          <ul id="dest-highlights" class="tick-list"></ul>

          <h3>Best Time to Visit</h3>
          <p id="dest-best-time"></p>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container info-grid">
        <div class="card">
          <h3>Suggested Duration</h3>
          <p id="dest-duration"></p>
        </div>

        <div class="card">
          <h3>Average Budget</h3>
          <p id="dest-budget"></p>
        </div>

        <div class="card">
          <h3>Recommended Tour</h3>
          <p id="dest-tour"></p>
        </div>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container footer-bottom">
      © 2025 EasyBreak. All rights reserved.
    </div>
  </footer>

  <script src="destination.js" defer></script>
</body>
</html>
