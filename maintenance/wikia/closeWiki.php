<?php

/**
 * Script that marks a given wiki to be removed by /extensions/wikia/WikiFactory/Close/maintenance.php script
 *
 * @author macbre
 * @see SUS-3255
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '/../Maintenance.php' );

class CloseWiki extends Maintenance {

	const REASON = 'Marked for removal by CloseWiki maintenance script due to SUS-3249';

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'Marks a given wiki for removal';
	}

	/**
	 * Mark given wiki as queued for removal
	 *
	 * @param integer $wikiId city ID
	 * @param string  $reason why we marked the wiki
	 * @return bool
	 */
	private function markWikiAsClosed( int $wikiId, string $reason ) :bool {
		WikiFactory::setFlags( $wikiId, WikiFactory::FLAG_FREE_WIKI_URL | WikiFactory::FLAG_DELETE_DB_IMAGES );
		$res = WikiFactory::setPublicStatus( WikiFactory::CLOSE_ACTION, $wikiId, $reason );
		WikiFactory::clearCache( $wikiId );

		return $res !== false;
	}

	public function execute() {
		global $wgCityId;
		$isOk = $this->markWikiAsClosed( $wgCityId, self::REASON );

		if ( $isOk ) {
			$this->output( "Wiki has been marked for removal!\n" );
		}
		else {
			$this->error( 'Failed to mark a wiki for removal!', 1 );
		}
	}
}

$maintClass = CloseWiki::class;
require_once( RUN_MAINTENANCE_IF_MAIN );
