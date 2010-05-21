<?

ini_set( "include_path", dirname(__FILE__)."/.." );
$IP = $GLOBALS["IP"];
require_once( "commandLine.inc" );
require_once( $IP."/extensions/wikia/Scribe/ScribeClient.php" );

$wgScribeHost = '10.10.10.163';
$wgScribePort = 1463;

$count = 50000;
for ( $i = 0; $i <= $count; $i++ ) {
	echo "send $i message \n";
	$res = WScribeClient::singleton('cat_test')->send('msg_test' . $i);
}
echo print_r($res, true) . "\n";

?>
