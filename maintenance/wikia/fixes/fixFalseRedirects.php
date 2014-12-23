<?php

/**
 * Fix for redirect pages which in fact aren't real redirects
 * https://wikia-inc.atlassian.net/browse/CON-2305
 *
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '../../../Maintenance.php' );

class FixFalseRedirects extends Maintenance {

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Fix for false redirect pages';
	}

	public function execute() {
		global $wgCityId;

		$db = wfGetDB( DB_MASTER );

		( new WikiaSQL() )
			->SELECT( '*' )
			->FROM( 'page' )
			->WHERE( 'page_is_redirect' )->EQUAL_TO( 1 )
			->runLoop( $db, function ( $a, $row ) use ( $db ) {
				$title = Title::newFromID( $row->page_id );

				if ( !$title->isDeleted() ) {
					$rev = Revision::newFromTitle( $title );
					$text = $rev->getText();

					$rt = Title::newFromRedirectRecurse( $text );

					if ( !$rt ) {
						// page is marked as redirect but $text is not valid redirect
						$this->output( 'Fixed ID: ' . $title->getArticleID() . ' Title: ' . $title->getText() . "\n" );
						// Fix page table
						( new WikiaSQL() )
							->UPDATE( 'page' )
							->SET( 'page_is_redirect', 0 )
							->WHERE( 'page_id' )->EQUAL_TO( $row->page_id )
							->RUN( $db );

						// remove redirect from redirect table
						( new WikiaSQL() )
							->DELETE( 'redirect' )
							->WHERE( 'rd_from' )->EQUAL_TO( $row->page_id )
							->RUN( $db );

						// clear cache
						LinkCache::singleton()->addGoodLinkObj( $row->page_id, $title, strlen( $text ), 0, $rev->getId() );

						if ( $title->getNamespace() == NS_FILE ) {
							RepoGroup::singleton()->getLocalRepo()->invalidateImageRedirect( $title );
						}
					}
				}
			} );
	}
}

$maintClass = 'FixFalseRedirects';
require_once( RUN_MAINTENANCE_IF_MAIN );
