
<?php
	session_start();
	
	error_reporting(1);
	
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;
	use instagram\instagram;

	//Load Composer's autoloader
	require("./src.php");
	require("./freenomapi.php");
	require("./sorgusrc.php");
	require (__DIR__).'/vendor/autoload.php';

	$mysqli = new mysqli("localhost", "root", "", "richoto");
if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}
$ip = $_SERVER['REMOTE_ADDR'];
$uidx = $_SESSION['idx'];
$cok = mysqli_query($mysqli, "select * from Site where Statu='0' and UserID='".$uidx."'");
if(true){
	
$koc = mysqli_fetch_object($cok);
//$coki = $koc->Cookie;

	$coki = '';
	
	//	echo $coki;
	//$cokimm = strval($coki);
//	echo $cokimm;
	$_SESSION['username'] = "userpanel";
$use = new instagramx();
$use->musteri = "userpanel";
$use->cookie = $coki;
		$sorgu = new sorgu();
		$as = new freenom();

	$ayarx = $_POST['ayar'];
	$verix = $_POST['veri'];
	$ayar = htmlentities($ayarx, ENT_QUOTES);
	$veri = htmlentities($verix, ENT_QUOTES);


	if($ayar == "onerilenler"){
		$use->username = $veri;
		$use->getpk();
		$use->onerilenler();
	}
	
	else if($ayar == "ibansorgu"){
		
		$sorgu->veri = $veri;
		$sorgu->iban();
		
		
	}
	
	else if($ayar == "subdomainac"){
		
		$as->getplesk();
	$as->plesk();
	$as->getforsub();
	$as->addsubdom($veri);
	$tamdom = $veri.".webonlineforms.com";
	$ol = mysqli_query($mysqli, "insert into domains (Domain, UserID) values ('".$tamdom."', '".$_SESSION['idx']."')");
	}
	else if($ayar == "notopla"){
		$use->notopla();
		/*$use->notopla();
		$use->notopla();
		$use->notopla();*/
		
	}
	
	else if($ayar == "mailtara"){
		if($_POST['hesap'] == "1" and $_POST['mail'] == "1"){
		$use->mailtara("random");
			$use->mailtara("random");
			$use->mailtara("random");
			$use->mailtara("random");
		}
		else if($_POST['hesap'] == "2" and $_POST['mail'] == "1"){
			$use->badge = "ture";
			$use->mailtara("random");
		}
		else if($_POST['hesap'] == "2" and $_POST['mail'] == "2"){
			$use->mailtype = "webmail";
			$use->badge = "true";
			$use->mailtara("random");
		}
		else if($_POST['hesap'] == "1" and  $_POST['mail'] == "2"){
			$use->mailtype = "webmail";
			$use->mailtara("random");
		}else{
			$use->mailtara("random");
				$use->mailtara("random");
				$use->mailtara("random");
				$use->mailtara("random");
		}
	}
	else if($ayar == "domainara"){
	$sonuc = $as->domain($veri);
		$kah = json_decode($sonuc, true);
		
		$doms = $kah['free_domains'];
		
		?>
		 <div class="col-sm-12 col-xl-6">
                        <div class="bg-secondary rounded h-100 p-4">
                            <h6 class="mb-4">Result Table</h6>
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Domain name</th>
                                        <th scope="col">Statu</th>
                                        <th scope="col">TLD</th>
                                        <th scope="col">Checkout</th>
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								foreach($doms as $dom){
									$uzanti = $dom['tld'];
									$tamdom = $veri.$uzanti;
									$ava = $dom['status'];
									?>
                                    <tr>
                                        <th scope="row"><?php echo $tamdom ?></th>
                                        
										<?php
										if($ava == "AVAILABLE"){
								?>
									<td>AVAILABLE</td>
                                        <td><?php echo $uzanti ?></td>
                                        <td> <a href="./domsip.php?adi=<?php echo $veri ?>&uz=<?php echo $uzanti ?>"> <button type="button" onclick="siparis()" class="btn btn-primary m-2">Satın Al</button></a></td>
                                
                                    
									<?php
									}else{
										?>
											<td>Using...</td>
                                        <td><?php echo $uzanti ?></td>
                                        <td> <button type="button" class="btn btn-outline-primary m-2" disabled>:(</button></td>
								    <?php
									}
									?>
										</tr>
									
                                    <?php
								}
								?>
                                </tbody>
                            </table>
                        </div>
                    </div>
		<?php
	}
	else if($ayar == "hashtag"){
		$use->hastag = $veri;
		$use->hastag();
	}
	else if($ayar == "hashtagtopla"){
		$use->hastagrand();
	}
	
	else if($ayar == "fbtara"){
	$use->fbtara();	
		
		
	}
	
	else if($ayar == "dmbas"){
		
				$hesaplar = $_POST['hesaplar'];
		$taslak = $_POST['taslak'];
		
		
	$comp = preg_split('/\s+/', $hesaplar);
	if($_SESSION['dmb'] == "hazirdegil"){
	$myfile = fopen("../../$usena/api/dmbashesaplar.txt", "a") or die("Dosya Olusturulmadı PHP Surumu ile alakalı olabilir!");
	foreach($comp as $ym){
$txt = "$ym\r\n";
echo $txt.'<br/>';
fwrite($myfile, $txt);
	}
fclose($myfile);


$compx = preg_split('/\s+/', $veri);
$myfilex = fopen("../../$usena/api/dmbasilcak.txt", "a") or die("Dosya Olusturulmadı PHP Surumu ile alakalı olabilir!");
	foreach($compx as $ymx){
$txtx = "$ymx\r\n";
echo $txtx.'<br/>';
fwrite($myfilex, $txtx);
	}
fclose($myfilex);


$_SESSION['dmb'] = "hazir";
	}else{
$myfile = fopen("../../$usena/api/dmbashesaplar.txt", "r") or die("Unable to open file!");
$a = fread($myfile,filesize("../../$usena/api/dmbashesaplar.txt"));
$ulist = explode("
", $a);
$random_keys=array_rand($ulist,1);
$plu = $ulist[$random_keys];
echo $plu.'<br/>';
$plu2 = "$plu
";




$myfilex = fopen("../../$usena/api/dmbasilcak.txt", "r") or die("Unable to open file!");
$ax = fread($myfilex,filesize("../../$usena/api/dmbasilcak.txt"));
$ulistx = explode("
", $ax);
$random_keysx=array_rand($ulistx,1);
$plux = $ulistx[$random_keysx];
echo $plux.'<br/>';
$plu2x = "$plux
";
$oha = strlen($plux);
	if($oha > 30){
		
		echo '<div style="border-left:10px solid green;color:green;background-color:#2b2b2b;padding:30px;"> 30 lENGHT USERNAME , empty dmbasilcak.txt</div>';
	}
	else if($oha < 2){
		echo '<div style="border-left:10px solid green;color:green;background-color:#2b2b2b;padding:30px;">Dm List Empty!</div>';
	
	}else{

$contentsx = file_get_contents("../../$usena/api/dmbasilcak.txt");
//$contents2 = file_get_contents("dmbasilcak.txt");
$contentsx = str_replace($plu2x, '', $contentsx);
file_put_contents("../../$usena/api/dmbasilcak.txt", $contentsx);



		
		
		
		
		
		
		
		
		
		
		

		
		$hesaps = explode(":", $plu);
print_r($hesaps);

		$username = $hesaps[0];
		$password = $hesaps[1];

		$instagram = new instagram($username,$password);
		$login = $instagram->login->login();
		if($login){
			echo 'Login success';
		}else{
			echo 'Login Fail';
		}

		//LOGIN CONTROL
		$login_control = $instagram->login->login_control();
		if($login_control){
			
			$a = $instagram->user->send_inbox_text($plux,$taslak);
			print_r($a);
			echo 'Login True';
		}else{
			echo 'Login False';
		}
		
		
		
		}
		}	
	//gelen post hesaplrın sonu
	}
	
	else if($ayar == "maililetisim"){
		
	$use->mailtopla();
		$use->mailtopla();
		$use->mailtopla();
		$use->mailtopla();
		
	}
	
	
	else if($ayar == "hashtaglistesi"){
		$use->hastag();
	}
	else if($ayar == "webmail-save"){
			
		$email = $_POST['email'];
		$sifre = $_POST['sifre'];
		$port = $_POST['port'];
		$smtp = $_POST['smtp'];
			$ad = $_POST['ad'];
		$konu = $_POST['title'];
		$taslak = $_POST['taslak'];
			$iid = $_SESSION['idx'];
		$ban = mysqli_query($mysqli, "UPDATE mailsettings SET Statu='1' WHERE UserID='".$iid."'");
		$a = mysqli_query($mysqli, "INSERT INTO mailsettings (UserID, adress, passwords, port, smtplink, taslak, Statu, GozukcekAd, taslakTitle) VALUES ('".$iid."', '".$email."', '".$sifre."', '".$port."', '".$smtp."', '".$taslak."', '0', '".$ad."', '".$konu."')");
		if($a){
			echo "success...";
		}else{
			echo "erorr (look up mysqli connect infos host : 'localhost' user : 'root' pass:''  dbname: 'richoto)' - backend/api/req.php 319. line )...";
		}
	
	
	
	
	
	
	
	}
	
	else if($ayar == "wpbas"){
	$apikey = $_POST['apikey'];
		$taslak = $_POST['taslak'];
		$nolar = explode(" ", $veri);
		foreach($nolar as $nos){
$curl = curl_init();

curl_setopt_array($curl, [
  CURLOPT_URL => "https://api.wali.chat/v1/messages",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
 CURLOPT_SSL_VERIFYPEER => false,
 CURLOPT_SSL_VERIFYHOST => FALSE,
  CURLOPT_POSTFIELDS => '{\"phone\":\"'.$nos.'\",\"message\":\"'.$taslak.'"}',
CURLOPT_HTTPHEADER => [
    "Content-Type: application/json",
    "Token: ".$apikey.""
  ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
		}
		
		
	}
	

else if($ayar == "mailbas"){
			echo " VERI BU SEKİLDE ".$veri."<BR/>";
	$comp = preg_split('/\s+/', $veri);
	if($_SESSION['mailb'] == "hazirdegil"){
	$myfile = fopen("../../$usena/api/mailbasilcak.txt", "a") or die("Dosya Olusturulmadı PHP Surumu ile alakalı olabilir!");
	foreach($comp as $ym){
$txt = "$ym\r\n";
echo $txt.'<br/>';
fwrite($myfile, $txt);
	}
fclose($myfile);
$_SESSION['mailb'] = "hazir";
	}else{
$myfile = fopen("../../$usena/api/mailbasilcak.txt", "r") or die("Unable to open file!");
$a = fread($myfile,filesize("../../$usena/api/mailbasilcak.txt"));
$ulist = explode("
", $a);
$random_keys=array_rand($ulist,1);
$plu = $ulist[$random_keys];
echo $plu.'<br/>';
$plu2 = "$plu
";
$oha = strlen($plu);
	if($oha > 30){
		unlink('../../$usena/api/mailbasilcak.txt');
		echo '<div style="border-left:10px solid green;color:green;background-color:#2b2b2b;padding:30px;">30Haneden Yuksek Mail Var</div>';
	}
	else if($oha < 2){
		echo '<div style="border-left:10px solid green;color:green;background-color:#2b2b2b;padding:30px;">Mailler Basma Başlatıldı!</div>';
	
	}else{

$contents = file_get_contents("../../$usena/api/mailbasilcak.txt");
//$contents2 = file_get_contents("mailbasilcak.txt");
$contents = str_replace($plu2, '', $contents);
file_put_contents("../../$usena/api/mailbasilcak.txt", $contents);
	$mysqli = new mysqli("localhost", "root", "", "richoto");
		$mailcek = mysqli_query($mysqli, "select * from mailsettings where Statu='0' and UserID='".$_SESSION['idx']."'");
		$ingo = mysqli_fetch_object($mailcek);

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
  //  $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $ingo->smtplink;                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $ingo->adress;                     //SMTP username
    $mail->Password   = $ingo->passwords;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $ingo->port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($ingo->adress, $ingo->GozukcekAd);

	
    $mail->addAddress($plu);               //Name is optional


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $ingo->taslakTitle;
    $mail->Body    = $ingo->taslak;
  //  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

    echo $plu.' Mail Gönderildi <br/>';
	
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
	
	
}
	}
	
}
	
	
	else if($ayar == "mailbasv2"){
			echo " VERI BU SEKİLDE ".$veri."<BR/>";
	$comp = preg_split('/\s+/', $veri);
	if($_SESSION['mailb'] == "hazirdegil"){
	$myfile = fopen("../../$usena/api/mailbasilcak.txt", "a") or die("Dosya Olusturulmadı PHP Surumu ile alakalı olabilir!");
	foreach($comp as $ym){
$txt = "$ym\r\n";
echo $txt.'<br/>';
fwrite($myfile, $txt);
	}
fclose($myfile);
$_SESSION['mailb'] = "hazir";
	}else{
$myfile = fopen("../../$usena/api/mailbasilcak.txt", "r") or die("Unable to open file!");
$a = fread($myfile,filesize("../../$usena/api/mailbasilcak.txt"));
$ulist = explode("
", $a);
$random_keys=array_rand($ulist,1);
$plu = $ulist[$random_keys];
echo $plu.'<br/>';
		$explu = explode(":", $plu);
$plu2 = "$plu
";
				$contentsxx = file_get_contents("../../$usena/api/mailbasilcak.txt");
			$contentsxx = str_replace($plu2, '', $contentsxx);
//$contents2 = str_replace('', '', $contents2);
file_put_contents("../../$usena/api/mailbasilcak.txt", $contentsxx);
$oha = strlen($plu);
	if($oha > 50){
		unlink("../../$usena/api/mailbasilcak.txt");
		echo '<div style="border-left:10px solid green;color:green;background-color:#2b2b2b;padding:30px;">30Haneden Yuksek Mail Var</div>';
	}
	else if($oha < 2){
		echo '<div style="border-left:10px solid green;color:green;background-color:#2b2b2b;padding:30px;">Mailler Basma Başlatıldı!</div>';
	
	}else{

$contents = $_POST['taslx'];
//$contents2 = file_get_contents("mailbasilcak.txt");
$contents = str_replace('[username]', $explu[0], $contents);
	$mysqli = new mysqli("localhost", "root", "", "richoto");
		$mailcek = mysqli_query($mysqli, "select * from mailsettings where Statu='0' and UserID='".$_SESSION['idx']."'");
		$ingo = mysqli_fetch_object($mailcek);
		echo $ingo->passwords;

		
		
		
//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
   // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = $ingo->smtplink;                     //Set the SMTP server to send through
   $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = $ingo->adress;                     //SMTP username
    $mail->Password   = $ingo->passwords;                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = $ingo->port;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($ingo->adress, $ingo->GozukcekAd);

	
    $mail->addAddress($explu[1]);               //Name is optional


    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $ingo->taslakTitle;
    $mail->Body    = $contents;
  //  $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

    $mail->send();

    echo $explu[1].' Mail Gönderildi <br/>';
	
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
	
	
}
	}
	
}

else if($ayar == "messbas"){
			echo " VERI BU SEKİLDE ".$veri."<BR/>";
	$comp = preg_split('/\s+/', $veri);
	if($_SESSION['messb'] == "hazirdegil"){
	$myfile = fopen("../../$usena/api/messbasilcak.txt", "a") or die("Dosya Olusturulmadı PHP Surumu ile alakalı olabilir!");
	foreach($comp as $ym){
$txt = "$ym\r\n";
echo $txt.'<br/>';
fwrite($myfile, $txt);
	}
fclose($myfile);
$_SESSION['messb'] = "hazir";
	}else{
$myfile = fopen("../../$usena/api/messbasilcak.txt", "r") or die("Unable to open file!");
$a = fread($myfile,filesize("../../$usena/api/messbasilcak.txt"));
$ulist = explode("
", $a);
$random_keys=array_rand($ulist,1);
$plu = $ulist[$random_keys];
echo $plu.'<br/>';
$plu2 = "$plu
";
		$explu = explode(":", $plu);
$plu2 = "$plu
";
$oha = strlen($plu);
	if($oha > 50){
	//	unlink("../../$usena/api/messbasilcak.txt");
		echo '<div style="border-left:10px solid green;color:green;background-color:#2b2b2b;padding:30px;">30Haneden Yuksek ID Var</div>';
	}
	/*else if($oha < 2){
		echo '<div style="border-left:10px solid green;color:green;background-color:#2b2b2b;padding:30px;">Messenger Basma Başlatıldı!</div>';
	
	}*/
		else{
echo $
$contents = $_POST['taslx'];
//$contents2 = file_get_contents("mailbasilcak.txt");
		$contentsxx = file_get_contents("../../$usena/api/messbasilcak.txt");
$contents = str_replace('[username]', $explu[0], $contents);
		$contentsxx = str_replace($plu2, '', $contentsxx);
//$contents2 = str_replace('', '', $contents2);
file_put_contents("../../$usena/api/messbasilcak.txt", $contentsxx);
$use->messcookie = $_POST['cook'];
	$use->messid = $_POST['idiniz'];
		$use->sendmess("169663259740564", "denemee");
}
	
	
	}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
else if($ayar == "onerilenliste"){
	$use->onerilenlerliste();
	
	
}


else if($ayar == "mailminmax"){
	$use->followermin = $veri;
	$use->followermax = $_POST['veri2'];
	$use->mailtara("random");
	
}

else if($ayar == "mail4l"){
	$use->lenght = $veri;

	$use->mailtara("random");
	
}

else if($ayar == "reg4l"){
	$use->lenght = $veri;
$use->userchecker();
	
}

else if($ayar == "sckur"){
	echo "Deleted this function for security";
	
	
	
	
}

else if($ayar == "giris"){
include("getlogin.php");
$log = new  logi();
$log->keyx = $_POST['pw'];
$log->uname = $veri;
$log->loginx();

}



}else{
	echo 'IP ADRESINIZ : <b>'.$ip.'</b><br/>';
	echo "Sistemde Bir Sorun oluştu...";
}
