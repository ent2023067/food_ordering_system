<?php
require_once 'includes/db.php'; $msg="";
if($_SERVER['REQUEST_METHOD']==='POST'){
$n=trim($_POST['name']);$e=trim($_POST['email']);$m=trim($_POST['message']);
if($n && filter_var($e,FILTER_VALIDATE_EMAIL) && $m){$st=$conn->prepare("INSERT INTO messages(name,email,message) VALUES(?,?,?)");$st->bind_param("sss",$n,$e,$m);$st->execute();$msg="Message sent successfully.";}else $msg="Please fill all fields correctly.";
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Contact</title><link rel="stylesheet" href="css/style.css"></head><body><?php include 'includes/header.php';?><main class="container form-page"><h2>Contact Us</h2><?php if($msg):?><div class="success"><?=htmlspecialchars($msg)?></div><?php endif;?><form method="post" class="form-card" onsubmit="return validateContact()"><label>Name<input id="contactName" name="name" required></label><label>Email<input id="contactEmail" type="email" name="email" required></label><label>Message<textarea id="contactMessage" name="message" required></textarea></label><button class="btn">Send Message</button></form></main><script src="js/script.js"></script><?php include 'includes/footer.php';?></body></html>