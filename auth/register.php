<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
$error = "";
if($_SERVER['REQUEST_METHOD']==='POST'){
    $username=trim($_POST['username']); $email=trim($_POST['email']); $password=$_POST['password'];
    if($username==='' || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($password)<6){
        $error="Enter a valid username, email and password of at least 6 characters.";
    } else {
        $check=$conn->prepare("SELECT id FROM users WHERE email=?");
        $check->bind_param("s",$email); $check->execute(); $check->store_result();
        if($check->num_rows>0) $error="Email already registered.";
        else {
            $hash=password_hash($password,PASSWORD_DEFAULT);
            $stmt=$conn->prepare("INSERT INTO users(username,email,password,role) VALUES(?,?,?,'customer')");
            $stmt->bind_param("sss",$username,$email,$hash);
            if($stmt->execute()){ header("Location: login.php?registered=1"); exit; }
            $error="Registration failed.";
        }
    }
}
?>
<!DOCTYPE html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Register</title><link rel="stylesheet" href="../css/style.css"></head><body>
<?php include '../includes/header.php'; ?><main class="container form-page"><h2>Create Customer Account</h2>
<?php if($error): ?><div class="alert"><?=e($error)?></div><?php endif; ?>
<form method="post" class="form-card" onsubmit="return validateRegister()">
<label>Username<input id="username" name="username" required></label>
<label>Email<input id="email" type="email" name="email" required></label>
<label>Password<input id="password" type="password" name="password" required minlength="6"></label>
<button class="btn">Register</button><p>Already registered? <a href="login.php">Login</a></p>
</form></main><script src="../js/script.js"></script><?php include '../includes/footer.php'; ?></body></html>