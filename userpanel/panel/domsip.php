<?php
include("../api/freenomapi.php");
$as = new freenom();
$as->freemail = "FREENOMMAIL";
$as->freepas = "FREEENOMPASSWORD";
$as->freelog();
$as->freenlogstep2();

	$verix = $_GET['adi'];

	$veri = htmlentities($verix, ENT_QUOTES);
	$uzx = $_GET['uz'];

	$uzanti = htmlentities($uzx, ENT_QUOTES);
//echo $veri.'  ve bu '.$uzanti;
$as->domain($veri, $uzanti);