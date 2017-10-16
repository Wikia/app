<?php

/**
 * Class FindBadSuggestionData
 *
 * Find bad data in suggestions
 */
class FindBadSuggestionData {
	public static function run( DatabaseBase $db, $test = false, $verbose = false, $params = null ) {
		$dbname = $params['dbname'];

		// Don't process the video wiki
		if ( $dbname == 'video151' ) {
			return true;
		}

		// Get all suggestion data in this wiki
		$sql = <<<SQL
select page_id, props
  from page_wikia_props
 where propname = 19
SQL;

		if ( $verbose ) {
			echo "Running on $dbname\n";
		}

		if ( empty($test) ) {
			$res = $db->query($sql);

			// Loop through all the data
			while ($row = $db->fetchRow($res)) {
				// The prop field should be a serialized array
				$data = unserialize($row['props']);

				if ( empty($data) ) continue;
				if ( count($data) == 0 ) continue;

				foreach ( $data as $item ) {
					// If this is not an array, the data is bad
					if ( empty( $item['title'] ) ) {
						file_put_contents( '/tmp/badData.log', $dbname."\n", FILE_APPEND );
						echo "\t$dbname - BAD DATA\n";

						// Exit immediately, we don't need to run the rest
						return true;
					}
				}
			}
		}
	}
}
