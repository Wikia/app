<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	ini_set( "include_path", dirname(__FILE__)."/.." );
	require_once( 'commandLine.inc' );
}

$USAGE = 
	"Usage: php generateLangFile.php [--lang=(all|ja|zh|zh-tw|pl|...)] [--removedb=(no|yes)] [--merge=(no|yes)] [--filename=Messages%s.php] [--dir=/tmp] | --help\n" .
	"\toptions:\n" .
	"\t\t--help	show this message\n" .
	"\t\t--lang	language code (default: 'all': generate all messages)\n" .
	"\t\t--removedb	remove articles from database, default: no\n".
	"\t\t--merge	merge with existing wikia messages, default: no\n".
	"\t\t--filename	format of output filename, default: Messages%s.php (where '%s' is a --lang parameter)\n".
	"\t\t--dir	 output dir name, default: '/tmp' \n";

if ( in_array( '--help', $argv ) ) {
	wfDie( $USAGE );
}

$params = @$options;
$lang = (array_key_exists('lang', $params) && !empty($params['lang'])) ? $params['lang'] : 'all';
$removedb = (array_key_exists('removedb', $params) && !empty($params['removedb'])) ? $params['removedb'] : 'no';
$merge = (array_key_exists('merge', $params) && !empty($params['merge'])) ? $params['merge'] : 'no';
$filename = (array_key_exists('filename', $params) && !empty($params['filename'])) ? $params['filename'] : 'Messages%s.php';
$dir = (array_key_exists('dir', $params) && !empty($params['dir'])) ? $params['dir']: '/tmp';

$maxRevId = wfGenerateMessagesFile($lang, $removedb, $merge, $filename, $dir);
echo "\n\$maxRevId = $maxRevId\n";

function wfGenerateMessagesFile($lang_param, $removedb, $merge, $filename, $dir) {
	global $wgDefaultMessagesDB, $wgContLang, $IP;
	
	#-- takes data from DB
	$dbr = wfGetDB( DB_SLAVE );
	$res = $dbr->select( array( "`$wgDefaultMessagesDB`.`page`", "`$wgDefaultMessagesDB`.`revision`", "`$wgDefaultMessagesDB`.`text`" ),
		array( 'page_id', 'page_title', 'old_text', 'old_flags', 'page_namespace', 'rev_id' ),
		array( 'rev_text_id=old_id', 'page_latest=rev_id', 'page_is_redirect' => 0, 'page_namespace' => NS_MEDIAWIKI ),
		__METHOD__ );

	$defaultMessages = array();
	$articleToRemove = array();
	$maxRevId = 0;
	while ( $row = $dbr->fetchObject( $res ) ) {
		$maxRevId = max( $maxRevId, $row->rev_id );
		$lckey = $wgContLang->lcfirst( $row->page_title );
		if( strpos( $lckey, '/' ) ) {
			$t = explode( '/', $lckey );
			$key = $t[0];
			$lang = $t[1];
		} else {
			$key = $lckey;
			$lang = 'en';
		}
		#--- check lang parameter
		if (!(($lang_param != 'all') && ($lang != $lang_param))) {
			$value = Revision::getRevisionText( $row );
			$defaultMessages[$lang][$key] = array( 'key' => $key, 'value' => $value, 'lang' => $lang );
			if ( $removedb == 'yes' ) {
				$articleToRemove[] = array('name' => $row->page_title, 'ns' => $row->page_namespace);
			}
		}
	}
	$dbr->freeResult( $res );
	
	#--- generate PHP file
	if (!empty($defaultMessages)) {
		foreach ($defaultMessages as $l => $m) 
		{
			$code = $wgContLang->ucfirst( $l );
			$code = str_replace( '-', '_', $code );
			$messages = array();
			if( $merge == 'yes' && file_exists( "$IP/languages/messages/wikia/Messages$code.php" ) ) {
				require( "$IP/languages/messages/wikia/Messages$code.php" );
				$a = array();
				foreach( $messages as $key => $val ) {
					$a[$key] = array( 'key' => $key, 'value' => $val, 'lang' => $l );
				}
				$messages = $a;
			}
			$messages = array_merge( $messages, $m );

			$txt = "<?php\n\n\$messages = array_merge( \$messages, array(\n";
			foreach( $messages as $id => $row ) 
			{
				$txt .= "'".$row['key']."' => '" . preg_replace( '/(?<!\\\\)\'/', "\'", $row['value']) . "',\n";
			}
			$txt .= ") );\n";
			#--- save file:
			$fh = fopen( sprintf( '%s/'.$filename, $dir, $code ), 'w+' );
			fwrite($fh, $txt);
			fclose($fh);
		}
	}
	
	#--- remove article from DB
	if ( ($removedb == 'yes') && (!empty($articleToRemove)) ) {
		removeDefaultMessages($articleToRemove);
	}
	
	return $maxRevId;
}

function removeDefaultMessages($articleToRemove) {
	$user = 'MediaWiki default';
	$reason = 'No longer required';

	global $wgUser;
	$wgUser = User::newFromName( $user );
	$wgUser->addGroup( 'bot' );
	
	$dbw = wfGetDB( DB_MASTER );

	foreach ($articleToRemove as $id => $row ) {
		$dbw->ping();
		$title = Title::makeTitle( $row['ns'], $row['name'] );
		$article = new Article( $title );
		echo $article->getTitle() . " => " . $reason. "\n";
		$dbw->begin();
		$article->doDeleteArticle( $reason );
		$dbw->commit();
	}
}

