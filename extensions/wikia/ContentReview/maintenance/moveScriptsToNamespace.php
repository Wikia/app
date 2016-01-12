<?php

$dir = __DIR__ . "/../../../../";
require_once( $dir . 'maintenance/Maintenance.php' );

use Wikia\Util\GlobalStateWrapper;

class MoveScripts extends Maintenance {

	const JS_FILE_EXTENSION = '.js';

	private $contentReviewService,
			$wikiaUser;

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();

		$this->addOption( 'targetNS', 'Target namespace.' );
		$this->addOption( 'reason', 'Reason for the move.');
	}

	public function execute() {
		global $wgCityId, $wgEnableContentReviewExt;

		$namespace = $this->getOption( 'targetNS', NS_MEDIAWIKI );
		$reason = $this->getOption( 'reason', '' );

		if ( !empty( $wgEnableContentReviewExt ) ) {
			$f = fopen( 'move.log', 'w+' );
			$this->output( "Processing wiki id: {$wgCityId}\n" );

			$helper = new \Wikia\ContentReview\Helper();
			$jsPages = $helper->getJsPages( NS_MAIN );

			$wrapper = new GlobalStateWrapper( [
				'wgUser' => $this->getWikiaUser()
			] );

			foreach ( $jsPages as $jsPage ) {
				if ( !empty( $jsPage['page_id'] ) && !empty( $jsPage['page_latest'] ) ) {
					$title = Title::newFromText( $jsPage['page_title'] );
					$newTitle = Title::newFromText( $jsPage['page_title'], $namespace );
					if ( $title->exists() ) {
						$status = $wrapper->wrap( function() use ( $title, $newTitle, $reason ) {
							return $title->moveTo( $newTitle, true, $reason, false );
						});

						if ( $status ) {
							RepoGroup::singleton()->clearCache( $newTitle );
							$newTitle = Title::newFromID( $jsPage['page_id'] );

							$latestRev =  $newTitle->getLatestRevID();
							$this->output( "{$jsPage['page_title']} was moved to {$namespace} namespace\n" );
							fwrite( $f, "{$jsPage['page_title']} was moved to {$namespace} namespace\n" );
							try {
								$this->getContentReviewService()->automaticallyApproveRevision(
									$this->getWikiaUser(),
									$wgCityId,
									$jsPage['page_id'],
									$latestRev
								);
								$this->output( "Added revision ({$latestRev}/{$jsPage['page_latest']}) id for page {$jsPage['page_title']} (ID: {$jsPage['page_id']})\n" );
								fwrite( $f, "Added revision ({$latestRev}/{$jsPage['page_latest']}) id for page {$jsPage['page_title']} (ID: {$jsPage['page_id']})\n" );
							} catch ( FluentSql\Exception\SqlException $e ) {
								$this->output( $e->getMessage() . "\n" );
							}
						}
					}
				}
			}

			fclose( $f );

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

$maintClass = 'MoveScripts';
require_once( RUN_MAINTENANCE_IF_MAIN );
