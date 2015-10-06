<?php

$dir = __DIR__ . "/../../../../";
require_once( $dir . 'maintenance/Maintenance.php' );

class ReviewedRevision extends Maintenance {

	const JS_FILE_EXTENSION = '.js';

	private $revisionModel;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

		$this->addOption( 'excludeEnabled', 'Exclude wikis on which ContentReview extension is enabled.' );
	}

	public function execute() {
		global $wgCityId, $wgUseSiteJs, $wgEnableContentReviewExt;

		$excludeWiki = false;
		$excludeEnabled = $this->getOption( 'excludeEnabled', false );

		if ( !empty( $excludeEnabled ) && !empty( $wgEnableContentReviewExt ) ) {
			$excludeWiki = true;
		}

		if ( !empty( $wgUseSiteJs ) && !$excludeWiki ) {
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
		} else {
			$this->output( "Wiki (Id: {$wgCityId}) has disabled custom scripts.\n" );
		}

	}

	private function getRevisionModel() {
		if ( empty( $this->revisionModel ) ) {
			$this->revisionModel = new Wikia\ContentReview\Models\CurrentRevisionModel();
		}

		return $this->revisionModel;
	}
}

$maintClass = 'ReviewedRevision';
require_once( RUN_MAINTENANCE_IF_MAIN );
