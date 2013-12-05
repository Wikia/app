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

	const STATUS_SWAPPABLE = 8;
	const WPP_LVS_SUGGEST = 19;
	const WPP_LVS_STATUS = 22;


	public static function run ( $db, $dbname, $verbose = false, $test = false ) {

		// Get all pages which have a status record with the swappable
		// bit turned on, but do not have a corresponding suggestions record
		$sql = "SELECT page_id
				FROM page_wikia_props
				WHERE propname = WPP_LVS_STATUS
				AND props & STATUS_SWAPPABLE != 0
				AND page_id not in (
					SELECT page_id
					FROM page_wikia_props
					WHERE propname = WPP_LVS_SUGGEST)";
		$result = $db->query($sql);

		$pagesWithoutSuggestions = array();
		while ( $row = $db->fetchObject( $result ) ) {
			$pagesWithoutSuggestions[] = $row->page_id;
		}

		// Turn off the swappable bit in the props column for any page_ids found in the previous query
		foreach ( $pagesWithoutSuggestions as $page )   {
			$sql = "UPDATE page_wikia_props
					SET props=props & ~STATUS_SWAPPABLE
					WHERE page_id = $page
					AND propname = WPP_LVS_STATUS";
			$db->query( $sql );

			if ($verbose) {
				echo "Found status record in $dbname without suggestion record. Turning off swappable bit for page_id: $page\n";
				print_tmp("Turn off bit. Database: $dbname -- Page_id: $page\n");
			}
		}

		// Get all pages which have a suggestion record, but do not have a status record with the swappable bit turned on
		$sql = "SELECT page_id
				FROM page_wikia_props
				WHERE propname = WPP_LVS_SUGGEST
				AND page_id not in (
					SELECT page_id
					FROM page_wikia_props
					WHERE propname = WPP_LVS_STATUS
					AND props & STATUS_SWAPPABLE != 0)";
		$result = $db->query($sql);

		$suggestionsWithoutSwappableBit = array();
		while ( $row = $db->fetchObject( $result ) ) {
			$suggestionsWithoutSwappableBit[] = $row->page_id;
		}

		// Turn on the swappable bit in the props column for any page_ids found in the previous query
		foreach ( $suggestionsWithoutSwappableBit as $suggestion )   {
			// First make sure that a status record actually exists for this video
			$result = $db->query( "SELECT page_id from page_wikia_props where page_id = $suggestion and propname = WPP_LVS_STATUS" );
			// if not, create it first
			if (! $db->fetchObject( $result )) {
				$db->query( "INSERT INTO page_wikia_props (page_id, propname, props) values ($suggestion, WPP_LVS_STATUS, 0)" );
			}

			// Turn on swappable bit
			$db->query( "UPDATE page_wikia_props SET props=props | STATUS_SWAPPABLE WHERE page_id = $suggestion AND propname = WPP_LVS_STATUS" );
			if ( $verbose ) {
				echo "Suggestion record found in $dbname without swappable bit turned on in status record. Turning on swappable for $suggestion\n";
				print_tmp("Turn on bit. Database: $dbname -- Page_id: $suggestion\n");
			}
		}

		// Finally, make sure that all pages listed in the page_wikia_props table actually exist in the page table.
		// If they do not, delete them.
		$result = $db->query("SELECT page_id FROM page_wikia_props WHERE page_id NOT IN (SELECT page_id FROM page)");

		$deletePages = array();
		while ( $row = $db->fetchObject( $result ) ) {
			$deletePages[] = $row->page_id;
		}

		foreach ( $deletePages as $page ) {
			$db->query( "DELETE FROM page_wikia_props WHERE page_id = $page" );
			if ( $verbose ) {
				echo "Deleted page found in $dbname. Deleting records with page_id $page from page_wikia_props\n";
				print_tmp("Deleted page found in $dbname. Deleting records with page_id $page from page_wikia_props");
			}
		}

	}
}



