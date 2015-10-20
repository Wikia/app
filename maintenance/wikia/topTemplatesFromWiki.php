<?php

/**
 *
 * @ingroup Maintenance
 */

require_once( dirname( __FILE__ ) . '../../Maintenance.php' );

class topTemplatesFromWiki extends Maintenance {
	const CACHE_TTL = 1;
	const TEMPLATES_MCACHE_KEY = 'top-wikis-template-list';

	/**
	 * Set script options
	 */
	public function __construct() {
		parent::__construct();
		$this->mDescription = 'topTemplatesFromWiki';
	}

	public function execute() {
		$data = $this->getTemplatesFromWiki();
		$this->output( "\nDone!\n" );

		$this->output($data);
	}

	protected function getTemplatesFromWiki() {


		$db = wfGetDB( DB_SLAVE );
		$pages = ( new \WikiaSQL() )
			->SELECT( 'tl_namespace AS namespace', 'tl_title AS title', 'COUNT(*) AS value' )
			->FROM( 'templatelinks' )
			->WHERE( 'tl_namespace' )->EQUAL_TO( NS_TEMPLATE )
			->GROUP_BY( 'tl_namespace', 'tl_title' )
			->HAVING( 'COUNT(*)' )->GREATER_THAN( 0 )
			->ORDER_BY( 'COUNT(*)' )->DESC()
			->runLoop( $db, function ( &$pages, $row ) {
				global $wgCityId;
				$pages[] = [
					'wiki_id' => $wgCityId,
					'page_id' => $row->value,
					'title' => $row->title
				];
			} );

		var_dump($pages);
		return $pages;
	}
}

$maintClass = 'topTemplatesFromWiki';
require_once( RUN_MAINTENANCE_IF_MAIN );
