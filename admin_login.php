<?php
session_start();
include("config.php");

// Redirect if already logged in
if(isset($_SESSION['admin'])){
    header("Location: admin_dashboard.php");
    exit();
}

$error = "";

// Handle login
if(isset($_POST['login'])){
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $res = mysqli_query($conn, "SELECT * FROM admin WHERE username='$username' AND password='$password'");

    if(mysqli_num_rows($res) > 0){
        $admin = mysqli_fetch_assoc($res);
        $_SESSION['admin'] = $admin['username'];
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Invalid Username or Password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>♻ Admin Login - E-Waste Portal</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{
    min-height:100vh;
    background:#18191a;
    display:flex;
    justify-content:center;
    align-items:center;
    overflow:hidden;
    position:relative;
}
.diagonal-bg{
    position:absolute;
    top:0;
    left:-120%;
    width:220%;
    height:220%;
    background:linear-gradient(135deg,#28a745,#20c997);
    transform:rotate(-45deg);
    z-index:1;
}
.hero{
    position:absolute;
    top:50px;
    width:100%;
    text-align:center;
    color:white;
    z-index:2;
}
.hero h1{
    font-size:42px;
    text-shadow:2px 2px 10px rgba(0,0,0,0.6);
}
.hero p{
    font-size:20px;
    color:#eee;
}
.login-card{
    position:relative;
    z-index:2;
    width:400px;
    background:white;
    padding:40px;
    border-radius:20px;
    box-shadow:0 15px 40px rgba(0,0,0,0.3);
    text-align:center;
}
.login-card h2{
    margin-bottom:25px;
    color:#28a745;
    font-size:26px;
    display:flex;
    justify-content:center;
    align-items:center;
    gap:10px;
}
.login-card h2::before{
    content:"🔑";
    font-size:32px;
}
.login-card input[type="text"],
.login-card input[type="password"]{
    width:100%;
    padding:14px 15px;
    margin:12px 0;
    border-radius:8px;
    border:1px solid #ccc;
    font-size:15px;
}
.login-card input:focus{
    border-color:#28a745;
    box-shadow:0 0 8px rgba(40,167,69,0.3);
    outline:none;
}
.password-box{
    position:relative;
    width:100%;
    margin:10px 0;
}
.password-box input{
    width:100%;
    padding-right:45px;
}
.password-box i{
    position:absolute;
    right:15px;
    top:50%;
    transform:translateY(-50%);
    cursor:pointer;
    color:#777;
    font-size:18px;
}
.password-box i:hover{ color:#28a745; }
.login-card button{
    width:100%;
    padding:14px;
    background: linear-gradient(45deg,#28a745,#20c997);
    border:none;
    color:white;
    font-size:16px;
    border-radius:8px;
    margin-top:15px;
    cursor:pointer;
    transition:0.3s;
}
.login-card button:hover{
    transform:scale(1.05);
    box-shadow:0 6px 20px rgba(0,0,0,0.3);
}
.error{
    color:red;
    margin-bottom:10px;
    font-size:14px;
}
@media(max-width:500px){
    .login-card{ width:90%; padding:30px; }
    .hero h1{ font-size:32px; }
    .hero p{ font-size:16px; }
}
</style>
</head>
<body>
<div class="diagonal-bg"></div>
<div class="hero">
    <h1>♻ E-Waste Management Portal</h1>
    <p>Admin Login</p>
</div>
<div class="login-card">
    <h2>Welcome Admin</h2>
    <?php if($error!=""){ echo "<div class='error'>$error</div>"; } ?>
    <form method="POST">
        <input type="text" name="username" placeholder="Enter Username" required>
        <div class="password-box">
            <input type="password" name="password" id="password" placeholder="Enter Password" required>
            <i class="fa-solid fa-eye" id="eye" onclick="togglePassword()"></i>
        </div>
        <button type="submit" name="login">Login</button>
    </form>
</div>
<script>
function togglePassword(){
    const pass=document.getElementById('password');
    const eye=document.getElementById('eye');
    if(pass.type==="password"){
        pass.type="text";
        eye.classList.remove("fa-eye"); eye.classList.add("fa-eye-slash");
    }else{
        pass.type="password";
        eye.classList.remove("fa-eye-slash"); eye.classList.add("fa-eye");
    }
}
</script>
</body>
</html>