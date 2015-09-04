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

	}

	public function execute() {
		global $wgCityId;

		$this->output( "Processing wiki id: {$wgCityId}\n" );

		$jsPages = $this->getJsPages();

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
			$this->revisionModel = new Wikia\ContentReview\Models\CurrentRevisionModel();
		}

		return $this->revisionModel;
	}

	private function getJsPages() {
		$db = wfGetDB( DB_SLAVE );

		$jsPages = ( new \WikiaSQL() )
			->SELECT( 'page_id', 'page_title', 'page_latest' )
			->FROM( 'page' )
			->WHERE( 'page_namespace' )->EQUAL_TO( NS_MEDIAWIKI )
			->AND_( 'LOWER (page_title)' )->LIKE( '%' . self::JS_FILE_EXTENSION )
			->runLoop( $db, function ( &$jsPages, $row ) {
				$jsPages[$row->page_id] = get_object_vars( $row );
			} );

		return $jsPages;

	}
}

$maintClass = 'ReviewedRevision';
require_once( RUN_MAINTENANCE_IF_MAIN );
