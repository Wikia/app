<?php
#require_once __DIR__ . '/../../Maintenance.php';

require_once  '/usr/wikia/slot1/current/src/maintenance/Maintenance.php';

ini_set( 'display_errors', 'stderr' );
ini_set( 'error_reporting', E_NOTICE );

class Top5KWikisToMigrate extends Maintenance {
	public function execute() {
		global $wgFandomBaseDomain;

		$db = wfGetDB( DB_SLAVE, [], 'wikicities' );
		if (($handle = fopen("top_10k_wikis.csv", "r")) == FALSE) {
			die("Cannot open input CSV file\n");
		}
		$row = 0;
		$totalCnt = 0;
		$outFile = fopen('top5kToMigrate.csv', 'w');
		fputcsv($outFile, ["city_id", "city_url", "city_lang", "pageviews"]);
		$processed = [];
		$pageviews = [];

		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
			//echo json_encode($data) . "\n";
			$city_id = intval($data[1]);
			if ($city_id > 0) {
				$pageviews[$city_id] = intval($data[0]);
				$city = $db->select( 'city_list', ['city_url'],
					"city_id = $city_id", __METHOD__);
				$wiki = $city->fetchObject();
				$db->freeResult( $city );
				//echo "Processing wiki {$city_id} ({$wiki->city_url})\n";
				$testWiki = WikiFactory::getVarValueByName( 'wgIsTestWiki', $city_id );

				if ($testWiki) {
					echo "Test wiki: {$wiki->city_url}\n";
				} elseif (FALSE !== strpos($wiki->city_url, $wgFandomBaseDomain)) {
					echo "Migrated wiki: {$wiki->city_url}\n";
					$totalCnt++; // ?
				}  elseif (array_key_exists($city_id, $processed)) {
					echo "Processed wiki: {$wiki->city_url}\n";
					$totalCnt++;
				} else {
					$hostName = parse_url( $wiki->city_url, PHP_URL_HOST );

					while (substr_count($hostName, ".") > 2) {
						$hostName = substr($hostName, strpos($hostName, ".") + 1);
					}

					$where = [
						$db->makeList( [
							'city_url ' . $db->buildLike( $db->anyString(), "//".$hostName, $db->anyString() ),
							'city_url ' . $db->buildLike( $db->anyString(), ".".$hostName, $db->anyString() ),
						], LIST_OR ),
						'city_public' => 1
					];

					$dbResult = $db->select(
						[ 'city_list' ],
						[ 'city_id', 'city_url', 'city_dbname', 'city_lang' ],
						$where,
						__METHOD__,
						[ 'ORDER BY' => 'city_id ASC' ]
					);

					while ( $wrow = $db->fetchObject( $dbResult ) ) {
						if (array_key_exists($wrow->city_id, $pageviews)) {
							$pv = $pageviews[$wrow->city_id];
						} else {
							$pv = -1;
						}
						fputcsv($outFile, [$wrow->city_id, $wrow->city_url, $wrow->city_lang, $pv]);
						$processed[$wrow->city_id] = true;
					}

					$db->freeResult( $dbResult );

					$totalCnt++;
				}
			}
			$row++;
			if (!($totalCnt % 100)) {
				echo "Progress: totalCnt: {$totalCnt}, row: {$row}\n";
			}
			if ($row >= 10000) {
				echo "End of CSV rows, stopping";
				break;
			}
			if ($totalCnt >= 5000) {
				break;
			}
		}
		fclose($outFile);
		fclose($handle);

	}
}

$maintClass = 'Top5KWikisToMigrate';
require_once RUN_MAINTENANCE_IF_MAIN;
