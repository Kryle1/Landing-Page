<?php
session_start();
if (empty($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$categories = array(
    array('Phone Cases', '📱'),
    array('Chargers', '🔌'),
    array('Screen Protector', '🛡️'),
    array('Airpods', '🎧'),
    array('Cables', '🔗'),
);

$products = array(
    array('Phone Cases',       299,  4.5, 'case.png'),
    array('Fast Chargers',     1199, 4.7, 'charger.png'),
    array('Screen Protectors', 499,  4.9, 'protector.png'),
    array('Cables',            799,  4.9, 'cable.png'),
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>CaseZone | Home</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="style.css">
</head>
<body class="shop">

  <header class="shop-nav">
    <a href="home.php" class="shop-logo">CaseZone</a>
    <nav>
      <a href="home.php">Home</a>
      <a href="#products"><b>Products</b></a>
      <a href="#categories"><b>Categories</b></a>
      <a href="#">About</a>
    </nav>
    <input class="search" type="search" placeholder="Search for phone accessories...">
    <div class="icons">
      <a href="#" title="Cart">🛒</a>
      <a href="logout.php" title="Log out (<?= htmlspecialchars($_SESSION['name']) ?>)">👤</a>
      <a href="#" title="Settings">⚙️</a>
    </div>
  </header>

  <section class="banner">
    <div>
      <h1>Upgrade Your Phone Today!</h1>
      <p>Quality accessories at affordable prices</p>
      <a href="#products" class="shop-now">Shop Now</a>
    </div>
  </section>

  <section class="block" id="categories">
    <h2>Categories</h2>
    <div class="cats">
      <?php foreach ($categories as $c): ?>
        <a href="#" class="cat">
          <span class="cat-box"><?= $c[1] ?></span>
          <?= htmlspecialchars($c[0]) ?>
        </a>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="block" id="products">
    <h2>Featured Products</h2>
    <div class="products">
      <?php foreach ($products as $p): ?>
        <article class="product">
          <div class="thumb"><img src="images/<?= htmlspecialchars($p[3]) ?>" alt="<?= htmlspecialchars($p[0]) ?>"></div>
          <h3><?= htmlspecialchars($p[0]) ?></h3>
          <div class="meta"><strong>₱<?= number_format($p[1]) ?></strong><span>⭐ <?= $p[2] ?></span></div>
          <a href="#" class="view">View</a>
        </article>
      <?php endforeach; ?>
    </div>
  </section>

</body>
</html>