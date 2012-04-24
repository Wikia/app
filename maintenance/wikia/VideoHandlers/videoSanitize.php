<?php
/**
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf-current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */

echo "-s-";

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
				if ( $k == 0 && ctype_alpha($char) ) {
					$regexp .= '['.strtolower($char).strtoupper($char).']';
				} else {
					$regexp .= $char;
				}
			} else {
				//$int = ord($char);
				//echo "-------------- Escaping $char ($int)\n";
				if( $char == '?') {
					$regexp .= '(\\' . $char . '|%3f|%3F)';
					$wsc++;
				} else {
					$regexp .= '\\' . $char;
				}
			}
		}
	}
	#echo "Part of regexp: $regexp\n";
	return $regexp;
}

function title_replacer( $title, $replacement, $fulltext  ) {

	$wsc = 0;
	$regexp = get_regexp( $title, $replacement, $wsc );
	$regexp = '/(\\[\\[Video\\:)[ ]{0,}' . $regexp . '[ ]{0,}(( *)?#.*?)?'.'(\\]\\]|\\|[^]]+\\]\\])/';
	$new = preg_replace( $regexp, '${1}' . $replacement . '${'.(4+$wsc).'}', $fulltext );
	if( $new === null ) return $fulltext;
	return $new;	
}

function title_replacer_rv( $title, $replacement, $fulltext  ) {

	$wsc = 0;
	$regexp = get_regexp( $title, $replacement, $wsc );
	$regexp = '/(\\*\\ (VM\\:|))' . $regexp . '(\\|)/';
	$new = preg_replace( $regexp, '$1' . $replacement . '$'.(3+$wsc), $fulltext );
	if( $new === null ) return $fulltext;
	return $new;
}

function title_replacer_vg( $title, $replacement, $fulltext  ) {

	$wsc = 0;
	$regexp = get_regexp( $title, $replacement, $wsc );
	$regexp = "/^\\h*[vV][iI][dD][eE][oO]\\:" . $regexp . '(\\||\\h*$)/m';
	$new = preg_replace( $regexp, "Video:" . $replacement . "$".(1+$wsc), $fulltext );
	if( $new === null ) return $fulltext;
	return $new;
}

ini_set( "include_path", dirname(__FILE__)."/.." );
//require_once( 'commandLine.inc' );

ini_set( 'display_errors', 'stdout' );
$options = array('help');
@require_once( '../../commandLine.inc' );
require_once ('videoSanitizerMigrationHelper.class.php');
require_once( 'videolog.class.php' );

global $IP, $wgCityId, $wgDBname, $wgExternalDatawareDB, $wgVideoHandlersVideosMigrated, $wgDBname, $wgStatsDB;

$wgVideoHandlersVideosMigrated = false; // be sure we are working on old files

$devboxuser = exec('hostname');
$sanitizeHelper = new videoSanitizerMigrationHelper($wgCityId, $wgDBname, $wgExternalDatawareDB);
$previouslyProcessed = $sanitizeHelper->getRenamedVideos("old", " operation_status='OK'");

echo( "Video name sanitizer script running for $wgCityId\n" );
videoLog( 'sanitize', 'START', '');


if( isset( $options['help'] ) && $options['help'] ) {
	echo( "Usage: php VideoSanitizer.php\n" );
	exit( 0 );
}

$IP = '/home/release/video_refactoring/trunk'; // HACK TO RUN ON SANDBOX
#$IP = '/usr/wikia/mac'; // DEVbOX
require_once( "$IP/extensions/wikia/VideoHandlers/VideoHandlers.setup.php" );

$dbw = wfGetDB( DB_MASTER );
$dbw_dataware = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
$dbw_stats = wfGetDB( DB_SLAVE, array(), $wgStatsDB );

//$dbw->setFlag( DBO_PERSISTENT );
//$dbw_dataware->setFlag( DBO_PERSISTENT );

$i = 0;
$timeStart = microtime( true );
$aTranslation = array();
$aAllFiles = array();
$allChangesArticleURLs=array();
$timeStart = microtime( true );

$rows = $dbw->query( "SELECT img_name, img_timestamp FROM image" );

$rowCount = $rows->numRows();
echo( ": {$rowCount} videos found\n" );

if ( $rowCount ) {
	// before processing videos prepare 'status cache'
	// which contains information about previously processed
	// videos on this wiki
	//echo "Fetching data about previously processed videos\n";

	while( $file = $dbw->fetchObject( $rows ) ) {
		$aAllFiles[ $file->img_name ] = $file->img_timestamp;
	}

	echo "[".intval( microtime( true ) - $timeStart)." s] table created \n";

	$i = 0;
	foreach( $aAllFiles as $sFile => $val ) {
		if ( strpos ( $sFile, ':' ) === 0 || strpos( $sFile, 'Video:' ) === 0 ) {
			// var_dump(':');

			if ( !empty( $previouslyProcessed[$sFile] ) ) {
				continue;
			}

			if( strpos( $sFile, 'Video:' ) === 0 ) {
				$processName = substr($sFile, 5);
			} else {
				$processName = $sFile;
			}

			$response = F::app()->sendRequest(
				'VideoHandlerController',
				'getSanitizedOldVideoTitleString',
				array(
					'videoText' => $processName
				)
			)->getData();

			if( isset( $response['error'] ) ) continue;

			$newNameCandidate = $response['result'];
			//echo "Sanitizers candidate: $newNameCandidate\n";
			$sNewTitle = $newNameCandidate;

			$sufix = 2;
			$firstCheck = true;
			while (
					strlen( $sNewTitle ) < 2 ||
					($firstCheck === false && isset ( $aAllFiles[ $sNewTitle ] ) ) ||
					($firstCheck === true  && $sFile != $sNewTitle && isset( $aAllFiles[ $sNewTitle ]) ) ||
					isset (	$aAllFiles[ substr($sNewTitle, 1 ) ] )
			) {
				if( isset( $aAllFiles[ substr($sNewTitle, 1 ) ] ) &&
					isset( $aAllFiles[ $sNewTitle ] ) &&
					wfTimestamp( TS_MW, $aAllFiles[ substr($sNewTitle, 1 ) ] ) > wfTimestamp( TS_MW, "20120323211614" ) ) {
					echo "Ignoring this title - duplicated entry is legal and sanitized\n";
					break;
				}
				$firstCheck = false;
				$newNameCandidate = substr( $newNameCandidate, 0, 255-strlen( '_' . $sufix) );
				$sNewTitle = $newNameCandidate . ( strlen( $newNameCandidate ) > 1  ? '_' : 'Video_' ) . $sufix;
				if ( strpos($sNewTitle,':') === 0 ) {
					$sNewTitle = substr( $sNewTitle, 1 );
					$sNewTitle = trim( str_replace( '_', ' ', $sNewTitle ) );
					$sNewTitle = ':' . str_replace( ' ', '_', $sNewTitle );
				} else {
					$sNewTitle = trim( str_replace( '_', ' ', $sNewTitle ) );
					$sNewTitle = str_replace( ' ', '_', $sNewTitle );
				}
				$sufix++;
				//echo "Current candidate: $sNewTitle\n";
			}

			if( strpos( $sFile, 'Video:' ) === 0 ) {
				$sNewTitle = str_replace(' ', '_', $sNewTitle);
			}


			if( $sFile != $sNewTitle ) {
				echo "Doing translation $sFile to $sNewTitle \n";
				$aTranslation[ $sFile ] = $sNewTitle;
				$aAllFiles[ substr($sNewTitle, 1 ) ] = 1;
			} else {
				echo "NOT doing translation for $sFile\n";
			}
		}
	}
}

$dbw->freeResult( $rows );
echo "[".intval( microtime( true ) - $timeStart)." s] get translation table!\n";

print_r( $aTranslation );

$botUser = User::newFromName( 'WikiaBot' );

$i=0;

$count = count( $aTranslation );
$current = 0;
foreach ( $aTranslation as $key => $val ) {
	echo "aTranslation[$key]=$val\n";

	$strippedNew = ( substr( $val, 0, 1 ) == ':' ) ? substr( $val, 1 ) : $val;
	$strippedOld = ( substr( $key, 0, 1 ) == ':' ) ? substr( $key, 1 ) : $key;

	$aTablesMove = array();
	$aTablesMove['archive']	= array (
		'where' => array( 'ar_namespace' => NS_LEGACY_VIDEO, 'ar_title' => $strippedOld ),
		'update' => array( 'ar_title' => $strippedNew )
	);

	$aTablesMove['cu_changes'] = array (
		'where' => array( 'cuc_namespace' => NS_LEGACY_VIDEO, 'cuc_title' => $strippedOld ),
		'update' => array( 'cuc_title' => $strippedNew )
	);

	$aTablesMove['filearchive'] = array (
		'where' => array( 'fa_name' => $key ),
		'update' => array( 'fa_name' => $val )
	);

	$aTablesMove['image'] = array (
		'where' => array( 'img_name' => $key ),
		'update' => array( 'img_name' => $val )
	);

	$aTablesMove['hidden'] = array (
		'where' => array( 'hidden_namespace' => NS_LEGACY_VIDEO, 'hidden_title' => $strippedOld ),
		'update' => array( 'hidden_title' => $strippedNew )
	);

	$aTablesMove['logging']	= array (
		'where' => array( 'log_namespace' => NS_LEGACY_VIDEO, 'log_title' => $strippedOld ),
		'update' => array( 'log_title' => $strippedNew )
	);

	$aTablesMove['oldimage'] = array (
		'where' => array( 'oi_name' => $key ),
		'update' => array( 'oi_name' => $val )
	);

	$aTablesMove['oldimage'] = array (
		'where' => array( 'oi_archive_name' => $key ),
		'update' => array( 'oi_archive_name' => $val )
	);

	$aTablesMove['page'] = array (
		'where' => array( 'page_namespace' => NS_LEGACY_VIDEO, 'page_title' => $strippedOld ),
		'update' => array( 'page_title' => $strippedNew )
	);

	$aTablesMove['pagelinks'] = array (
		'where' => array( 'pl_namespace' => NS_LEGACY_VIDEO, 'pl_title' => $strippedOld ),
		'update' => array( 'pl_title' => $strippedNew )
	);

	$aTablesMove['protected_titles'] = array (
		'where' => array( 'pt_namespace' => NS_LEGACY_VIDEO, 'pt_title' => $strippedOld ),
		'update' => array( 'pt_title' => $strippedNew )
	);

	$aTablesMove['recentchanges'] = array (
		'where' => array( 'rc_namespace' => NS_LEGACY_VIDEO, 'rc_title' => $strippedOld ),
		'update' => array( 'rc_title' => $strippedNew )
	);

	$aTablesMove['redirect'] = array (
		'where' => array( 'rd_namespace' => NS_LEGACY_VIDEO, 'rd_title' => $strippedOld ),
		'update' => array( 'rd_title' => $strippedNew )
	);

	$aTablesMove['watchlist'] = array (
		'where' => array( 'wl_namespace' => NS_LEGACY_VIDEO, 'wl_title' => $strippedOld ),
		'update' => array( 'wl_title' => $strippedNew )
	);

	foreach(  $aTablesMove as $table => $actions ){
		if( $dbw->tableExists($table)) {
			$res = $dbw->update(
				$table,
				$actions['update'],
				$actions['where'],
				__METHOD__
			);
			$num = $dbw->affectedRows();
			if( $num ) {
				echo "updated $table (changes:$num)\n";
			}
			// ad error handling
		} else {
			echo "table $table does not exist on this wiki\n";
		}
	}

	// Fixing links in article;
	//echo "SELECT distinct il_from FROM imagelinks WHERE il_to ='{$key}'! /n";

	$rows = $dbw->query( "SELECT distinct il_from FROM imagelinks WHERE il_to ='".mysql_real_escape_string($key)."'");
	$current++;
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
				echo "\n ={$count}/{$current}==== ART:" .$oTitle." =======\n";

				$sTextAfter = title_replacer( substr( $key, 1 ), substr( $val, 1), $sTextAfter  );

				if ( $sTextAfter != $sText ) {
					echo "ARTICLE WAS CHANGED! \n";
					$allChangesArticleURLs[ str_replace('localhost',$wgDBname.'.'.str_replace('dev-','', $devboxuser).'.wikia-dev.com',$oTitle->getFullURL()) ] = true;
					$sanitizeHelper->logVideoTitle($key, $val, 'OK', $oTitle);
					// isolating doEdit, because it's possible it will result in Fatal Error for some articles
					// in case of misconfiguration (doEdit running from maintenance scripts instead of directly
					// in context of browser web request is not used much so it's not very reliable)
					$pid = pcntl_fork();
					if ($pid == -1) {
						echo "I think I'm gonna die\n";
						die('Could not fork');
					} else if ($pid) {
						// we are the parent
						echo "Parent waiting for edit to finish\n";
						$status = null;
						pcntl_wait($status); //Protect against Zombie children
						$st = pcntl_wexitstatus($status);
						if ($st != 0) {
							// need to log those fatal errors here
							$sanitizeHelper->logFailedEdit($articleId, $oTitle->getText(), $oTitle->getNamespace(), $key, $val);
							$sanitizeHelper->logVideoTitle($key, $val, 'FAIL', $oTitle);
						}
						//echo "parent end of fork\n";
					} else {
						// we are the child, process doEdit in child
						//echo "child\n";
						echo "Preparing for edit\n";
						sleep(0.25);
						$status = $oArticle->doEdit( $sTextAfter, 'Fixing broken video names', EDIT_MINOR | EDIT_UPDATE | EDIT_FORCE_BOT, false, $botUser );
						//echo "child end of fork\n";
						exit();
					}
					//echo "outside of fork\n";

				} else {
					echo "ARTICLE NOT CHANGED! (status UNKNOWN) \n";
					$sanitizeHelper->logFailedEdit($articleId, $oTitle->getText(), $oTitle->getNamespace(), $key, $val);
					$sanitizeHelper->logVideoTitle($key, $val, 'UNKNOWN', $oTitle);
				}
			} else {
				var_dump( $oArticle );
			}




		} else {
			var_dump( $oTitle );
		}
	}


	// when you sanitize make sure that the original entry in video_premigrate is deleted
	$dbw_dataware->delete(
		'video_premigrate',
		array(
			'wiki_id'	=>$wgCityId,
			'img_name'	=>$key
		)
	);

	$i++;
}

//echo(": {$rowCount} videos processed.\n");
//videoLog( 'sanitize', 'RENAMED', "renamed:$i");

echo "Fixing Videogalleries\n";
$rows = $dbw_stats->query( "SELECT ct_page_id FROM city_used_tags WHERE ct_wikia_id = $wgCityId AND ct_kind = 'videogallery'" );

$i=0;
while( $page = $dbw_stats->fetchObject( $rows ) ) {
	global $wgTitle;
	$oTitleVG = Title::newFromID( $page->ct_page_id );
	$wgTitle = $oTitleVG;
	if ( $oTitleVG instanceof Title && $oTitleVG->exists() ){
		$oArticle = new Article ( $oTitleVG );
		if ( $oArticle instanceof Article ){
			$sTextAfter = $sText = $oArticle->getContent();
			echo "\n ========== ART(VG):" .$oTitleVG." =============\n";

			foreach ( $aTranslation as $key => $val ) {
				$sTextAfter = title_replacer_vg( substr( $key, 1 ), substr( $val, 1), $sTextAfter );
			}

			if ( $sTextAfter != $sText ) {
				echo "ARTICLE WAS CHANGED! \n";
				$status = $oArticle->doEdit( $sTextAfter, 'Fixing broken videogallery tag', EDIT_MINOR | EDIT_UPDATE | EDIT_FORCE_BOT, false, $botUser );
				$i++;
			}
		} else {
			var_dump( $oArticle );
		}
	}
}

videoLog( 'sanitize', 'VIDEOGALLERY', "edits:$i");

echo "Fixing Related Videos\n";
$rows = $dbw->query( "SELECT page_id FROM page WHERE page_namespace = 1100" );

$i=0;
while( $page = $dbw->fetchObject( $rows ) ) {
	global $wgTitle;
	$oTitleRV = Title::newFromID( $page->page_id );
	$wgTitle = $oTitleRV;
	if ( $oTitleRV instanceof Title && $oTitleRV->exists() ){
		$oArticle = new Article ( $oTitleRV );
		if ( $oArticle instanceof Article ){
			$sTextAfter = $sText = $oArticle->getContent();
			echo "\n ========== ART(RV):" .$oTitleRV." =============\n";

			foreach ( $aTranslation as $key => $val ) {
				$sTextAfter = title_replacer_rv( substr( $key, 1 ), substr( $val, 1), $sTextAfter  );
			}

			if ( $sTextAfter != $sText ) {
				echo "ARTICLE WAS CHANGED! \n";
				$status = $oArticle->doEdit( $sTextAfter, 'Fixing broken video names', EDIT_MINOR | EDIT_UPDATE | EDIT_FORCE_BOT, false, $botUser );
				$i++;
			}
		} else {
			var_dump( $oArticle );
		}
	}
}
videoLog( 'sanitize', 'RELATEDVIDEOS', "edits:$i");

videoLog( 'sanitize', 'STOP', "");

echo "Articles to check:\n";
foreach( $allChangesArticleURLs as $url => $v ) {
	echo "  $url\n";
}

wfWaitForSlaves( 2 );

/*
 * wywala nam sie upload
 * check if new name will be available
 * change in page
 * upload
 * success -> change in all backlinking articles
 */

?>