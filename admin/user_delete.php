<?php
require_once '../includes/db.php'; require_once '../includes/functions.php'; require_admin();
$id=(int)$_GET['id']; if($id!==$_SESSION['user_id']){ $st=$conn->prepare("DELETE FROM users WHERE id=? AND role='customer'");$st->bind_param("i",$id);$st->execute(); }
header("Location: dashboard.php");exit;
?>