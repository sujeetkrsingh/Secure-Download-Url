<?php
if(isset($_GET['f'])){
	require_once("EncryptUrl.php");
	$encrypturl=new EncryptUrl();
	$encrypturl->DownloadFile($_GET['f']);
}

