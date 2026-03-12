<?php
session_start();
session_unset();
session_destroy();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Logout | E-Waste Portal</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{
    min-height:100vh;
    display:flex;
    flex-direction:column;
    justify-content:center;
    align-items:center;
    overflow:hidden;
    background:#0f1113;
    position:relative;
}

/* Animated Gradient Background */
.diagonal-bg{
    position:absolute;
    top:0;
    left:0;
    width:200%;
    height:200%;
    background:linear-gradient(45deg,#28a745,#6be67e);
    background-size:400% 400%;
    animation:gradientMove 8s ease infinite;
    z-index:1;
    transform:rotate(-20deg);
}

/* Main Heading */
.main-heading{
    position:relative;
    z-index:2;
    text-align:center;
    width:100%;
    margin-bottom:30px;
    color:white;
    font-size:32px;
    font-weight:600;
    text-shadow:0 2px 10px rgba(0,255,100,0.3);
    animation:headingPop 1s ease forwards;
}

/* Logout Card */
.logout-card{
    position:relative;
    z-index:2;
    width:400px;
    background:#1e1f22;
    padding:40px;
    border-radius:25px;
    box-shadow:0 20px 50px rgba(0,255,100,0.2);
    text-align:center;
    animation:cardIn 1s ease forwards;
}

/* Card Heading with Checkmark */
.logout-card h2{
    color:#28a745;
    font-size:30px;
    margin-bottom:20px;
    display:flex;
    align-items:center;
    justify-content:center;
    gap:15px;
    animation:popIn 0.6s ease forwards;
}
.logout-card h2::before{
    content:"✔";
    font-size:40px;
    color:#28a745;
    animation:checkPop 0.6s ease forwards;
}

/* Paragraph */
.logout-card p{
    color:#cfd8dc;
    font-size:17px;
    margin-bottom:30px;
}

/* Button */
.logout-card a{
    display:inline-block;
    padding:15px 30px;
    border-radius:50px;
    background: linear-gradient(45deg,#28a745,#6be67e);
    color:white;
    font-size:17px;
    text-decoration:none;
    font-weight:500;
    transition:0.4s;
    box-shadow:0 5px 20px rgba(0,255,100,0.3);
}
.logout-card a:hover{
    transform:scale(1.1);
    box-shadow:0 8px 25px rgba(0,255,100,0.5);
}

/* Animations */
@keyframes gradientMove{
    0%{background-position:0% 50%;}
    50%{background-position:100% 50%;}
    100%{background-position:0% 50%;}
}
@keyframes cardIn{
    0%{opacity:0; transform:translateY(-50px);}
    60%{opacity:1; transform:translateY(10px);}
    100%{transform:translateY(0);}
}
@keyframes popIn{
    0%{opacity:0; transform:scale(0.5);}
    100%{opacity:1; transform:scale(1);}
}
@keyframes checkPop{
    0%{opacity:0; transform:scale(0);}
    60%{opacity:1; transform:scale(1.3);}
    100%{transform:scale(1);}
}
@keyframes headingPop{
    0%{opacity:0; transform:translateY(-30px);}
    100%{opacity:1; transform:translateY(0);}
}

/* Responsive */
@media(max-width:500px){
    .main-heading{ font-size:26px; margin-bottom:25px; }
    .logout-card{ width:90%; padding:30px; }
    .logout-card h2{ font-size:26px; }
    .logout-card h2::before{ font-size:35px; }
    .logout-card a{ padding:12px 25px; font-size:16px; }
}
</style>

<script>
// Auto redirect to login after 3 seconds
setTimeout(function(){
    window.location.href = "admin_login.php";
}, 3000);
</script>
</head>
<body>

<div class="diagonal-bg"></div>

<!-- Heading above logout card -->
<h1 class="main-heading">E-Waste Portal Admin Logout</h1>

<div class="logout-card">
    <h2>Logged Out</h2>
    <p>You have been safely logged out of the Admin Panel.</p>
    <a href="admin_login.php">Login Again</a>
</div>

</body>
</html>