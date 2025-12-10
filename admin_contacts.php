<?php
session_start();
require_once 'config.php';

if (empty($_SESSION['user_email']) || ($_SESSION['user_role'] ?? 'user') !== 'admin') {
    header('Location: login.php');
    exit;
}

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $id     = (int)($_POST['id'] ?? 0);

    if ($id > 0) {
        if ($action === 'mark_read') {
            $stmt = $conn->prepare("UPDATE contact_messages SET is_read = 1 WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        } elseif ($action === 'mark_unread') {
            $stmt = $conn->prepare("UPDATE contact_messages SET is_read = 0 WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        } elseif ($action === 'delete') {
            $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $stmt->close();
        }
    }

    header("Location: admin_contacts.php");
    exit;
}

$result = $conn->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
$messages = $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin - Contact Messages</title>
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
        <a href="admin_bookings.php">Bookings</a>
        <a href="admin_contacts.php" class="active">Contact Messages</a>
      </div>

      <div class="admin-card">
        <h2>Contact Messages</h2>
        <p class="admin-meta">Messages sent from the website contact form.</p>

        <table class="admin-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>From</th>
              <th>Message</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
          <?php if (!$messages): ?>
            <tr><td colspan="5">No messages found.</td></tr>
          <?php else: ?>
            <?php foreach ($messages as $m): ?>
              <tr>
                <td><?php echo (int)$m['id']; ?></td>
                <td>
                  <strong><?php echo htmlspecialchars($m['name']); ?></strong><br>
                  <small><?php echo htmlspecialchars($m['email']); ?></small><br>
                  <small><?php echo htmlspecialchars($m['phone']); ?></small>
                </td>
                <td><?php echo nl2br(htmlspecialchars($m['message'])); ?></td>
                <td>
                  <span class="badge <?php echo $m['is_read'] ? 'read' : 'unread'; ?>">
                    <?php echo $m['is_read'] ? 'Read' : 'Unread'; ?>
                  </span><br>
                  <small><?php echo htmlspecialchars($m['created_at']); ?></small>
                </td>
                <td class="admin-actions">
                  <?php if (!$m['is_read']): ?>
                    <form method="post">
                      <input type="hidden" name="id" value="<?php echo (int)$m['id']; ?>">
                      <input type="hidden" name="action" value="mark_read">
                      <button class="btn-sm btn-approve" type="submit">Mark read</button>
                    </form>
                  <?php else: ?>
                    <form method="post">
                      <input type="hidden" name="id" value="<?php echo (int)$m['id']; ?>">
                      <input type="hidden" name="action" value="mark_unread">
                      <button class="btn-sm btn-cancel" type="submit">Mark unread</button>
                    </form>
                  <?php endif; ?>

                  <form method="post" onsubmit="return confirm('Delete this message?');">
                    <input type="hidden" name="id" value="<?php echo (int)$m['id']; ?>">
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
