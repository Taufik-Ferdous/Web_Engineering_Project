<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Tours - EasyBreak</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="tours.css">
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
        <li><a href="tours.php" class="nav-link active">Tours</a></li>
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
    <div class="container">

      <header class="section-header">
        <h2>Explore Our Tours</h2>
        <p>Choose from our most popular and detailed travel packages across Bangladesh.</p>
      </header>

      <div class="card-grid tour-grid">

        <!-- Cox’s Bazar -->
        <a href="book.php?tour=coxbazar" class="tour-card-link">
          <article class="tour-card">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQLgfcqUkBbnjtQ21T8FY_vkuzCarfckf-nVQ&s" class="tour-img" alt="Cox’s Bazar">
            <div class="tour-badge">3 Days</div>
            <h3>Cox’s Bazar Beach Escape</h3>
            <p class="tour-location">Cox's Bazar, Chattogram</p>
            <p class="price">From ৳9,999</p>
            <p>
              Enjoy the longest sea beach in the world, sunsets, fresh seafood, and nearby attractions.
            </p>
            <span class="tour-cta">Book this tour →</span>
          </article>
        </a>

        <!-- Sylhet -->
        <a href="book.php?tour=sylhet" class="tour-card-link">
          <article class="tour-card">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9TjQjsU5jch6qu6atTSi1DxiTq-KBDG8n_g&s" class="tour-img" alt="Sylhet">
            <div class="tour-badge">3 Days</div>
            <h3>Sylhet Tea Garden Retreat</h3>
            <p class="tour-location">Sylhet & Srimangal</p>
            <p class="price">From ৳8,500</p>
            <p>
              Explore tea estates, Ratargul swamp forest, Lalakhal blue waters, and local culture.
            </p>
            <span class="tour-cta">Book this tour →</span>
          </article>
        </a>

        <!-- Bandarban -->
        <a href="book.php?tour=bandarban" class="tour-card-link">
          <article class="tour-card">
            <img src="https://thumbs.dreamstime.com/b/landscape-debotakhum-waterfall-road-bandarban-251564263.jpg" class="tour-img" alt="Bandarban">
            <div class="tour-badge">4 Days</div>
            <h3>Bandarban Adventure Trail</h3>
            <p class="tour-location">Bandarban Hill Tracts</p>
            <p class="price">From ৳11,500</p>
            <p>
              Visit Nilgiri, Nilachal, Chimbuk Hill, Golden Temple and experience indigenous lifestyle.
            </p>
            <span class="tour-cta">Book this tour →</span>
          </article>
        </a>

        <!-- Sundarbans -->
        <a href="book.php?tour=sundarbans" class="tour-card-link">
          <article class="tour-card">
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/23/Sundarban_Tiger.jpg/1200px-Sundarban_Tiger.jpg" class="tour-img" alt="Sundarbans">
            <div class="tour-badge">3 Days</div>
            <h3>Sundarbans Mangrove Expedition</h3>
            <p class="tour-location">Khulna · Sundarbans</p>
            <p class="price">From ৳12,000</p>
            <p>
              Explore the world's largest mangrove forest, canals, wildlife, and boat safari.
            </p>
            <span class="tour-cta">Book this tour →</span>
          </article>
        </a>

        <!-- Kuakata -->
        <a href="book.php?tour=kuakata" class="tour-card-link">
          <article class="tour-card">
            <img src="https://media.istockphoto.com/id/614125116/photo/sunset-at-kuakata-beach.jpg?s=612x612&w=0&k=20&c=FAaeswcA2TteCBARQky3JQYAOBAMBcYSt_OhXMfcTi4=" alt="Kuakata">
            <div class="tour-badge">2 Days</div>
            <h3>Kuakata Sunrise to Sunset Tour</h3>
            <p class="tour-location">Kuakata, Patuakhali</p>
            <p class="price">From ৳7,000</p>
            <p>
              Watch both sunrise and sunset over the sea, visit Rakhine tribes and eco-park.
            </p>
            <span class="tour-cta">Book this tour →</span>
          </article>
        </a>

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
