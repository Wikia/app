<?php

require_once(dirname(__FILE__) . '/../commandLine.inc');

$time_start = microtime(true);

if ( isset( $options['title'] ) )  $title = $options['title'];
if ( isset( $options['wikia'] ) ) $wikia = $options['wikia'];

if ( !isset($title) ) {
	echo "Invalid parameters \n";
	echo "Use: --title REGEXLIST [--wikia WIKIID] \n";
	exit(0);
}

function stripLines( $lines ) {
	return array_filter( 
		array_map( 'trim',
			preg_replace( '/#.*$/', '',
				$lines ) ) );
}

function buildRegexes( $lines, $batchSize=4096) {
	global $useSpamRegexNoHttp;
	# Make regex
	# It's faster using the S modifier even though it will usually only be run once
	//$regex = 'https?://+[a-z0-9_\-.]*(' . implode( '|', $lines ) . ')';
	//return '/' . str_replace( '/', '\/', preg_replace('|\\\*/|', '/', $regex) ) . '/Si';
	$regexes = array();
	$regexStart = (!empty($useSpamRegexNoHttp)) ? '/(' : '/https?:\/\/+[a-z0-9_\-.]*(';
	$regexEnd = ($batchSize > 0 ) ? ')/Si' : ')/i';
	$build = false;
	foreach( $lines as $line ) {
		// FIXME: not very robust size check, but should work. :)
		if( $build === false ) {
			$build = $line;
		} elseif( strlen( $build ) + strlen( $line ) > $batchSize ) {
			$regexes[] = $regexStart .
				str_replace( '/', '\/', preg_replace('|\\\*/|', '/', $build) ) .
				$regexEnd;
			$build = $line;
		} else {
			$build .= '|';
			$build .= $line;
		}
	}
	if( $build !== false ) {
		$regexes[] = $regexStart .
			str_replace( '/', '\/', preg_replace('|\\\*/|', '/', $build) ) .
			$regexEnd;
	}
	return $regexes;
}

if ( !empty( $wikia ) ) {
	echo "Checking $wikia  ...\n";
	$oTitle = Title::makeTitle( NS_MEDIAWIKI, $title );
	if ( is_object( $oTitle ) ) {
		$oArticle = new Article( $oTitle );
		$content = $oArticle->getContent();
		if ( is_object( $oArticle ) && !empty( $content ) ) {
			echo "content = " . $oArticle->getContent() . " \n";
			$lines = explode( "\n", $content );
			$lines = stripLines( $lines );
			$regexes = buildRegexes( $lines );
			echo "Found " . count($regexes) . " regexes \n";
			$loop = 0;
			foreach ($regexes as $id => $regex) {
				$m = array();
				if (preg_match($regex, strtolower($oTitle->getText()), $m)) {
					echo "wikia: " . $wgDBName . " - ok ( $loop )\n";
				}
				$loop++;
			}
		} else {
			echo "No text found \n";
		}
	} else {
		echo "Page not found \n";
	}
} else {
	$dbr = wfGetDB(DB_SLAVE, 'cron', $wgExternalDatawareDB);
	echo "read all Wikis \n";
	$where = ( $wikia ) ? array('page_wikia_id' => $wikia ) : array();
	$where['page_title_lower'] = mb_strtolower( $title );
	$data = $dbr->select(
		array('pages'),
		array('page_wikia_id'),
		$where,
		__METHOD__
	);
	$pages = array();
	while ($row = $dbr->fetchObject($data)) {
		$wikis[] = $row->page_wikia_id ;
	}
	$dbr->FreeResult($data);

	if ( !empty($wikis) ) {
		foreach ( $wikis as $wiki ) {
			$sCommand  = "SERVER_ID={$wiki} php $IP/maintenance/wikia/checkSpamRegexes.php ";
			$sCommand .= "--title=" . $title . " ";
			$sCommand .= "--wikia=" . $wiki . " ";
			$sCommand .= "--conf $wgWikiaLocalSettingsPath";

			$log = wfShellExec( $sCommand, $retval );
			if ($retval) {
				echo "Error code returned: $retval, Error was: $log \n";
			}
			else {
				echo "Done: $log \n";
			}				
		}
	}
}
		
$time = microtime(true) - $time_start;
echo "\n-- Execution time: $time seconds\n";
exit(0);
