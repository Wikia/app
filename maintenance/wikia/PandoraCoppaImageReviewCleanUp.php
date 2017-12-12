<?php

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

class PandoraCoppaImageReviewCleanUp extends Maintenance {

	public function execute() {
		global $wgSpecialsDB, $wgCityId;

		$imageReviewDB = wfGetDB( DB_SLAVE, [], $wgSpecialsDB );
		$wikiDB = wfGetDB( DB_SLAVE );

		$result = $imageReviewDB->select( 'image_review.images_coppa',
			[ 'wiki_id', 'page_id', 'revision_id' ],
			[ 'wiki_id = ' . $wgCityId ],
			'PandoraCoppaImageReviewCleanUp:execute'
		);

		$missingImages = [];
		while ( $row = $result->fetchRow() ) {
			$pageTest = $wikiDB->select( 'page', [ 1 ], [ 'page_id = ' . $row['page_id'] ] );
			$revisionTest = $wikiDB->select( 'revision', [ 1 ], [ 'rev_id = ' . $row['revision_id'] ] );

			if ( $pageTest->numRows() == 0 && $revisionTest->numRows() == 0 ) {
				$missingImages[] = $row;
			}
		}

		print_r( $missingImages );
	}
}

$maintClass = "PandoraCoppaImageReviewCleanUp";
require_once( RUN_MAINTENANCE_IF_MAIN );
