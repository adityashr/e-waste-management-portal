<?php
session_start();
include("config.php");

if(!isset($_SESSION['user_id'])){
header("Location: login.php");
exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_GET['ids'])){

$ids = explode(",",$_GET['ids']);

foreach($ids as $id){

$stmt = $conn->prepare("DELETE FROM pickups WHERE id=? AND user_id=? AND status='Pending'");
$stmt->bind_param("ii",$id,$user_id);
$stmt->execute();

}

$_SESSION['msg']="Selected pickups cancelled";

}

header("Location: mypickups.php");
?>