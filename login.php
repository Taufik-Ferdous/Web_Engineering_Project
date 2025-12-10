<?php
session_start();
require_once 'config.php';

// If already logged in, you can redirect to home (optional)
// comment this out if you want logged-in users to see the page.
// if (!empty($_SESSION['user_email'])) {
//   header('Location: index.php');
//   exit;
// }

$login_error = "";
$signup_errors = [];
$active_tab = "login";

// Preserve input values
$login_email = "";
$signup_name  = "";
$signup_email = "";
$signup_phone = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mode = $_POST['mode'] ?? 'login';

    if ($mode === 'login') {
        $active_tab = "login";

        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $login_email = $email;

        if ($email === '' || $password === '') {
            $login_error = "Please enter both email and password.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $login_error = "Please enter a valid email address.";
        } else {
            $stmt = $conn->prepare("SELECT id, name, password_hash, role FROM users WHERE email = ?");
            if ($stmt) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows === 1) {
                    $stmt->bind_result($uid, $name, $hash, $role);
                    $stmt->fetch();

                    if (password_verify($password, $hash)) {
                        // success
                        $_SESSION['user_email'] = $email;
                        $_SESSION['user_name']  = $name;
                        $_SESSION['user_role']  = $role;  
                        header("Location: index.php");
                        exit;
                    } else {
                        $login_error = "Invalid email or password.";
                    }
                } else {
                    $login_error = "Invalid email or password.";
                }

                $stmt->close();
            } else {
                $login_error = "Failed to check credentials.";
            }
        }
    } elseif ($mode === 'signup') {
        $active_tab = "signup";

        $name  = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $phone = trim($_POST['phone'] ?? '');
        $pass  = trim($_POST['password'] ?? '');
        $cpass = trim($_POST['confirm_password'] ?? '');

        $signup_name  = $name;
        $signup_email = $email;
        $signup_phone = $phone;

        if ($name === '' || $email === '' || $pass === '' || $cpass === '') {
            $signup_errors[] = "All fields marked with * are required.";
        }

        if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $signup_errors[] = "Please enter a valid email address.";
        }

        if ($pass !== '' && strlen($pass) < 6) {
            $signup_errors[] = "Password should be at least 6 characters long.";
        }

        if ($pass !== '' && $cpass !== '' && $pass !== $cpass) {
            $signup_errors[] = "Password and Confirm Password do not match.";
        }

        if (!$signup_errors) {
            // Check if email already exists
            $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
            if ($stmt) {
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->store_result();

                if ($stmt->num_rows > 0) {
                    $signup_errors[] = "This email is already registered. Please log in instead.";
                } else {
                    $hash = password_hash($pass, PASSWORD_DEFAULT);
                    $insert = $conn->prepare(
                        "INSERT INTO users (name, email, password_hash, phone) VALUES (?, ?, ?, ?)"
                    );
                    if ($insert) {
                        $insert->bind_param("ssss", $name, $email, $hash, $phone);
                        if ($insert->execute()) {
                            // Auto-login and redirect
                            $_SESSION['user_email'] = $email;
                            $_SESSION['user_name']  = $name;
                            $_SESSION['user_role']  = 'user';
                            header("Location: index.php");
                            exit;
                        } else {
                            $signup_errors[] = "Something went wrong while creating your account.";
                        }
                        $insert->close();
                    } else {
                        $signup_errors[] = "Failed to prepare database statement.";
                    }
                }

                $stmt->close();
            } else {
                $signup_errors[] = "Failed to check existing users.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>EasyBreak - Login & Sign Up</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Use your main CSS; you can add small extra styles below -->
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
          <li><a href="index.php" class="nav-link">Home</a></li>
          <li><a href="tours.php" class="nav-link">Tours</a></li>
          <li><a href="destinations.php" class="nav-link">Destinations</a></li>
          <li><a href="blog.php" class="nav-link">Blog</a></li>
          <li><a href="contact.php" class="nav-link">Contact Us</a></li>
          <li><a href="about.php" class="nav-link">About Us</a></li>

          <?php if (!empty($_SESSION['user_email'])): ?>
            <li class="nav-link nav-user">
              Logged in as <?php echo htmlspecialchars($_SESSION['user_email']); ?>
            </li>
            <li><a href="logout.php" class="nav-link">Logout</a></li>
          <?php else: ?>
            <li><a href="login.php" class="nav-link active">Login / Sign Up</a></li>
          <?php endif; ?>
        </ul>
      </nav>
    </div>
  </header>

  <main class="page">
    <section class="section">
      <div class="container auth-wrapper">
        <header class="section-header">
          <h2>Welcome to EasyBreak</h2>
          <p>Log in to your account or create a new one to manage your trips.</p>
        </header>

        <div class="login-card">
          <div class="auth-tabs">
            <button
              type="button"
              class="auth-tab <?php echo $active_tab === 'login' ? 'active' : ''; ?>"
              data-auth="login"
            >
              Login
            </button>
            <button
              type="button"
              class="auth-tab <?php echo $active_tab === 'signup' ? 'active' : ''; ?>"
              data-auth="signup"
            >
              Sign Up
            </button>
          </div>

          <!-- Login Form -->
          <?php if ($login_error && $active_tab === 'login'): ?>
            <p class="form-error"><?php echo htmlspecialchars($login_error); ?></p>
          <?php endif; ?>

          <form
            method="post"
            class="login-form auth-form <?php echo $active_tab === 'login' ? 'active' : ''; ?>"
            data-auth-form="login"
            novalidate
          >
            <input type="hidden" name="mode" value="login" />

            <div class="form-group">
              <label for="login_email">Email</label>
              <input
                type="email"
                id="login_email"
                name="email"
                required
                placeholder="you@example.com"
                value="<?php echo htmlspecialchars($login_email); ?>"
              />
            </div>

            <div class="form-group">
              <label for="login_password">Password</label>
              <input
                type="password"
                id="login_password"
                name="password"
                required
                placeholder="Enter your password"
              />
            </div>

            <button type="submit" class="btn primary-btn">Login</button>
          </form>

          <!-- Sign Up Form -->
          <?php if ($signup_errors && $active_tab === 'signup'): ?>
            <div class="form-error">
              <ul>
                <?php foreach ($signup_errors as $e): ?>
                  <li><?php echo htmlspecialchars($e); ?></li>
                <?php endforeach; ?>
              </ul>
            </div>
          <?php endif; ?>

          <form
            method="post"
            class="login-form auth-form <?php echo $active_tab === 'signup' ? 'active' : ''; ?>"
            data-auth-form="signup"
            novalidate
          >
            <input type="hidden" name="mode" value="signup" />

            <div class="form-group">
              <label for="signup_name">Full Name *</label>
              <input
                type="text"
                id="signup_name"
                name="name"
                required
                value="<?php echo htmlspecialchars($signup_name); ?>"
              />
            </div>

            <div class="form-group">
              <label for="signup_email">Email *</label>
              <input
                type="email"
                id="signup_email"
                name="email"
                required
                value="<?php echo htmlspecialchars($signup_email); ?>"
              />
            </div>

            <div class="form-group">
              <label for="signup_phone">Phone</label>
              <input
                type="tel"
                id="signup_phone"
                name="phone"
                value="<?php echo htmlspecialchars($signup_phone); ?>"
              />
            </div>

            <div class="form-group">
              <label for="signup_password">Password *</label>
              <input
                type="password"
                id="signup_password"
                name="password"
                required
              />
            </div>

            <div class="form-group">
              <label for="signup_confirm_password">Confirm Password *</label>
              <input
                type="password"
                id="signup_confirm_password"
                name="confirm_password"
                required
              />
            </div>

            <button type="submit" class="btn primary-btn">Sign Up</button>
          </form>
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
  <script>
    // Toggle between Login and Sign Up
    const tabs = document.querySelectorAll('.auth-tab');
    const forms = document.querySelectorAll('.auth-form');

    tabs.forEach(tab => {
      tab.addEventListener('click', () => {
        const target = tab.getAttribute('data-auth');

        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');

        forms.forEach(f => {
          const isTarget = f.getAttribute('data-auth-form') === target;
          f.classList.toggle('active', isTarget);
        });
      });
    });
  </script>
</body>
</html>
