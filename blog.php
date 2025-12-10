<?php
session_start();

// Simple backend: blog posts stored in a PHP array WITH images
$posts = [
  [
    "date" => "April 2, 2025",
    "category" => "Cox's Bazar · Beach",
    "title" => "A First-Timer’s Guide to Cox’s Bazar",
    "excerpt" => "Planning your first trip to Cox’s Bazar? Here’s how to plan your days, which beaches to visit, and how to enjoy the sea without overspending.",
    "image" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQLgfcqUkBbnjtQ21T8FY_vkuzCarfckf-nVQ&s"
  ],
  [
    "date" => "March 20, 2025",
    "category" => "Sylhet & Srimangal · Nature",
    "title" => "Tea Gardens, Haor & 7-Layer Tea in Sylhet",
    "excerpt" => "Sylhet and Srimangal are perfect for a calm, green escape. We cover Ratargul, Lalakhal, tea estates, and the famous 7-layer tea.",
    "image" => "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9TjQjsU5jch6qu6atTSi1DxiTq-KBDG8n_g&s"
  ],
  [
    "date" => "March 5, 2025",
    "category" => "Bandarban · Hills",
    "title" => "Bandarban for Beginners: Nilgiri, Nilachal & Beyond",
    "excerpt" => "Want to experience the hill tracts but don’t know where to start? This guide explains routes, viewpoints, and how to plan a 3–4 day Bandarban trip.",
    "image" => "https://thumbs.dreamstime.com/b/landscape-debotakhum-waterfall-road-bandarban-251564263.jpg"
  ],
  [
    "date" => "February 18, 2025",
    "category" => "Sundarbans · Wildlife",
    "title" => "Sundarbans Boat Tour: What You Should Know",
    "excerpt" => "A Sundarbans tour is unlike any other trip in Bangladesh. Learn what to pack, how the daily routine works, and how to travel responsibly.",
    "image" => "https://upload.wikimedia.org/wikipedia/commons/thumb/2/23/Sundarban_Tiger.jpg/1200px-Sundarban_Tiger.jpg"
  ],
  [
    "date" => "February 1, 2025",
    "category" => "Budget Travel · Students",
    "title" => "Student Budget Trips: Explore Bangladesh for Less",
    "excerpt" => "On a tight budget? Here are tips on transport, group sharing, off-season travel, and choosing EasyBreak packages that fit student wallets.",
    "image" => "https://www.eziholiday.com/blog/wp-content/uploads/2020/01/College-Student-Tour.jpg"
  ],
  [
    "date" => "January 15, 2025",
    "category" => "Dhaka · Culture",
    "title" => "Old Dhaka in One Day: Food, Culture & History",
    "excerpt" => "Even if you live in Dhaka, Old Dhaka feels like a different world. Here’s a one-day plan for food, history, and culture without getting overwhelmed.",
    "image" => "https://www.tbsnews.net/sites/default/files/styles/big_3/public/images/2021/01/01/not_just_biriyanis_old_dhaka_has_a_legacy_of_afternoon_snacks_too.jpg"
  ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>EasyBreak - Travel Blog Bangladesh</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="blog.css" />
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
          <li><a href="blog.php" class="nav-link active">Blog</a></li>
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
        <h1>Travel Stories & Guides from Bangladesh</h1>
        <p>
          Read real stories, guides, and tips about exploring Bangladesh –
          from the waves of Cox’s Bazar to the tea gardens of Sylhet, the hills
          of Bandarban, and the wild Sundarbans.
        </p>
      </div>
    </section>

    <section class="section">
      <div class="container blog-grid">
        <?php foreach ($posts as $post): ?>
          <article class="post">
            <img
              src="<?php echo htmlspecialchars($post['image']); ?>"
              alt="<?php echo htmlspecialchars($post['title']); ?>"
              class="post-img"
            />
            <p class="meta">
              <?php echo htmlspecialchars($post["date"]); ?> ·
              <?php echo htmlspecialchars($post["category"]); ?>
            </p>
            <h2><?php echo htmlspecialchars($post["title"]); ?></h2>
            <p><?php echo htmlspecialchars($post["excerpt"]); ?></p>
          </article>
        <?php endforeach; ?>
      </div>
    </section>
  </main>

  <footer class="footer">
    <div class="container footer-bottom">
      © 2025 EasyBreak. All rights reserved.
    </div>
  </footer>

  <script src="blog.js" defer></script>
</body>
</html>
