<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>EasyBreak Travel - About Us</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="about.css" />
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
    <section class="hero">
      <div class="container">
        <h1>About EasyBreak</h1>
        <p>
          We’re a passionate travel agency helping explorers like you discover
          unforgettable experiences across Bangladesh.
        </p>
      </div>
    </section>

    <section class="section">
      <div class="container about-grid">
        <div>
          <h2>Our Story</h2>
          <p>
            EasyBreak began with a simple idea: traveling across Bangladesh should be easy,
            affordable, and enjoyable for everyone. While planning trips for ourselves and
            our friends, we realized how difficult it was to find reliable information,
            trusted guides, and well-organized tour packages within the country.
          </p>
          <p>
            What started as a small initiative to help people explore local destinations
            has grown into a complete travel service dedicated to showcasing the beauty of
            Bangladesh. From the sea waves of Cox’s Bazar to the green hills of Bandarban,
            from the peaceful tea gardens of Sylhet to the wild charm of the Sundarbans —
            we highlight the most authentic experiences our country has to offer.
          </p>
        </div>

        <div class="card">
          <h3>Why Travel With Us?</h3>
          <ul class="tick-list">
            <li>Experienced local guides</li>
            <li>Handpicked hotels & stays</li>
            <li>Flexible itineraries</li>
            <li>24/7 on-trip support</li>
          </ul>
        </div>
      </div>
    </section>

    <section class="section">
      <div class="container values-grid">
        <article class="card">
          <h3>Personalized Planning</h3>
          <p>
            Every traveler is different. We tailor each itinerary based on your
            interests, pace, and budget.
          </p>
        </article>

        <article class="card">
          <h3>Responsible Travel</h3>
          <p>
            We support local businesses, respect culture, and promote sustainable
            tourism wherever we go.
          </p>
        </article>

        <article class="card">
          <h3>Transparent Pricing</h3>
          <p>
            No hidden fees, no surprises. Just clear, upfront pricing and honest
            recommendations.
          </p>
        </article>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container footer-bottom">
      © 2025 EasyBreak. All rights reserved.
    </div>
  </footer>

  <script src="about.js" defer></script>
</body>
</html>
