<?php
/**
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf/current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf/current/AdminSettings.php
 * @usage: SERVER_ID=177 php videoSanitize.php --conf /usr/wikia/conf-current/wiki.factory/LocalSettings.php --aconf /usr/wikia/conf-current/AdminSettings.php
 *  */
 
 
function title_replacer( $title, $replacement, $fulltext  ) {
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
			$regexp .= $refs[$char];
		} else {
			if(ctype_alnum($char)) {
				$regexp .= $char;
			} else {
				$regexp .= '\\' . $char;
			}
		}
	}

	$regexp = '/(\\[\\[Video\\:)' . $regexp . '(( *)?#.*?)?'.'(\\]\\]|\\|[^]]+\\]\\])/';
	
	$new = preg_replace( $regexp, '$1' . $replacement . '$4', $fulltext );
	if($new === null) return $fulltext;
	return $new;	
}

function title_replacer_rv( $title, $replacement, $fulltext  ) {
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
			$regexp .= $refs[$char];
		} else {
			if(ctype_alnum($char)) {
				$regexp .= $char;
			} else {
				$regexp .= '\\' . $char;
			}
		}
	}

	$regexp = '/(\\*\\ (VM\\:|))' . $regexp . '(\\|)/';
	$new = preg_replace( $regexp, '$1' . $replacement . '$3', $fulltext );
	if($new === null) return $fulltext;
	return $new;
}


ini_set( "include_path", dirname(__FILE__)."/.." );
//require_once( 'commandLine.inc' );

ini_set( 'display_errors', 'stdout' );
$options = array('help');
@require_once( '../../commandLine.inc' );
require_once ('videoSanitizerMigrationHelper.class.php');
require_once( 'videolog.class.php' );

global $IP, $wgCityId, $wgDBname, $wgExternalDatawareDB;
$devboxuser = exec('hostname');


$sanitizeHelper = new videoSanitizerMigrationHelper($wgCityId, $wgExternalDatawareDB);
$previouslyProcessed = $sanitizeHelper->getRenamedVideos("old", " operation_status='OK'");

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

$i = 0;
$timeStart = microtime( true );
$aTranslation = array();
$aAllFiles = array();
$allChangesArticleURLs=array();
$timeStart = microtime( true );

$rows = $dbw->query( "SELECT img_name FROM image" );

$rowCount = $rows->numRows();
echo( ": {$rowCount} videos found\n" );

if ( $rowCount ) {
	// before processing videos prepare 'status cache'
	// which contains information about previously processed
	// videos on this wiki
	//echo "Fetching data about previously processed videos\n";

	while( $file = $dbw->fetchObject( $rows ) ) {
		$aAllFiles[ $file->img_name ] = 1;
	}

	echo "[".intval( microtime( true ) - $timeStart)." s] table created \n";

	$i = 0;
	foreach( $aAllFiles as $sFile => $val ) {
		if ( strpos ( $sFile, ':' ) === 0 ) {
			// var_dump(':');

			if ( !empty( $previouslyProcessed[$sFile] ) ) {
				continue;
			}
			
			$response = F::app()->sendRequest(
				'VideoHandlerController',
				'getSanitizedOldVideoTitleString',
				array(
					'videoText' => $sFile
				)
			)->getData();

			if( isset( $response['error'] ) ) continue;

			$newNameCandidate = $response['result'];
			$sNewTitle = $newNameCandidate;

			$sufix = 2;
			$firstCheck = true;
			while (
					strlen( $sNewTitle ) < 2 ||
					($firstCheck === false && isset ( $aAllFiles[ $sNewTitle ] ) ) ||
					($firstCheck === true  && $sFile != $sNewTitle && isset( $aAllFiles[ $sNewTitle ]) ) ||
					isset (	$aAllFiles[ substr($sNewTitle, 1 ) ] )
			) {
				$firstCheck = false;
				$newNameCandidate = substr( $newNameCandidate, 0, 255-strlen( '_' . $sufix) );
				$sNewTitle = $newNameCandidate . ( strlen( $newNameCandidate ) > 0  ? '_' : '' ) . $sufix;
				$sufix++;
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
foreach ( $aTranslation as $key => $val ) {
	echo "aTranslation[$key]=$val\n";
	
	$strippedNew = str_replace( ':', '', $val );
	$strippedOld = str_replace( ':', '', $key );

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
				echo "\n ========== ART:" .$oTitle." =============\n";

				$sTextAfter = title_replacer( substr( $key, 1 ), substr( $val, 1), $sTextAfter  );

				if ( $sTextAfter != $sText ) {
					$allChangesArticleURLs[ str_replace('localhost',$wgDBname.'.'.$devboxuser.'.wikia-dev.com',$oTitle->getFullURL()) ] = true;
					echo "ARTICLE WAS CHANGED! \n";
					$status = $oArticle->doEdit( $sTextAfter, 'Fixing broken video names', EDIT_MINOR | EDIT_UPDATE | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT, false, $botUser );
				} else {
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

echo(": {$rowCount} videos processed.\n");
videoLog( 'sanitize', 'RENAMED', "renamed:$i");


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
				$status = $oArticle->doEdit( $sTextAfter, 'Fixing broken video names', EDIT_MINOR | EDIT_UPDATE | EDIT_SUPPRESS_RC | EDIT_FORCE_BOT, false, $botUser );
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

/*
 * wywala nam sie upload
 * check if new name will be available
 * change in page
 * upload
 * success -> change in all backlinking articles
 */

?>