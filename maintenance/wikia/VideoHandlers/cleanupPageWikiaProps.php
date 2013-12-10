<?php

/**
* Cleanup page_wikia_props table making sure there are no inconsistencies. Specifically, this script checks
* that every page which has a status record and has the swappable bit turned on in the props column of that record
* has a corresponding suggestions record. If it does not, the swappable bit is turned off. It also makes sure that
* every record which has a suggestion record, has a corresponding status record with the swappable bit turned on.
* If it does not, it turns on the swappable bit. Finally, it goes through the page_wikia_props table and deletes
* any records which do not have a corresponding record in the page table.
*
* @author james@wikia-inc.com
* @ingroup Maintenance
*/

class CleanupPageWikiaProps {

	public static function run ( $db, $test = false, $verbose = false, $params ) {
		$dbname = $params['dbname'];

		// Get all pages which have a status record with the swappable
		// bit turned on, but do not have a corresponding suggestions record
		$sql = "SELECT page_id
				FROM page_wikia_props
				WHERE propname = " . WPP_LVS_STATUS . "
				AND props & " . LicensedVideoSwapHelper::STATUS_SWAPPABLE . " != 0
				AND page_id not in (
					SELECT page_id
					FROM page_wikia_props
					WHERE propname = " . WPP_LVS_SUGGEST . ")";
		$result = $db->query( $sql );

		$pagesWithoutSuggestions = array();
		while ( $row = $db->fetchObject( $result ) ) {
			$pagesWithoutSuggestions[] = $row->page_id;
		}

		// Turn off the swappable bit in the props column for any page_ids found in the previous query
		foreach ( $pagesWithoutSuggestions as $page_id )   {
			if ( !$test ) {
				$db->query("UPDATE page_wikia_props SET props=props & ~" . LicensedVideoSwapHelper::STATUS_SWAPPABLE .
					" WHERE page_id = " . $page_id . " AND propname = ". WPP_LVS_STATUS);
			}
			if ( $verbose ) {
				echo "Found status record in $dbname without suggestion record. Turning off swappable bit for page_id: $page_id\n";
			}
		}

		// Get all pages which have a suggestion record, but do not have a status record with the swappable bit turned on
		$sql = "SELECT page_id
				FROM page_wikia_props
				WHERE propname = " . WPP_LVS_SUGGEST . "
				AND page_id not in (
					SELECT page_id
					FROM page_wikia_props
					WHERE propname = " . WPP_LVS_STATUS . "
					AND props & " . LicensedVideoSwapHelper::STATUS_SWAPPABLE . " != 0)";
		$result = $db->query( $sql );

		$suggestionsWithoutSwappableBit = array();
		while ( $row = $db->fetchObject( $result ) ) {
			$suggestionsWithoutSwappableBit[] = $row->page_id;
		}

		// Turn on the swappable bit in the props column for any page_ids found in the previous query
		foreach ( $suggestionsWithoutSwappableBit as $page_id )   {
			// First make sure that a status record actually exists for this video
			$result = $db->query( "SELECT page_id from page_wikia_props where page_id = $page_id and propname = " . WPP_LVS_STATUS );
			if ( !$test ) {
				// if not, create it first
				if ( !$db->fetchObject( $result )) {
					$db->query( "INSERT INTO page_wikia_props (page_id, propname, props) values ($page_id, " .
						WPP_LVS_STATUS . ", " . LicensedVideoSwapHelper::STATUS_SWAPPABLE . ")" );
				} else {
					$db->query("UPDATE page_wikia_props SET props=props | " . LicensedVideoSwapHelper::STATUS_SWAPPABLE .
						" WHERE page_id = " . $page_id . " AND propname = ". WPP_LVS_STATUS);
				}
			}
			if ( $verbose ) {
				echo "Suggestion record found in $dbname without swappable bit turned on in status record. Turning on swappable for $page_id\n";
			}
		}

		// Finally, make sure that all pages listed in the page_wikia_props table actually exist in the page table.
		// If they do not, delete them.
		$result = $db->query( "SELECT pp.page_id FROM page_wikia_props pp LEFT JOIN page p ON pp.page_id=p.page_id WHERE p.page_id IS NULL" );

		$page_ids = array();
		while ( $row = $db->fetchObject( $result ) ) {
			$page_ids[] = $row->page_id;
		}

		// Send MySQL pages to be deleted in batches of 100
		foreach ( array_chunk( $page_ids, 100 ) as $chunk ) {
			if ( $verbose ) {
				echo "Deleted pages found in $dbname. Deleting corresponding LVS rows from page_wikia_props\n";
			}
			if ( !$test and !empty($chunk) ) {
				$db->query( "DELETE FROM page_wikia_props WHERE page_id IN (" . implode(",", $chunk) . ") and propname between " .
					WPP_LVS_STATUS_INFO . " and " . WPP_LVS_STATUS);
			}
		}
	}
}



