<?php
session_start();
include("config.php");

// Redirect if not logged in
if(!isset($_SESSION['admin'])){
    header("Location: admin_login.php");
    exit();
}

// Fetch dynamic counts from database
$totalUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM users"))['total'];
$totalPickups = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pickups"))['total'];
$completedPickups = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pickups WHERE status='Completed'"))['total'];
$pendingPickups = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM pickups WHERE status='Pending'"))['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Dashboard | E-Waste Portal</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<style>
*{margin:0;padding:0;box-sizing:border-box;font-family:'Poppins',sans-serif;}
body{
    display:flex;
    min-height:100vh;
    background:#18191a;
    color:white;
    overflow-x:hidden;
}

/* SOLID GREEN DIAGONAL BACKGROUND */
.diagonal-bg{
    position:fixed;
    top:0; left:-100%;
    width:200%; height:200%;
    background:#28a745;
    transform:rotate(-45deg);
    animation: diagonalMove 10s linear infinite;
    z-index:0;
    opacity:0.3;
}

/* SIDEBAR */
.sidebar{
    width:260px;
    height:100vh;
    background:linear-gradient(180deg,#1e3a8a,#3b82f6);
    color:white;
    position:fixed;
    padding-top:30px;
    z-index:1;
    transition:0.5s;
}
.sidebar h2{
    text-align:center;
    margin-bottom:30px;
    color:#facc15;
    font-size:26px;
    animation: glow 2s infinite alternate;
}
.sidebar a{
    display:flex;
    align-items:center;
    gap:12px;
    padding:16px 24px;
    text-decoration:none;
    color:#d1d5db;
    font-weight:500;
    border-radius:10px;
    margin:6px 10px;
    transition:0.4s;
}
.sidebar a i{
    font-size:18px;
}
.sidebar a:hover{
    background:linear-gradient(45deg,#28a745,#20c997);
    color:white;
    padding-left:32px;
    box-shadow:0 4px 15px rgba(0,0,0,0.3);
}

/* MAIN CONTENT */
.main{
    margin-left:260px;
    width:100%;
    padding:30px;
    z-index:1;
}

/* TOPBAR */
.topbar{
    background:white;
    color:#111827;
    padding:20px 30px;
    border-radius:14px;
    box-shadow:0 8px 25px rgba(0,0,0,0.15);
    margin-bottom:30px;
    display:flex;
    justify-content:space-between;
    align-items:center;
}
.topbar h2{
    font-size:26px;
    color:#1e3a8a;
}
.topbar .logout-btn{
    padding:10px 20px;
    border-radius:8px;
    background: linear-gradient(45deg,#28a745,#20c997);
    color:white;
    text-decoration:none;
    font-weight:600;
    transition:0.3s;
}
.topbar .logout-btn:hover{
    transform:scale(1.05);
    box-shadow:0 6px 20px rgba(0,0,0,0.3);
}

/* CARDS */
.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(220px,1fr));
    gap:20px;
}
.card{
    background:white;
    color:#111827;
    padding:30px;
    border-radius:20px;
    box-shadow:0 20px 25px rgba(0,0,0,0.1);
    position:relative;
    overflow:hidden;
    cursor:pointer;
    transition:0.5s;
}
.card::before{
    content:''; position:absolute; top:-50%; left:-50%;
    width:200%; height:200%;
    background:rgba(40,167,69,0.05);
    transform:rotate(55deg);
    transition:0.5s;
}
.card:hover::before{
    background:rgba(40,167,69,0.15);
}
.card:hover{
    transform:translateY(-10px) scale(1.03);
    box-shadow:0 25px 50px rgba(0,0,0,0.15);
}
.card h3{margin-bottom:12px;font-size:20px;}
.card p{font-size:32px;font-weight:600;color:#16a34a;}

/* Counter animation */
.counter{
    font-size:32px;
    font-weight:600;
    color:#16a34a;
}

/* ANIMATIONS */
@keyframes glow{
    0%{text-shadow:0 0 5px #facc15;}
    50%{text-shadow:0 0 20px #fde047;}
    100%{text-shadow:0 0 5px #facc15;}
}
@keyframes diagonalMove{
    0% { left:-100%; }
    100% { left:0%; }
}

/* RESPONSIVE */
@media(max-width:768px){
    .sidebar{width:200px;}
    .main{margin-left:200px;}
}
@media(max-width:600px){
    body{flex-direction:column;}
    .sidebar{width:100%; position:relative;}
    .main{margin-left:0;}
    .cards{grid-template-columns:1fr;}
}
</style>
</head>
<body>

<div class="diagonal-bg"></div>

<!-- SIDEBAR -->
<div class="sidebar">
    <h2>Admin Panel</h2>
    <a href="admin_dashboard.php"><i class="fa-solid fa-gauge"></i>Dashboard</a>
    <a href="admin_users.php"><i class="fa-solid fa-users"></i>Users</a>
    <a href="admin_pickups.php"><i class="fa-solid fa-box"></i>Pickups</a>
    <a href="admin_managed_center.php"><i class="fa-solid fa-location-dot"></i>Manage Centers</a>
    <a href="admin_logout.php"><i class="fa-solid fa-right-from-bracket"></i>Logout</a>
</div>

<!-- MAIN -->
<div class="main">
    <div class="topbar">
        <h2>Welcome <?php echo $_SESSION['admin']; ?></h2>
        <a href="admin_logout.php" class="logout-btn">Logout</a>
    </div>

    <div class="cards">
        <div class="card">
            <h3>Total Users</h3>
            <p class="counter" data-target="<?php echo $totalUsers; ?>">0</p>
        </div>
        <div class="card">
            <h3>Pickup Requests</h3>
            <p class="counter" data-target="<?php echo $totalPickups; ?>">0</p>
        </div>
        <div class="card">
            <h3>Completed</h3>
            <p class="counter" data-target="<?php echo $completedPickups; ?>">0</p>
        </div>
        <div class="card">
            <h3>Pending</h3>
            <p class="counter" data-target="<?php echo $pendingPickups; ?>">0</p>
        </div>
    </div>
</div>

<script>
// Counter animation
const counters = document.querySelectorAll('.counter');
counters.forEach(counter => {
    const updateCount = () => {
        const target = +counter.getAttribute('data-target');
        const count = +counter.innerText;
        const increment = target / 200;
        if(count < target){
            counter.innerText = Math.ceil(count + increment);
            setTimeout(updateCount, 15);
        } else{
            counter.innerText = target;
        }
    }
    updateCount();
});
</script>

</body>
</html>