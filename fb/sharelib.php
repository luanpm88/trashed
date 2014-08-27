<?php
require_once('../configs/config.inc.php');
require_once('Encoding.php'); 
use \ForceUTF8\Encoding;  // It's namespaced now.

function utf8_to_ascii($str) {
	$chars = array(
		'a' => array('ấ','ầ','ẩ','ẫ','ậ','Ấ','Ầ','Ẩ','Ẫ','Ậ','ắ','ằ','ẳ','ẵ','ặ','Ắ','Ằ','Ẳ','Ẵ','Ặ','á','à','ả','ã','ạ','â','ă','Á','À','Ả','Ã','Ạ','Â','Ă'),
		'e' => array('ế','ề','ể','ễ','ệ','Ế','Ề','Ể','Ễ','Ệ','é','è','ẻ','ẽ','ẹ','ê','É','È','Ẻ','Ẽ','Ẹ','Ê'),
		'i' => array('í','ì','ỉ','ĩ','ị','Í','Ì','Ỉ','Ĩ','Ị'),
		'o' => array('ố','ồ','ổ','ỗ','ộ','Ố','Ồ','Ổ','Ô','Ộ','ớ','ờ','ở','ỡ','ợ','Ớ','Ờ','Ở','Ỡ','Ợ','ó','ò','ỏ','õ','ọ','ô','ơ','Ó','Ò','Ỏ','Õ','Ọ','Ô','Ơ'),
		'u' => array('ứ','ừ','ử','ữ','ự','Ứ','Ừ','Ử','Ữ','Ự','ú','ù','ủ','ũ','ụ','ư','Ú','Ù','Ủ','Ũ','Ụ','Ư'),
		'y' => array('ý','ỳ','ỷ','ỹ','ỵ','Ý','Ỳ','Ỷ','Ỹ','Ỵ'),
		'd' => array('đ','Đ')
	);
	foreach ($chars as $key => $arr)
		foreach ($arr as $val)
		{
			$str = str_replace($val,$key,strtolower($str));
			$str = preg_replace("/ /", '-', $str);
		}	
	return $str;
}

function stringToURI($string)
{
	return preg_replace("/\-$/", '', preg_replace("/\-(\-)+/", '-', preg_replace("/[^A-Za-z0-9 \-]/", '', utf8_to_ascii($string))));
}

// determine script invocation (CLI or Web Server)
if(php_sapi_name() == 'cli') {
  $line_break = PHP_EOL;
} else {
  $line_break = '<br>';
}

require_once("sdk/facebook.php"); // set the right path

$config = array();
$config['appId'] = '632064076907388';
$config['secret'] = 'ad9ff0da7689970bff20c31ac770f90c';
$config['fileUpload'] = false; // optional
$fb = new Facebook($config);

// connect to database
//$conn = new mysqli("localhost", "marketon_user", "aA456321@", "marketon_main"); // configure appropriately
$conn = new mysqli($dbhost, $dbuser, $dbpasswd, $dbname); // configure appropriately
// check connection
if ($conn->connect_error) {
  trigger_error('Database connection failed: '  . $conn->connect_error, E_USER_ERROR);
}
mysqli_set_charset( $conn, 'utf8' );

//get message template
$sql = 'SELECT *'    
    .' FROM pb_announcements'
    .' WHERE id=21'
    .' LIMIT 1';
$mm = $conn->query($sql);
if($mm === false) {
  $user_error = 'Wrong SQL: ' . $sql . '<br>' . 'Error: ' . $conn->errno . ' ' . $conn->error;
  trigger_error($user_error, E_USER_ERROR);
}
$mm->data_seek(0);
$template = $mm->fetch_assoc();
$message = Encoding::toUTF8($template["message"]);
$message = strip_tags(str_replace("<br />","\n",$message));
?>