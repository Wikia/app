<?php

/**
* Maintenance script to add or update page status on file page for LicensedVideoSwap Extension
* This is one time use script
* @author Saipetch Kongkatong
*/

class LvsStatus {

	public static function lvsUpdateStatus( DatabaseMysql $db, $dbname, $verbose = false, $dryRun = false ) {
		echo "Wiki: $dbname\n";

		$limit = 5000;
		$total = 0;
		$kept = 0;
		$swapped = 0;
		$swappedExact = 0;
		$suggestions = 0;
		$totalAffected = 0;

		$statusInfo = WPP_LVS_STATUS_INFO;
		$statusSuggest = WPP_LVS_SUGGEST;
		$status = WPP_LVS_STATUS;

		$sqls[] = <<<SQL
				SELECT p1.page_id, p1.props as suggestions,
					substring(p2.props, locate('"status";i:', p2.props)+11, 1) status
				FROM page_wikia_props p1
				LEFT JOIN page_wikia_props p2 ON p1.page_id = p2.page_id AND p2.propname = $statusInfo
				WHERE p1.propname = $statusSuggest
				ORDER by p1.page_id
				LIMIT $limit
SQL;

		$sqls[] = <<<SQL
				SELECT p1.page_id, '' as suggestions,
					substring(p1.props, locate('"status";i:', p1.props)+11, 1) status
				FROM page_wikia_props p1
				LEFT JOIN page_wikia_props p2 ON p1.page_id = p2.page_id AND p2.propname = $statusSuggest
				WHERE p1.propname = $statusInfo AND p2.page_id is null
				ORDER by p1.page_id
				LIMIT $limit
SQL;

		foreach ( $sqls as $sql ) {
			echo "SQL: $sql\n";

			do {
				$result = $db->query( $sql, __METHOD__ );

				$pages = $result->numRows();
				echo "Total Pages: $pages\n";

				$cnt = 1;
				$total = $total + $pages;

				while ( $row = $db->fetchObject( $result ) ) {
					$pageId = $row->page_id;
					echo "\tPage ID $pageId [$cnt of $pages]: ";

					$flags = array();
					$statusList = array();

					// video with suggestions
					if( !empty( $row->suggestions ) ) {
						$statusList[] = "STATUS_SWAPPABLE";
						$flags[] = LicensedVideoSwapHelper::STATUS_SWAPPABLE;
						$suggestions++;
					}

					// kept video
					if ( !empty( $row->status) && $row->status == 1 ) {
						$statusList[] = "STATUS_KEEP";
						$flags[] = LicensedVideoSwapHelper::STATUS_KEEP;
						$kept++;
					}

					// swapped video
					if ( !empty( $row->status) && $row->status == 2 ) {
						$statusList[] = "STATUS_SWAP";
						$flags[] = LicensedVideoSwapHelper::STATUS_SWAP;
						$swapped++;
					}

					// swapped video with exact match
					if ( !empty( $row->status) && $row->status == 3 ) {
						$statusList[] = "STATUS_SWAP";
						$statusList[] = "STATUS_EXACT ";
						$flags[] = LicensedVideoSwapHelper::STATUS_SWAP;
						$flags[] = LicensedVideoSwapHelper::STATUS_EXACT;
						$swappedExact++;
					}

					$props = implode( '|', $flags );
					echo implode( ', ', $statusList )." ( $props ) .... ";

					$sqlInsert = <<<SQL
						INSERT INTO page_wikia_props (page_id, propname, props)
						VALUES ($pageId, $status, ($props))
						ON DUPLICATE KEY UPDATE props = (props | $props)
SQL;

					if ( $dryRun ) {
						$affected = 1;
					} else {
						$db->query( $sqlInsert, __METHOD__ );
						$affected = $db->affectedRows();
					}

					echo "$affected affected.\n";
					$totalAffected += $affected;
					$cnt++;
				}

			} while ( $pages == $limit );
			echo "\n";
		}

		echo "$dbname: Total Pages: $total, Kept Videos: $kept, Swapped Videos: $swapped, ";
		echo "Swapped Videos with Exact Match: $swappedExact, Videos with Suggestions: $suggestions, Affected: $totalAffected\n\n";
	}

}