<?php

require_once( dirname(__FILE__ ) . '/../../../../maintenance/Maintenance.php' );

class ImageReviewResetAbandonedWork extends Maintenance {

	public function execute() {
		$sFrom = ( new AbandonedWorkResetter() )->resetAbandonedWork();

		$this->output( "\nReviews older than {$sFrom} reset.\n" );
	}
}

$maintClass = "ImageReviewResetAbandonedWork";
require_once( RUN_MAINTENANCE_IF_MAIN );
