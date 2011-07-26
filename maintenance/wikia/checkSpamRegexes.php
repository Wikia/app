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
		$db = wfGetDB(DB_SLAVE, 'cron', $wiki['name']);
		if ( $db ) {
			echo "check Wikia: {$wiki['name']} \n";
			$row = $db->selectRow('page', array('page_id'), array('page_title' => $title, 'page_namespace' => NS_MEDIAWIKI) );
			if ( $row && $row->page_id ) {
				echo "Found page: $title ({$row->page_id}) \n";
				$oGTitle = GlobalTitle::newFromId( $row->page_id, $wiki['id'] );
				if ( $oGTitle ) {
					$text = $GTitle->getText();
					$regexes = SpamRegexBatch::buildSafeRegexes( $text );
					echo "Found " . count($regexes) . " regexes \n";
					$loop = 0;
					foreach ($regex as $id => $regex) {
						$m = array();
						if (preg_match($regex, strtolower($title->getText()), $m)) {
							echo "wikia: " . $wiki['name'] . " - ok ( $loop )\n";
						}
						$loop++;
					}				
				}
			}
		}
	}
}

$time = microtime(true) - $time_start;
echo "\n-- Execution time: $time seconds\n";
