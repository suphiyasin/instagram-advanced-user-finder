<?php
session_start();
$uid = $_SESSION['idx'];
$veri = $_POST['veri'];
	$mysqli = new mysqli("localhost:3306", "root", "", "richoto");
$upo = mysqli_query($mysqli, "update Site set Statu='1' where UserID='".$uid."'");
$uo = mysqli_query($mysqli, "insert into Site (Cookie, UserID) values ('".$veri."', '".$uid."')");
echo "Oldu...";