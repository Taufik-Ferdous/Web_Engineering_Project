<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>EasyBreak Travel - Destinations</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="destinations.css" />
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
        <h1>Destinations</h1>
        <p>Browse our most popular destinations and learn more about each one.</p>
      </div>
    </section>

    <section class="section">
      <div class="container card-grid">

        <!-- Cox's Bazar -->
        <a href="destination.php?id=coxbazar" class="card">
          <img
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQLgfcqUkBbnjtQ21T8FY_vkuzCarfckf-nVQ&s"
            alt="Cox's Bazar Sea Beach"
          />
          <div class="card-body">
            <h2>Cox's Bazar, Chattogram</h2>
            <p>World’s longest natural sea beach with vibrant coastal life.</p>
          </div>
        </a>

        <!-- Sylhet -->
        <a href="destination.php?id=sylhet" class="card">
          <img
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9TjQjsU5jch6qu6atTSi1DxiTq-KBDG8n_g&s"
            alt="Sylhet tea gardens"
          />
          <div class="card-body">
            <h2>Sylhet &amp; Srimangal</h2>
            <p>Tea gardens, rolling hills, and serene haor wetlands.</p>
          </div>
        </a>

        <!-- Bandarban -->
        <a href="destination.php?id=bandarban" class="card">
          <img
            src="https://thumbs.dreamstime.com/b/landscape-debotakhum-waterfall-road-bandarban-251564263.jpg"
            alt="Bandarban hills"
          />
          <div class="card-body">
            <h2>Bandarban, Hill Tracts</h2>
            <p>Misty hills, tribal culture, and adventurous trekking trails.</p>
          </div>
        </a>

        <!-- Sundarbans -->
        <a href="destination.php?id=sundarbans" class="card">
          <img
            src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/23/Sundarban_Tiger.jpg/1200px-Sundarban_Tiger.jpg"
            alt="Sundarbans mangrove forest"
          />
          <div class="card-body">
            <h2>Sundarbans, Khulna</h2>
            <p>World’s largest mangrove forest and home of the Royal Bengal Tiger.</p>
          </div>
        </a>

      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container footer-bottom">
      © 2025 EasyBreak. All rights reserved.
    </div>
  </footer>

  <script src="destinations.js" defer></script>
</body>
</html>
