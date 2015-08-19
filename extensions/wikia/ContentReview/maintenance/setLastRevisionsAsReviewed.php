<?php

$dir = dirname( __FILE__ ) . "/../../../../";
require_once( $dir . 'maintenance/Maintenance.php' );

use Wikia\ContentReview\Models;

class ReviewedRevision extends Maintenance {

	public static $jsPages = [
		'Wikia.js',
		'Common.js',
		'Monobook.js'
	];

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

		foreach ( self::$jsPages as $jsPage ) {
			$title = Title::newFromText( $jsPage, NS_MEDIAWIKI );
			if ( $title->exists() ) {
				$pageId = $title->getArticleID();
				$latestRevId = $title->getLatestRevID();

				if ( !empty( $pageId ) && !empty( $latestRevId ) ) {
					try {
						$this->getRevisionModel()->approveRevision( $wgCityId, $pageId, $latestRevId );
						$this->output( "Added revision id for page {$jsPage} (ID: {$pageId})\n" );
					} catch( FluentSql\Exception\SqlException $e ) {
						$this->output( $e->getMessage() . "\n" );
					}
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
