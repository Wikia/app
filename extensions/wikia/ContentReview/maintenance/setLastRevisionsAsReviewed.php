<?php

$dir = __DIR__ . "/../../../../";
require_once( $dir . 'maintenance/Maintenance.php' );
require_once( '../ContentReview.setup.php' );

class ReviewedRevision extends Maintenance {

	const JS_FILE_EXTENSION = '.js';

	private $contentReviewService,
			$wikiaUser;

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

			$helper = new \Wikia\ContentReview\Helper();
			$jsPages = $helper->getJsPages();

			foreach ( $jsPages as $jsPage ) {
				if ( !empty( $jsPage['page_id'] ) && !empty( $jsPage['page_latest'] ) ) {
					try {
						$this->getContentReviewService()->automaticallyApproveRevision(
							$this->getWikiaUser(),
							$wgCityId,
							$jsPage['page_id'],
							$jsPage['page_latest']
						);
						$this->output( "Added revision id for page {$jsPage['page_title']} (ID: {$jsPage['page_id']})\n" );
					} catch( FluentSql\Exception\SqlException $e ) {
						$this->output( $e->getMessage() . "\n" );
					}
				}
			}

			$helper->purgeReviewedJsPagesTimestamp();
			Wikia\ContentReview\ContentReviewStatusesService::purgeJsPagesCache();
		} else {
			$this->output( "Wiki (Id: {$wgCityId}) has disabled custom scripts.\n" );
		}

	}

	private function getWikiaUser() {
		if ( empty( $this->wikiaUser ) ) {
			$this->wikiaUser = User::newFromName( 'Wikia' );
		}

		return $this->wikiaUser;
	}

	private function getContentReviewService() {
		if ( empty( $this->contentReviewService ) ) {
			$this->contentReviewService = new Wikia\ContentReview\ContentReviewService();
		}

		return $this->contentReviewService;
	}
}

$maintClass = 'ReviewedRevision';
require_once( RUN_MAINTENANCE_IF_MAIN );
