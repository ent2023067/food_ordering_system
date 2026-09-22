<header class="header">
<div class="container nav">
  <a class="logo" href="index.php">🍔 FoodHub</a>
  <nav>
    <a href="index.php">Home</a>
    <?php if(isset($_SESSION['user_id'])): ?>
      <?php if($_SESSION['role']==='admin'): ?><a href="admin/dashboard.php">Admin</a><?php endif; ?>
      <?php if($_SESSION['role']==='customer'): ?><a href="cart.php">Cart</a><a href="orders.php">My Orders</a><?php endif; ?>
      <a href="auth/logout.php">Logout</a>
    <?php else: ?>
      <a href="auth/login.php">Login</a><a href="auth/register.php">Register</a>
    <?php endif; ?>
  </nav>
</div>
</header>