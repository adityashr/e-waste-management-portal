<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include("config.php");

$msg = "";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['request'])) {

    $waste_type = trim($_POST['waste_type']);
    $address    = trim($_POST['address']);
    $date       = trim($_POST['date']);

    if (empty($waste_type) || empty($address) || empty($date)) {
        $msg = "All fields are required!";
    } else {
        $stmt = $conn->prepare("INSERT INTO pickups (user_id, waste_type, address, pickup_date, status) VALUES (?, ?, ?, ?, 'Pending')");
        $stmt->bind_param("isss", $user_id, $waste_type, $address, $date);

        if ($stmt->execute()) {
            $_SESSION['msg'] = "Pickup Request Submitted Successfully!";
            header("Location: mypickups.php");
            exit();
        } else {
            $msg = "Database Error!";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Schedule Pickup</title>
    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:'Segoe UI',sans-serif;
        }

        /* Body with animated diagonal half-green/half-black */
        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background: linear-gradient(135deg, #26ac24 50%, #18191a 50%);
            background-size: 200% 200%;
            animation: bgDiagonal 10s linear infinite alternate;
        }

        @keyframes bgDiagonal{
            0%{background-position:0% 0%;}
            50%{background-position:100% 50%;}
            100%{background-position:0% 100%;}
        }

        /* Centered container */
        .container-wrapper{
            text-align:center;
            width:100%;
        }

        /* Top Heading */
        .hero h1{
            font-size:42px;
            color:white;
            margin-bottom:30px;
            text-shadow:2px 2px 8px rgba(0,0,0,0.6);
        }

        /* Card */
        .container{
            width:400px;
            background:white;
            border-radius:20px;
            box-shadow:0 15px 40px rgba(0,0,0,0.2);
            padding:35px;
            margin:auto;
            transform: translateY(-20px);
            opacity:0;
            animation:slideUp 1s forwards;
        }

        @keyframes slideUp{
            0%{opacity:0; transform:translateY(50px);}
            100%{opacity:1; transform:translateY(0);}
        }

        /* Form Heading */
        .container h2{
            text-align:center;
            font-size:26px;
            color:#28a745;
            margin-bottom:25px;
        }

        /* Inputs */
        .container label{
            font-weight:500;
            margin-top:10px;
            display:block;
            color:#333;
            text-align: left;
        }

        .container select, 
        .container textarea, 
        .container input[type="date"]{
            width:100%;
            padding:12px;
            margin-top:8px;
            border-radius:8px;
            border:1px solid #ccc;
            font-size:14px;
            transition:0.3s;
        }

        .container select:focus, 
        .container textarea:focus, 
        .container input[type="date"]:focus{
            outline:none;
            border-color:#28a745;
            box-shadow:0 0 10px rgba(40,167,69,0.3);
        }

        /* Button */
        .btn{
            width:100%;
            padding:14px;
            background:#28a745;
            color:white;
            border:none;
            border-radius:10px;
            font-size:16px;
            font-weight:bold;
            margin-top:20px;
            cursor:pointer;
            transition:0.3s;
        }

        .btn:hover{
            background:#218838;
            transform:scale(1.05);
            box-shadow:0 6px 18px rgba(0,0,0,0.3);
        }

        /* Success Message */
        .msg{
            margin-top:15px;
            padding:12px;
            background:#d4edda;
            color:#155724;
            border-radius:8px;
            text-align:center;
            animation:fadeIn 0.8s ease-in-out;
        }

        @keyframes fadeIn{
            0%{opacity:0;}
            100%{opacity:1;}
        }

        /* Responsive */
        @media(max-width:500px){
            .container{
                width:95%;
                padding:25px;
            }
        }
    </style>
</head>
<body>

<div class="container-wrapper">
    <div class="hero">
        <h1>♻ E-Waste Management Portal</h1>
    </div>

    <div class="container">
        <h2>E-Waste Pickup</h2>

        <form method="POST">
            <label>Waste Type</label>
            <select name="waste_type" required>
                <option value="">Select Waste Type</option>
                <option value="Mobile">Mobile</option>
                <option value="Laptop">Laptop</option>
                <option value="Battery">Battery</option>
                <option value="Plastic">Plastic</option>
                <option value="E-Waste Mixed">E-Waste Mixed</option>
                <option value="Others">Others</option>
            </select>

            <label>Address</label>
            <textarea name="address" placeholder="Enter your address..." required></textarea>

            <label>Pickup Date</label>
            <input type="date" name="date" required>

            <button class="btn" type="submit" name="request">Request Pickup</button>
        </form>

        <?php
        if (!empty($msg)) {
            echo "<div class='msg'>$msg</div>";
        }
        ?>
    </div>
</div>

</body>
</html>