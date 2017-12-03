<?php require_once("EncryptUrl.php"); $encrypturl=new EncryptUrl(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Encrypt URL Example</title>
</head>
<body>
	<a href="<?php echo $encrypturl->getDownloadLink('phplogo.png'); ?>">AWS Logo</a><br>
	<img src="<?php echo $encrypturl->getDownloadLink('phplogo.png'); ?>" width="200"><br>
</body>
</html>