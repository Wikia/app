<?php

require_once(dirname(__FILE__) . '/../commandLine.inc');

$time_start = microtime(true);

if ( isset( $options['title'] ) )  $title = $options['title'];
if ( isset( $options['wikia'] ) ) $wikia = $options['wikia'];

if ( !isset($title) ) {
	echo "Invalid parameters \n";
	echo "Use: --title REGEXLIST [--wikia DBNAME] \n";
	exit(0);
}

$dbr = wfGetDB(DB_SLAVE, 'cron', $wgExternalSharedDB);

if ( !empty( $wikia ) ) {
	echo "Checking $wikia  ...\n";
	$oTitle = Title::makeTitle( NS_MEDIAWIKI, $title );
	if ( is_object( $oTitle ) ) {
		$oArticle = new Article( $oTitle );
		$content = $oArticle->getContent();
		if ( is_object( $oArticle ) && !empty( $content ) ) {
			echo "content = " . $oArticle->getContent() . " \n";
			$regexes = SpamRegexBatch::buildSafeRegexes( $content );
			echo "Found " . count($regexes) . " regexes \n";
			$loop = 0;
			foreach ($regexes as $id => $regex) {
				$m = array();
				if (preg_match($regex, strtolower($title->getText()), $m)) {
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
	echo "read all Wikis \n";
	$where = ( $wikia ) ? array('city_dbname' => $wikia ) : array('city_public' => 1);
	$data = $dbr->select(
		array('city_list'),
		array('city_id', 'city_dbname'),
		$where,
		__METHOD__
	);
	$pages = array();
	while ($row = $dbr->fetchObject($data)) {
		$wikis[] = array( 'id' => $row->city_id, 'name' => $row->city_dbname );
	}
	$dbr->FreeResult($data);

	if ( !empty($wikis) ) {
		foreach ( $wikis as $wiki ) {
			$sCommand  = "SERVER_ID={$wiki['id']} php $IP/maintenance/wikia/checkSpamRegexes.php ";
			$sCommand .= "--title=" . $title . " ";
			$sCommand .= "--wikia=" . $wiki['name'] . " ";
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
