<?php
require_once 'includes/db.php'; require_once 'includes/functions.php'; require_login();
if(empty($_SESSION['cart'])) { header("Location: cart.php"); exit; }
$cart=$_SESSION['cart']; $ids=implode(',',array_map('intval',array_keys($cart))); $res=$conn->query("SELECT * FROM items WHERE id IN ($ids) AND status='available'");
$total=0; $rows=[];
while($r=$res->fetch_assoc()){ $r['qty']=$cart[$r['id']]; $total += $r['qty']*$r['price']; $rows[]=$r; }
$error="";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $address=trim($_POST['address']); $phone=trim($_POST['phone']);
    if($address===''||$phone==='') $error="Please enter delivery address and phone.";
    else {
        $stmt=$conn->prepare("INSERT INTO orders(user_id,total_amount,address,phone,status) VALUES(?,?,?,?, 'pending')");
        $stmt->bind_param("idss",$_SESSION['user_id'],$total,$address,$phone);
        $stmt->execute(); $order_id=$stmt->insert_id;
        $itemStmt=$conn->prepare("INSERT INTO order_items(order_id,item_id,quantity,price) VALUES(?,?,?,?)");
        foreach($rows as $r){ $itemStmt->bind_param("iiid",$order_id,$r['id'],$r['qty'],$r['price']); $itemStmt->execute(); }
        $_SESSION['cart']=[]; header("Location: orders.php?placed=1"); exit;
    }
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Checkout</title><link rel="stylesheet" href="css/style.css"></head><body>
<?php include 'includes/header.php'; ?><main class="container form-page"><h2>Checkout</h2>
<?php if($error): ?><div class="alert"><?=e($error)?></div><?php endif; ?>
<div class="form-card"><p><strong>Total: Rs. <?=number_format($total,2)?></strong></p>
<form method="post"><label>Delivery Address<textarea name="address" required></textarea></label><label>Phone<input name="phone" required></label><button class="btn">Place Order</button></form></div></main><?php include 'includes/footer.php'; ?></body></html>