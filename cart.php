<?php
require_once 'includes/db.php'; require_once 'includes/functions.php'; require_login();
if(!isset($_SESSION['cart'])) $_SESSION['cart']=[];
if(isset($_POST['add_to_cart'])){
    $id=(int)$_POST['item_id']; $qty=max(1,(int)$_POST['quantity']);
    $check=$conn->prepare("SELECT id FROM items WHERE id=? AND status='available'");
    $check->bind_param("i",$id); $check->execute();
    if($check->get_result()->num_rows) $_SESSION['cart'][$id]=($_SESSION['cart'][$id]??0)+$qty;
    header("Location: cart.php"); exit;
}
if(isset($_GET['remove'])) { unset($_SESSION['cart'][(int)$_GET['remove']]); header("Location: cart.php"); exit; }
$cart=$_SESSION['cart']; $rows=[]; $total=0;
if($cart){
  $ids=implode(',',array_map('intval',array_keys($cart)));
  $res=$conn->query("SELECT * FROM items WHERE id IN ($ids) AND status='available'");
  while($r=$res->fetch_assoc()){ $r['qty']=$cart[$r['id']]; $r['subtotal']=$r['qty']*$r['price']; $total+=$r['subtotal']; $rows[]=$r; }
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Cart</title><link rel="stylesheet" href="css/style.css"></head><body>
<?php include 'includes/header.php'; ?><main class="container"><h2>Your Cart</h2>
<?php if(!$rows): ?><div class="empty">Your cart is empty. <a href="index.php">Browse menu</a></div>
<?php else: ?><div class="table-wrap"><table><tr><th>Item</th><th>Qty</th><th>Price</th><th>Subtotal</th><th></th></tr>
<?php foreach($rows as $r): ?><tr><td><?=e($r['name'])?></td><td><?=e($r['qty'])?></td><td>Rs. <?=number_format($r['price'],2)?></td><td>Rs. <?=number_format($r['subtotal'],2)?></td><td><a class="danger-link" href="cart.php?remove=<?=$r['id']?>">Remove</a></td></tr><?php endforeach; ?>
<tr><th colspan="3">Total</th><th>Rs. <?=number_format($total,2)?></th><th></th></tr></table></div>
<a class="btn" href="checkout.php">Checkout</a><?php endif; ?></main><?php include 'includes/footer.php'; ?></body></html>