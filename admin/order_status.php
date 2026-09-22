<?php
require_once '../includes/db.php'; require_once '../includes/functions.php'; require_admin();
$id=(int)$_POST['id'];$status=$_POST['status'];$allowed=['pending','accepted','preparing','delivered','cancelled'];
if(in_array($status,$allowed,true)){ $st=$conn->prepare("UPDATE orders SET status=? WHERE id=?");$st->bind_param("si",$status,$id);$st->execute(); }
header("Location: dashboard.php");exit;
?>