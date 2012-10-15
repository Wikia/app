<?php
/**
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf-current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */


function get_regexp( $title, $replacement, &$wsc ) {
	$wsc = 0;
	$symbols = array(
		array(' ','_','-','+','/'),
	);
	$refs = array();
	foreach( $symbols as $id => $val ) {
		foreach( $val as $id2 => $symbol ) {
			$imp = implode('\\',$val);
			$refs[$symbol] = '[\\' . $imp .']';
		}
	}

	$regexp = '';

	$j = mb_strlen($title);
	for ($k = 0; $k < $j; $k++) {
		$char = mb_substr($title, $k, 1);
		if(isset($refs[$char])) {
			$wsc++;
			$regexp .= '('.$refs[$char] . "|%20){1,}";
		} else {
			if(ctype_alnum($char)) {
				if ( $k == 0 ) {
					$regexp .= '['.strtolower($char).strtoupper($char).']';
				} else {
					$regexp .= $char;
				}
			} else {
				$int = ord($char);
				echo "-------------- Escaping $char ($int)\n";
				if( $char == '?') {
					$regexp .= '(\\' . $char . '|%3f|%3F)';
					$wsc++;
				} else {
					$regexp .= '\\' . $char;
				}
			}
		}
	}
	echo "Part of regexp: $regexp\n";
	return $regexp;
}

function title_replacer( $title, $replacement, $fulltext  ) {

	$wsc = 0;
	$regexp_org = get_regexp( $title, $replacement, $wsc );
	$regexp = '/(\\[\\[Video\\:)[ ]{0,}' . $regexp_org . '[ ]{0,}(( *)?#.*?)?'.'(\\]\\]|\\|[^]]+\\]\\])/';
	echo "Full regexp: $regexp\n";
	$new = preg_replace( $regexp, '$1' . $replacement . '$'.(4+$wsc), $fulltext );

	if( $new === null || $new == $fulltext ) {
		echo "No occurences found! Returning original\n";
		echo "Original is:\n";
		echo $fulltext;
		echo "\n";
		$res = preg_match($regexp_org, $fulltext);
		$res = var_export($res,1);
		echo "Pregmatch result:$res\n";
		return $fulltext;
	}
	return $new;
}

ini_set( "include_path", dirname(__FILE__)."/.." );
//require_once( 'commandLine.inc' );

ini_set( 'display_errors', 'stdout' );
$options = array('help');
@require_once( '../../commandLine.inc' );
require_once ('videoSanitizerMigrationHelper.class.php');
require_once( 'videolog.class.php' );

global $IP, $wgCityId, $wgDBname, $wgExternalDatawareDB, $wgVideoHandlersVideosMigrated, $wgDBname;

$wgVideoHandlersVideosMigrated = false; // be sure we are working on old files

$devboxuser = exec('hostname');
$sanitizeHelper = new videoSanitizerMigrationHelper($wgCityId, $wgDBname, $wgExternalDatawareDB);

// $IP = '/home/pbablok/video/VideoRefactor/'; // HACK TO RUN ON SANDBOX
// echo( "$IP\n" );
echo( "Video name sanitizer script running for $wgCityId\n" );
videoLog( 'sanitize', 'START', '');


if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php VideoSanitizer.php\n" );
	exit( 0 );
}

require_once( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );

$dbw = wfGetDB( DB_MASTER );
$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

$botUser = User::newFromName( 'WikiaBot' );

$res = $dbw_dataware->select(
	'video_sanitization_failededit',
	'*',
	array( 'city_id' => $wgCityId )
);

$articlesToProcess = array();
$allChangesArticleURLs = array();

while ( $failed = $dbw_dataware->fetchObject( $res ) ) {
	$articlesToProcess[] = $failed;
}

$i = 0;
$j = 0;
foreach( $articlesToProcess as $failed ) {
	$key = $failed->rename_from;
	$val = $failed->rename_to;
	$q = "SELECT distinct il_from FROM imagelinks WHERE il_to ='".mysql_real_escape_string($key)."'";
	echo "query:$q\n";
	$rows = $dbw->query( $q );
	while( $file = $dbw->fetchObject( $rows ) ) {
		echo "FETCH FROM DB il_from= ".$file->il_from." // ($key)\n";
		$articleId = $file->il_from;
		$oTitle = Title::newFromId( $articleId );

		if ( $oTitle instanceof Title && $oTitle->exists() ){
			global $wgTitle;
			// in some cases hooks depend on wgTitle (hook for article edit)
			// but normally it wouldn't be set for maintenance script
			$wgTitle = $oTitle;
			$oArticle = new Article ( $oTitle );
			if ( $oArticle instanceof Article ){
				$sTextAfter = $sText = $oArticle->getContent();
				echo "\n ======= ART:" .$oTitle." =======\n";

				$sTextAfter = title_replacer( substr( $key, 1 ), substr( $val, 1), $sTextAfter  );

				if ( $sTextAfter != $sText ) {
					$allChangesArticleURLs[ str_replace('localhost',$wgDBname.'.'.str_replace('dev-','', $devboxuser).'.wikia-dev.com',$oTitle->getFullURL()) ] = true;
					echo "ARTICLE WAS CHANGED! \n";
					$sanitizeHelper->logVideoTitle($key, $val, 'OK', $oTitle);
					// isolating doEdit, because it's possible it will result in Fatal Error for some articles
					// in case of misconfiguration (doEdit running from maintenance scripts instead of directly
					// in context of browser web request is not used much so it's not very reliable)
					$pid = pcntl_fork();
					if ($pid == -1) {
						die('Could not fork');
					} else if ($pid) {
						// we are the parent
						//echo "parent\n";
						$status = null;
						pcntl_wait($status); //Protect against Zombie children
						$st = pcntl_wexitstatus($status);
						if ($st != 0) {
							// need to log those fatal errors here
							$sanitizeHelper->logVideoTitle($key, $val, 'FAIL', $oTitle);
							$i++;
						} else {
							$sanitizeHelper->logFailedEditRemove($articleId, $oTitle->getText(), $oTitle->getNamespace(), $key, $val );
							$j++;
						}
						//echo "parent end of fork\n";
					} else {
						// we are the child, process doEdit in child
						//echo "child\n";
						$status = $oArticle->doEdit( $sTextAfter, 'Fixing broken video names', EDIT_MINOR | EDIT_UPDATE | EDIT_FORCE_BOT, false, $botUser );
						//echo "child end of fork\n";
						exit();
					}
					//echo "outside of fork\n";

				} else {
					$sanitizeHelper->logVideoTitle($key, $val, 'UNKNOWN', $oTitle);
					$j++;
				}
			} else {
				var_dump( $oArticle );
			}

		} else {
			var_dump( $oTitle );
		}
	}
}

echo "Reedit of articles - success:$i,failed:$j\n";
videoLog( 'sanitize', 'REEDIT', "success:$i,failed:$j");

videoLog( 'sanitize', 'STOP', "");

echo "Articles to check:\n";
foreach( $allChangesArticleURLs as $url => $v ) {
	echo "  $url\n";
}



?>