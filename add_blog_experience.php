<?php
session_start();
require_once 'config.php';

$success_msg = "";
$error_msg   = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $name  = trim($_POST['name'] ?? '');
  $email = trim($_POST['email'] ?? '');
  $title = trim($_POST['title'] ?? '');
  $story = trim($_POST['story'] ?? '');

  if ($name === '' || $email === '' || $title === '' || $story === '') {
    $error_msg = "All fields are required.";
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $error_msg = "Invalid email address.";
  } else {

    $image_name = null;

    if (!empty($_FILES['image']['name'])) {
      $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
      $allowed = ['jpg','jpeg','png','webp'];

      if (!in_array($ext, $allowed)) {
        $error_msg = "Only JPG, PNG or WEBP images are allowed.";
      } else {
        $image_name = uniqid("blog_") . "." . $ext;
        move_uploaded_file(
          $_FILES['image']['tmp_name'],
          "uploads/blog/" . $image_name
        );
      }
    }

    if ($error_msg === "") {
      $stmt = $conn->prepare(
        "INSERT INTO blog_requests (name, email, title, story, image)
         VALUES (?, ?, ?, ?, ?)"
      );
      $stmt->bind_param("sssss", $name, $email, $title, $story, $image_name);

      if ($stmt->execute()) {
            header("Location: blog.php?submitted=1");
            exit;
        } else {
        $error_msg = "Something went wrong. Please try again.";
      }
      $stmt->close();
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Travel Experience - EasyBreak</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="blog.css">
</head>
<body>

<header class="header">
  <div class="container">
    <a href="blog.php" class="logo">EasyBreak</a>
  </div>
</header>

<main class="page">
  <section class="section">
    <div class="container">

        <a href="blog.php" class="btn-back-blog">
            ← Back to Blog
        </a>

      <h1>Share Your Travel Experience</h1>
      <p>Tell the EasyBreak community about your journey.</p>

      <?php if ($error_msg): ?>
        <p class="status error"><?php echo htmlspecialchars($error_msg); ?></p>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data" class="blog-request-form">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="email" name="email" placeholder="Your Email" required>
        <input type="text" name="title" placeholder="Story Title" required>
        <textarea name="story" rows="5" placeholder="Your travel experience..." required></textarea>
        <input type="file" name="image" accept="image/*">
        <button type="submit">Submit for Review</button>
      </form>

    </div>
  </section>
</main>

</body>
</html>
