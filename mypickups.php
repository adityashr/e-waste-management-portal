<?php
session_start();
include("config.php");

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

/* Cancel Single Pickup */
if(isset($_GET['cancel'])){
    $id = $_GET['cancel'];
    $stmt = $conn->prepare("DELETE FROM pickups WHERE id=? AND user_id=? AND status='Pending'");
    $stmt->bind_param("ii",$id,$user_id);
    $stmt->execute();
    $_SESSION['msg']="Pickup Cancelled Successfully";
    header("Location: mypickups.php");
    exit();
}

/* Current user pickups */
$stmt = $conn->prepare("SELECT * FROM pickups WHERE user_id=? ORDER BY id DESC");
$stmt->bind_param("i",$user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
<title>My Pickup Requests</title>
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
<style>
* { margin:0; padding:0; box-sizing:border-box; font-family:'Segoe UI',sans-serif; }
body{ background: linear-gradient(135deg, #097633 50%, #18191a 50%); min-height:100vh; padding:40px; }

/* Top Bar */
.topbar{ text-align:center; font-size:26px; font-weight:bold; color:white; padding:20px;
background: linear-gradient(90deg,#28a745,#20c997); border-radius:12px; box-shadow:0 10px 25px rgba(0,0,0,0.2);
margin-bottom:30px; }

/* Container */
.container{ max-width:1200px; margin:0 auto; }

/* Table Card */
.table-card{ background:white; padding:25px; border-radius:15px; box-shadow:0 15px 35px rgba(0,0,0,0.1); }

/* Table */
table{ width:100%; border-collapse:collapse; margin-top:15px; }
th{ background:#28a745; color:white; padding:14px; text-align:center; font-size:16px; }
td{ padding:12px; border-bottom:1px solid #eee; text-align:center; vertical-align:middle; }
tr:hover{ background:#f1fdf5; transition:0.3s; }

/* Status */
.status{ padding:6px 14px; border-radius:20px; font-size:13px; font-weight:bold; display:inline-block; }
.pending{background:#fff3cd;color:#856404;}
.completed{background:#d4edda;color:#155724;}
.rejected{background:#f8d7da;color:#721c24;}

/* Buttons */
.btn{ padding:7px 16px; border-radius:25px; font-size:13px; text-decoration:none; color:white; display:inline-block; margin:2px; font-weight:500; cursor:pointer;}
.track-btn{background:linear-gradient(45deg,#28a745,#20c997);}
.cancel-btn{background:linear-gradient(45deg,#ff416c,#ff4b2b);}
.review-btn{background:linear-gradient(45deg,#6f42c1,#8e44ad);}
.btn:hover{ transform:translateY(-3px) scale(1.05); box-shadow:0 6px 15px rgba(0,0,0,0.2); }

.action-buttons{ display:flex; justify-content:center; flex-wrap:wrap; gap:8px; }

@media(max-width:768px){ table, th, td{ font-size:13px; } .btn{ font-size:12px; padding:6px 12px; } }

/* Floating Logout Button - bottom right */
.action-card{
    position: fixed;
    bottom: 20px;
    right: 20px;
    z-index: 9999;
}

.action-card a{
    display:inline-block;
    padding:12px 25px;
    background:#28a745;
    color:#fff;
    text-decoration:none;
    border-radius:10px;
    font-weight:bold;
    transition:0.3s;
}

.action-card a:hover{
    background:#218838;
    transform:scale(1.05);
}
</style>
</head>
<body>

<div class="topbar">📦 My Pickup Requests</div>

<div class="container">
    <div class="table-card">
        <table>
            <tr>
                <th>ID</th>
                <th>Waste Type</th>
                <th>Address</th>
                <th>Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $result->fetch_assoc()){ ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['waste_type']); ?></td>
                <td><?php echo htmlspecialchars($row['address']); ?></td>
                <td><?php echo $row['pickup_date']; ?></td>
                <td><span class="status <?php echo strtolower($row['status']); ?>"><?php echo $row['status']; ?></span></td>
                <td>
                    <div class="action-buttons">
                        <?php if($row['status']=="Rejected"){ ?>
                        <span class="reject-msg" style="color:red;font-weight:bold;">Rejected</span>
                        <?php } else { ?>
                        <a href="trackpickup.php?id=<?php echo $row['id']; ?>" class="btn track-btn">Track</a>
                        <?php } ?>
                        <?php if($row['status']=="Pending"){ ?>
                        <a href="mypickups.php?cancel=<?php echo $row['id']; ?>" class="btn cancel-btn" onclick="return confirm('Cancel this pickup?');">Cancel</a>
                        <?php } ?>
                        <?php if($row['status']=="Completed"){ ?>
                        <a href="review.php?pickup_id=<?php echo $row['id']; ?>" class="btn review-btn">Give Review</a>
                        <?php } ?>
                    </div>
                </td>
            </tr>
            <?php } ?>
        </table>
    </div>
</div>

<?php if(isset($_SESSION['msg'])): ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded",function(){
    Swal.fire({
        title:"Success 🎉",
        text:"<?php echo $_SESSION['msg']; ?>",
        icon:"success",
        confirmButtonColor:"#28a745",
        timer:3000
    });
});
</script>
<?php unset($_SESSION['msg']); endif; ?>

<!-- Logout button only, bottom right -->
<div class="action-card">
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

</body>
</html>