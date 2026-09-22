<?php
require_once '../includes/db.php';
$error="";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email=trim($_POST['email']); $password=$_POST['password'];
    $stmt=$conn->prepare("SELECT id,username,password,role FROM users WHERE email=?");
    $stmt->bind_param("s",$email); $stmt->execute(); $result=$stmt->get_result(); $user=$result->fetch_assoc();
    if($user && password_verify($password,$user['password'])){
        $_SESSION['user_id']=$user['id']; $_SESSION['username']=$user['username']; $_SESSION['role']=$user['role'];
        if($user['role']==='admin') header("Location: ../admin/dashboard.php"); else header("Location: ../index.php");
        exit;
    } else $error="Invalid email or password.";
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Login</title><link rel="stylesheet" href="../css/style.css"></head><body>
<?php include '../includes/header.php'; ?><main class="container form-page"><h2>Login</h2>
<?php if(isset($_GET['registered'])): ?><div class="success">Registration successful. Please log in.</div><?php endif; ?>
<?php if($error): ?><div class="alert"><?=htmlspecialchars($error)?></div><?php endif; ?>
<form method="post" class="form-card">
<label>Email<input type="email" name="email" required></label>
<label>Password<input type="password" name="password" required></label>
<button class="btn">Login</button><p>New customer? <a href="register.php">Create account</a></p>
<p><small>Demo admin: admin@foodhub.com / admin123</small></p>
</form></main><?php include '../includes/footer.php'; ?></body></html>