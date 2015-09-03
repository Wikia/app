<?php

$dir = dirname( __FILE__ ) . "/../../../../";
require_once( $dir . 'maintenance/Maintenance.php' );

use Wikia\ContentReview\Models;

class ReviewedRevision extends Maintenance {

	public $revisionModel;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

	}

	public function execute() {
		global $wgCityId;

		$this->output( "Processing wiki id: {$wgCityId}\n" );

		$jsPages = ( new \Wikia\ContentReview\Helper() )->getJsPages();

		foreach ( $jsPages as $jsPage ) {
			if ( !empty( $jsPage['page_id'] ) && !empty( $jsPage['page_latest'] ) ) {
				try {
					$this->getRevisionModel()->approveRevision( $wgCityId, $jsPage['page_id'], $jsPage['page_latest'] );
					$this->output( "Added revision id for page {$jsPage['page_title']} (ID: {$jsPage['page_id']})\n" );
				} catch( FluentSql\Exception\SqlException $e ) {
					$this->output( $e->getMessage() . "\n" );
				}
			}
		}
	}

	private function getRevisionModel() {
		if ( empty( $this->revisionModel ) ) {
			$this->revisionModel = new Models\CurrentRevisionModel();
		}

		return $this->revisionModel;
	}
}

$maintClass = 'ReviewedRevision';
require_once( RUN_MAINTENANCE_IF_MAIN );
