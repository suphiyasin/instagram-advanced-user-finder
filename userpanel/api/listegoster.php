<?php
session_start();
$user = $_GET['user'];
$liste = htmlentities($user, ENT_QUOTES);
$uname = $_SESSION['username'];
$myfile = fopen("../../$uname/api/$liste.txt", "r") or die("Unable to open file!");
$a = fread($myfile,filesize("../../$uname/api/$liste.txt"));
$ulist = explode("
", $a);
foreach($ulist as $hababam){
	if($hababam == ""){
	}else{
	echo $hababam.'<br/>';
}
}
?>