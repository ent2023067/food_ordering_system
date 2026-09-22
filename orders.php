<?php
require_once 'includes/db.php'; require_once 'includes/functions.php'; require_login();
$stmt=$conn->prepare("SELECT * FROM orders WHERE user_id=? ORDER BY created_at DESC"); $stmt->bind_param("i",$_SESSION['user_id']); $stmt->execute(); $orders=$stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>My Orders</title><link rel="stylesheet" href="css/style.css"></head><body>
<?php include 'includes/header.php'; ?><main class="container"><h2>My Orders</h2><?php if(isset($_GET['placed'])):?><div class="success">Order placed successfully.</div><?php endif;?>
<div class="table-wrap"><table><tr><th>Order</th><th>Total</th><th>Address</th><th>Status</th><th>Date</th></tr>
<?php foreach($orders as $o): ?><tr><td>#<?=$o['id']?></td><td>Rs. <?=number_format($o['total_amount'],2)?></td><td><?=e($o['address'])?></td><td><span class="status"><?=e(ucfirst($o['status']))?></span></td><td><?=e($o['created_at'])?></td></tr><?php endforeach; ?>
</table></div></main><?php include 'includes/footer.php'; ?></body></html>