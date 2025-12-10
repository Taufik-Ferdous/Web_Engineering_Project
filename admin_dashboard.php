<?php
session_start();
require_once 'config.php';

if (empty($_SESSION['user_email']) || ($_SESSION['user_role'] ?? 'user') !== 'admin') {
    header('Location: login.php');
    exit;
}

// Quick counts
$count_bookings = $conn->query("SELECT COUNT(*) AS c FROM bookings")->fetch_assoc()['c'] ?? 0;
$count_pending  = $conn->query("SELECT COUNT(*) AS c FROM bookings WHERE status='pending'")->fetch_assoc()['c'] ?? 0;
$count_messages = $conn->query("SELECT COUNT(*) AS c FROM contact_messages")->fetch_assoc()['c'] ?? 0;
$count_unread   = $conn->query("SELECT COUNT(*) AS c FROM contact_messages WHERE is_read=0")->fetch_assoc()['c'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard - EasyBreak</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="admin.css">
</head>
<body>
  <header class="header" data-header>
    <div class="container">
      <a href="index.php" class="logo">EasyBreak</a>
      <nav class="navbar">
        <ul class="nav-list">
          <li><a href="index.php" class="nav-link">Home</a></li>
          <li><span class="nav-link">Admin Panel</span></li>
          <li class="nav-link nav-user">
            Admin: <?php echo htmlspecialchars($_SESSION['user_email']); ?>
          </li>
          <li><a href="logout.php" class="nav-link">Logout</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <main class="page admin-page">
    <div class="container admin-wrapper">
      <div class="admin-nav">
        <a href="admin_dashboard.php" class="active">Overview</a>
        <a href="admin_bookings.php">Bookings</a>
        <a href="admin_contacts.php">Contact Messages</a>
      </div>

      <div class="admin-card">
        <h2>Overview</h2>
        <p class="admin-meta">Quick summary of your current bookings and messages.</p>

        <ul>
          <li><strong>Total bookings:</strong> <?php echo $count_bookings; ?></li>
          <li><strong>Pending bookings:</strong> <?php echo $count_pending; ?></li>
          <li><strong>Total messages:</strong> <?php echo $count_messages; ?></li>
          <li><strong>Unread messages:</strong> <?php echo $count_unread; ?></li>
        </ul>
      </div>
    </div>
  </main>
</body>
</html>
