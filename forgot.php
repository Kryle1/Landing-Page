<?php
$sent = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST'
    && filter_var(trim(isset($_POST['email']) ? $_POST['email'] : ''), FILTER_VALIDATE_EMAIL)) {
    // Sending real emails needs a mail server (mail() or PHPMailer).
    // For now this only shows the confirmation message.
    $sent = true;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaseZone | Forgot Password</title>
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

  <main class="hero" style="--hero-image:url('images/forgot-bg.jpg')">
    <section class="login-card card-outline forgot-card">
      <a href="index.php" class="back" aria-label="Back to login">&larr;</a>
      <h2>Forgot Password?</h2>
      <p class="lead">Enter your email address and we’ll send you a link to reset your password</p>

      <?php if ($sent): ?>
        <p class="notice" role="status">If an account exists for that email, a reset link is on its way.</p>
      <?php endif; ?>

      <form method="post">
        <label class="field outlined">
          <svg viewBox="0 0 32 32" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
            <rect x="3" y="7" width="26" height="18" rx="1.5"/>
            <path d="M3 8l13 10L29 8M3 24l9-8M29 24l-9-8"/>
          </svg>
          <input type="email" name="email" placeholder="Email" required>
        </label>

        <button type="submit" class="btn-login">Send Reset link</button>

        <p class="signup"><a href="index.php">Back to Login</a></p>
      </form>
    </section>
  </main>

</body>
</html>