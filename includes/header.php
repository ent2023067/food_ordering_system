<?php
$script_dir = dirname(str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? ''));
$base_path = in_array(basename($script_dir), ['auth', 'admin'], true) ? dirname($script_dir) : $script_dir;
$base_path = $base_path === '/' || $base_path === '.' ? '' : rtrim($base_path, '/');
?>
<header class="header">
<div class="container nav">
  <a class="logo" href="<?=$base_path?>/index.php">🍔 FoodHub</a>
  <nav>
    <a href="<?=$base_path?>/index.php">Home</a>
    <?php if(isset($_SESSION['user_id'])): ?>
      <?php if($_SESSION['role']==='admin'): ?><a href="<?=$base_path?>/admin/dashboard.php">Admin</a><?php endif; ?>
      <?php if($_SESSION['role']==='customer'): ?><a href="<?=$base_path?>/cart.php">Cart</a><a href="<?=$base_path?>/orders.php">My Orders</a><?php endif; ?>
      <a href="<?=$base_path?>/auth/logout.php">Logout</a>
    <?php else: ?>
      <a href="<?=$base_path?>/auth/login.php">Login</a><a href="<?=$base_path?>/auth/register.php">Register</a>
    <?php endif; ?>
  </nav>
</div>
</header>