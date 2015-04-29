<?PHP

date_default_timezone_set('Australia/Perth');

$webhookKey = 'sFNLiLZb2Md1FOaq5PIuA4Up'; // key from http://getredditalerts.com
$redditUsername = 'WhenisHL3'; //username of your bot
$redditPassword = 'Dontstoreinplaintext1'; //password of your bot


//you shouldn't need to edit anything below this line, unless you want to customize the response

ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);
echo "<pre>";

if(!isset($_POST['redditAlertJson'])){ 
	die('Missing redditAlertJson');
}

$redditAlertJson = $_POST['redditAlertJson'];

$redditAlert = json_decode($redditAlertJson);

if($redditAlert->webhookKey!=$webhookKey){
	die('Wrong webhookKey');
}

require 'reddit.php';
$reddit = new reddit($redditUsername,$redditPassword);

$file = dirname(__FILE__) . '/release-time.txt';
$new_release_time = strtotime('2197-02-01 00:00:00');

if ( file_exists($file) && is_readable($file) ) {
	if ( $current_time = file_get_contents($file) )
		$current_time =  strtotime('+1 months', $current_time);
	else
		$current_time = $new_release_time;

	file_put_contents($file, $current_time);
} else {
	file_put_contents($file, $new_release_time);
	$current_time = $new_release_time;
}

$response = $reddit->addComment($redditAlert->reddit->name,'By mentioning Half-Life 3 you have delayed it by 1 Month. Half-Life 3 is now estimated for release in ' . date('F Y', $current_time) .PHP_EOL.'___'.PHP_EOL.'^I ^am ^a ^bot, ^this ^action ^was ^performed ^automatically. ^If ^you ^have ^feedback ^please ^message ^/u/APIUM-');
  
var_dump($response);
var_dump($reddit);

exit;

