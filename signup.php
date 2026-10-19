<?php
session_start();
require 'config.php';
require 'auth.php';

$error = '';
$name  = '';
$email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name     = trim(isset($_POST['name']) ? $_POST['name'] : '');
    $email    = strtolower(trim(isset($_POST['email']) ? $_POST['email'] : ''));
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    $confirm  = isset($_POST['confirm']) ? $_POST['confirm'] : '';

    $existing = load_users();

    if ($name === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Enter your name and a valid email.';
    } elseif (strlen($password) < 8) {
        $error = 'Password must be at least 8 characters.';
    } elseif ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } elseif (isset($USERS[$email]) || isset($existing[$email])) {
        $error = 'An account with this email already exists.';
    } else {
        if (save_user($name, $email, $password)) {
            header('Location: index.php?registered=1');
            exit;
        }
        $error = 'Could not save your account. Check that the folder is writable.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaseZone | Create Account</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body>

  <header class="navbar">
    <div class="navbar-inner">
      <a href="index.php" class="logo">CaseZone</a>
    </div>
  </header>

  <main class="hero" style="--hero-image:url('images/signup-bg.jpg')">
    <section class="hero-text">
      <h1>Join CaseZone</h1>
      <p>Get the best deals and<br>exclusive offers!</p>
    </section>

    <section class="login-card card-outline">
      <h2>Create Account</h2>

      <?php if ($error): ?>
        <p class="error" role="alert"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <form method="post">
        <label class="field outlined">
          <svg viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
            <circle cx="16" cy="10" r="5"/>
            <path d="M5 28c0-6 5-9 11-9s11 3 11 9z"/>
          </svg>
          <input type="text" name="name" placeholder="Full Name" value="<?= htmlspecialchars($name) ?>" required>
        </label>

        <label class="field outlined">
          <svg viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
            <rect x="3" y="7" width="26" height="18" rx="1.5"/>
            <path d="M3 8l13 10L29 8M3 24l9-8M29 24l-9-8"/>
          </svg>
          <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($email) ?>" required>
        </label>

        <label class="field outlined">
          <svg viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
            <circle cx="13" cy="13" r="8"/>
            <path d="M19 19l9 9"/>
          </svg>
          <input type="password" name="password" placeholder="Password" required>
        </label>

        <label class="field outlined">
          <svg viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
            <circle cx="13" cy="13" r="8"/>
            <path d="M19 19l9 9"/>
          </svg>
          <input type="password" name="confirm" placeholder="Confirm Password" required>
        </label>

        <button type="submit" class="btn-login">Sign Up</button>

        <p class="signup">Already have an account? <a href="index.php">Log In</a></p>
      </form>
    </section>
  </main>

</body>
</html>