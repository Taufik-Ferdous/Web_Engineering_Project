<?php
session_start();
require_once 'config.php';

if (empty($_SESSION['user_email']) || ($_SESSION['user_role'] ?? 'user') !== 'admin') {
    header('Location: login.php');
    exit;
}

$status_filter = $_GET['status'] ?? 'all';

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id     = (int)($_POST['id'] ?? 0);

    if ($id > 0) {
        if ($action === 'approve') {
            $stmt = $conn->prepare("UPDATE bookings SET status='approved' WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        } elseif ($action === 'cancel') {
            $stmt = $conn->prepare("UPDATE bookings SET status='cancelled' WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        } elseif ($action === 'delete') {
            $stmt = $conn->prepare("DELETE FROM bookings WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
    }

    header("Location: admin_bookings.php?status=" . urlencode($status_filter));
    exit;
}

// Build query
$sql = "SELECT * FROM bookings";
$params = [];
$types  = "";

if (in_array($status_filter, ['pending','approved','cancelled'], true)) {
    $sql .= " WHERE status = ?";
    $types = "s";
    $params[] = $status_filter;
}

$sql .= " ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
$bookings = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Bookings</title>
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
          <li><a href="admin_dashboard.php" class="nav-link">Admin Panel</a></li>
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
        <a href="admin_dashboard.php">Overview</a>
        <a href="admin_bookings.php" class="active">Bookings</a>
        <a href="admin_contacts.php">Contact Messages</a>
      </div>

      <div class="admin-card">
        <h2>Bookings</h2>
        <p class="admin-meta">Manage tour booking requests.</p>

        <p style="margin-bottom:0.75rem;">
          Filter:
          <a href="?status=all">All</a> |
          <a href="?status=pending">Pending</a> |
          <a href="?status=approved">Approved</a> |
          <a href="?status=cancelled">Cancelled</a>
        </p>

        <table class="admin-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Tour</th>
              <th>Name / Contact</th>
              <th>Details</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php if (!$bookings): ?>
            <tr><td colspan="6">No bookings found.</td></tr>
          <?php else: ?>
            <?php foreach ($bookings as $b): ?>
              <tr>
                <td><?php echo (int)$b['id']; ?></td>
                <td>
                  <strong><?php echo htmlspecialchars($b['tour_title']); ?></strong><br>
                  <small><?php echo htmlspecialchars($b['tour_code']); ?></small>
                </td>
                <td>
                  <?php echo htmlspecialchars($b['full_name']); ?><br>
                  <small><?php echo htmlspecialchars($b['email']); ?></small><br>
                  <small><?php echo htmlspecialchars($b['phone']); ?></small>
                </td>
                <td>
                  <small>Date:</small> <?php echo htmlspecialchars($b['travel_date'] ?: 'N/A'); ?><br>
                  <small>People:</small> <?php echo (int)$b['people']; ?><br>
                  <small>Requests:</small>
                  <?php echo nl2br(htmlspecialchars($b['special_requests'])); ?>
                </td>
                <td>
                  <span class="badge <?php echo htmlspecialchars($b['status']); ?>">
                    <?php echo ucfirst($b['status']); ?>
                  </span><br>
                  <small><?php echo htmlspecialchars($b['created_at']); ?></small>
                </td>
                <td class="admin-actions">
                  <form method="post">
                    <input type="hidden" name="id" value="<?php echo (int)$b['id']; ?>">
                    <input type="hidden" name="action" value="approve">
                    <button class="btn-sm btn-approve" type="submit">Approve</button>
                  </form>
                  <form method="post">
                    <input type="hidden" name="id" value="<?php echo (int)$b['id']; ?>">
                    <input type="hidden" name="action" value="cancel">
                    <button class="btn-sm btn-cancel" type="submit">Cancel</button>
                  </form>
                  <form method="post" onsubmit="return confirm('Delete this booking?');">
                    <input type="hidden" name="id" value="<?php echo (int)$b['id']; ?>">
                    <input type="hidden" name="action" value="delete">
                    <button class="btn-sm btn-delete" type="submit">Delete</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</body>
</html>
