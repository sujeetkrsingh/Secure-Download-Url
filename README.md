# Secure Download Url
PHP Class to generate a secure download url for a file on the server.
## Descriptioin
When we create a download url for any file on the server we also reveal its path on the server. It provide hint to the hackers of our website structure. This is very critical security vulnerability for any website especially for those who offer paid/restricted content to their visitors/users. This PHP class will help you in generating a encrypted and secure URL for your files on the server.

## How to install
Include the EncryptUrl.php file in your script and create an object of class <code>EncryptUrl</code>

```php 
require_once("EncryptUrl.php");
$encrypturl=new EncryptUrl();
```

Next you need to generate download link for you file. Call <code>getDownloadLink</code> method
```php
$downloadlink=$encrypturl->getDownloadLink('phplogo.png');
```
You can pass this link to an anchor tag if want user to download file or pass or img tag if the file is an image and your want to show it to user. The same script work both way.
```html
<a href="<?php echo $downloadlink ?>">Download Link</a>
<img src="<?php echo $downloadlink ?>" />
```