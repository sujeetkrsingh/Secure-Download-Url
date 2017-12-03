<?php

class EncryptUrl{

	public function __construct() {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        $this->key="RiV3wc8uojflkaKLhkPYHU3Hkjd2";
    }

    private function encrypt($data){
        $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_CBC);
        $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
        $crypttext = mcrypt_encrypt(MCRYPT_BLOWFISH, $this->key, $data, MCRYPT_MODE_CBC, $iv);
        return bin2hex($iv . $crypttext);
    }

    private function decrypt($data){
        $iv=pack("H*" , substr($data,0,16));
        $x =pack("H*" , substr($data,16)); 
        $res = mcrypt_decrypt(MCRYPT_BLOWFISH, $this->key, $x , MCRYPT_MODE_CBC, $iv);
        return $res;
    }

    public function getDownloadLink($file)
    {
        //$this->removeOldSession($file);
        $existingkey=$this->getExistingFile($file);
        if($existingkey)
            return 'download.php?f='.$existingkey;

        $fileuk=uniqid();
        $_SESSION['enc_url_ts'][$fileuk]=$this->encrypt($file);
    	return 'download.php?f='.$this->encrypt($fileuk);
    }

    public function DownloadFile($data)
    {
        $fileuk=trim($this->decrypt($data));
        if(!isset($_SESSION['enc_url_ts'][$fileuk])){
            header('HTTP/1.1 403 Forbidden');
            echo "Forbidden to access this file";
            return;
        }
        $file=trim($this->decrypt($_SESSION['enc_url_ts'][$fileuk]));
        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary"); 
        header("Content-disposition: attachment; filename=\"".$file."\""); 
        readfile($file);
    }

    private function removeOldSession($file){
        if(isset($_SESSION['enc_url_ts']))
            foreach($_SESSION['enc_url_ts'] as $key=>$value){
                if(trim($this->decrypt($value))==$file){
                    unset($_SESSION['enc_url_ts'][$key]);
                }
            }
    }

    private function getExistingFile($file){
        if(isset($_SESSION['enc_url_ts']))
            foreach($_SESSION['enc_url_ts'] as $key=>$value){
                if(trim($this->decrypt($value))==$file){
                    return $this->encrypt($key);
                }
            }
        return false;
    }

    

}