<?php
require_once '../includes/db.php'; require_once '../includes/functions.php'; require_admin(); $id=(int)($_GET['id']??0);
$st=$conn->prepare("DELETE FROM items WHERE id=?");$st->bind_param("i",$id);$st->execute();header("Location: dashboard.php");exit;
?>