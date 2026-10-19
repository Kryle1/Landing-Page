<?php
session_start();

if (!empty($_SESSION['user_id'])) {
    header('Location: home.php');
    exit;
}

if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(32));
}

$error    = isset($_SESSION['login_error']) ? $_SESSION['login_error'] : '';
$oldEmail = isset($_SESSION['old_email']) ? $_SESSION['old_email'] : '';
unset($_SESSION['login_error'], $_SESSION['old_email']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaseZone | Login</title>
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

  <main class="hero" style="--hero-image:url('images/background.jpg')">
    <section class="hero-text">
      <h1>Your Phone<br>Our Accessories</h1>
      <p>Quality accessories for<br>your everyday needs.</p>
    </section>

    <section class="login-card">
      <h2>Login</h2>

      <?php if (isset($_GET['registered'])): ?>
        <p class="notice" role="status">Account created. Please log in.</p>
      <?php endif; ?>

      <?php if ($error): ?>
        <p class="error" role="alert"><?= htmlspecialchars($error) ?></p>
      <?php endif; ?>

      <form action="login.php" method="post">
        <input type="hidden" name="csrf" value="<?= $_SESSION['csrf'] ?>">

        <label class="field">
          <svg viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round" aria-hidden="true">
            <rect x="3" y="7" width="26" height="18" rx="1.5"/>
            <path d="M3 8l13 10L29 8M3 24l9-8M29 24l-9-8"/>
          </svg>
          <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($oldEmail) ?>" required>
        </label>

        <label class="field">
          <svg viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <rect x="5" y="14" width="22" height="14" rx="3"/>
            <path d="M10 14v-3a6 6 0 0 1 12 0v3"/>
            <path d="M10 21h.01M14 21h.01M18 21h.01"/>
            <path d="M23 24.5c0-1.2 1.8-1.2 1.8-2.6M24 27.5h.01" stroke-width="1.8"/>
          </svg>
          <input type="password" name="password" placeholder="Password" required>
        </label>

        <div class="options">
          <label class="remember">
            <input type="checkbox" name="remember" value="1">
            <span class="box"></span>
            Remember me
          </label>
          <a href="forgot.php" class="forgot">Forgot Password</a>
        </div>

        <button type="submit" class="btn-login">Log in</button>

        <p class="signup">Don’t have an account? <a href="signup.php">Sign Up</a></p>
      </form>
    </section>
  </main>

  <a href="#" class="admin-login">
    <svg viewBox="0 0 32 32" width="26" height="26" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
      <path d="M6 14a10 10 0 0 1 17-5l3 3M26 6v6h-6"/>
      <path d="M26 18a10 10 0 0 1-17 5l-3-3M6 26v-6h6"/>
      <circle cx="16" cy="13" r="2.5"/>
      <path d="M11.5 21c.8-2.4 2.4-3.5 4.5-3.5s3.7 1.1 4.5 3.5"/>
    </svg>
    Admin Login
  </a>

</body>
</html>