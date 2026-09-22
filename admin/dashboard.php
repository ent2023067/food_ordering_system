<?php
require_once '../includes/db.php'; require_once '../includes/functions.php'; require_admin();
$items=$conn->query("SELECT * FROM items ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
$orders=$conn->query("SELECT o.*,u.username FROM orders o JOIN users u ON u.id=o.user_id ORDER BY o.created_at DESC")->fetch_all(MYSQLI_ASSOC);
$users=$conn->query("SELECT id,username,email,role,created_at FROM users ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Dashboard</title><link rel="stylesheet" href="../css/style.css"></head><body>
<?php include '../includes/header.php'; ?><main class="container"><h2>Shop Admin Dashboard</h2>
<div class="stats"><div><b><?=count($items)?></b><span>Food Items</span></div><div><b><?=count($orders)?></b><span>Orders</span></div><div><b><?=count($users)?></b><span>Users</span></div></div>
<section><div class="section-head"><h3>Manage Food Items</h3><a class="btn small" href="item_add.php">+ Add Item</a></div>
<div class="table-wrap"><table><tr><th>Name</th><th>Category</th><th>Price</th><th>Status</th><th>Actions</th></tr>
<?php foreach($items as $i): ?><tr><td><?=e($i['name'])?></td><td><?=e($i['category'])?></td><td>Rs. <?=number_format($i['price'],2)?></td><td><?=e($i['status'])?></td><td><a href="item_edit.php?id=<?=$i['id']?>">Edit</a> | <a class="danger-link" onclick="return confirm('Delete this item?')" href="item_delete.php?id=<?=$i['id']?>">Delete</a></td></tr><?php endforeach; ?></table></div></section>
<section><h3>Manage Orders</h3><div class="table-wrap"><table><tr><th>ID</th><th>Customer</th><th>Total</th><th>Status</th><th>Change</th></tr>
<?php foreach($orders as $o): ?><tr><td>#<?=$o['id']?></td><td><?=e($o['username'])?></td><td>Rs. <?=number_format($o['total_amount'],2)?></td><td><?=e($o['status'])?></td><td><form method="post" action="order_status.php" class="inline-form"><input type="hidden" name="id" value="<?=$o['id']?>"><select name="status"><option <?= $o['status']==='pending'?'selected':''?>>pending</option><option <?= $o['status']==='accepted'?'selected':''?>>accepted</option><option <?= $o['status']==='preparing'?'selected':''?>>preparing</option><option <?= $o['status']==='delivered'?'selected':''?>>delivered</option><option <?= $o['status']==='cancelled'?'selected':''?>>cancelled</option></select><button class="btn small">Update</button></form></td></tr><?php endforeach; ?></table></div></section>
<section><h3>Users</h3><div class="table-wrap"><table><tr><th>ID</th><th>Username</th><th>Email</th><th>Role</th><th>Action</th></tr>
<?php foreach($users as $u): ?><tr><td><?=$u['id']?></td><td><?=e($u['username'])?></td><td><?=e($u['email'])?></td><td><?=e($u['role'])?></td><td><?php if($u['role']!=='admin'): ?><a class="danger-link" onclick="return confirm('Delete this user?')" href="user_delete.php?id=<?=$u['id']?>">Delete</a><?php endif;?></td></tr><?php endforeach; ?></table></div></section>
</main><?php include '../includes/footer.php'; ?></body></html>