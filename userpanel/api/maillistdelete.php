<?php
session_start();
$fa = array("maillist.txt", "userlist.txt", "nolist.txt", "dmbasilcak.txt", "unamelist.txt", "mailbasilcak.txt", "hashtaglist.txt");
foreach($fa as $f){
unlink($f);
touch($f);
}
header("Location: ../panel/");
?>