<?php
require_once 'includes/db.php';
$stmt = $conn->query("SELECT * FROM items WHERE status='available' ORDER BY created_at DESC");
$items = $stmt->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>FoodHub - Food Ordering</title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php include 'includes/header.php'; ?>
<section class="hero">
  <div><h1>Fresh Food, Simple Ordering</h1><p>Choose your favourite food and place your order online.</p><a class="btn" href="#menu">View Menu</a></div>
</section>
<section id="menu" class="container">
  <h2>Our Menu</h2>
  <div class="filter-row">
    <input id="searchBox" type="text" placeholder="Search food...">
    <select id="categoryFilter"><option value="">All Categories</option>
      <?php
      $cats = $conn->query("SELECT DISTINCT category FROM items WHERE status='available' ORDER BY category");
      while($c = $cats->fetch_assoc()): ?>
        <option value="<?= htmlspecialchars($c['category']) ?>"><?= htmlspecialchars($c['category']) ?></option>
      <?php endwhile; ?>
    </select>
  </div>
  <div class="grid" id="menuGrid">
  <?php foreach($items as $item): ?>
    <div class="card food-card" data-name="<?= htmlspecialchars(strtolower($item['name'])) ?>" data-category="<?= htmlspecialchars($item['category']) ?>">
      <div class="food-image"><?= htmlspecialchars($item['emoji'] ?: '🍽️') ?></div>
      <div class="card-body">
        <h3><?= htmlspecialchars($item['name']) ?></h3>
        <p><?= htmlspecialchars($item['description']) ?></p>
        <strong>Rs. <?= number_format($item['price'],2) ?></strong>
        <?php if(isset($_SESSION['user_id']) && $_SESSION['role']==='customer'): ?>
          <form method="post" action="cart.php" class="inline-form">
            <input type="hidden" name="item_id" value="<?= $item['id'] ?>">
            <input type="number" name="quantity" min="1" value="1" class="qty">
            <button class="btn small" name="add_to_cart">Add to Cart</button>
          </form>
        <?php else: ?>
          <a class="btn small" href="auth/login.php">Login to Order</a>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
  <?php if(count($items)===0): ?><p class="empty">No food items are available right now.</p><?php endif; ?>
</section>
<script src="js/script.js"></script>
<?php include 'includes/footer.php'; ?>
</body>
</html>