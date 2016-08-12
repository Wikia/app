<?php

namespace Wikia\Tasks\Tasks;

/**
 * @class InsightsCleanupTask
 * Background task to clear invalid entries from MediaWiki link tables to avoid Special:Insights data issues
 * @package Wikia\Tasks\Tasks
 */
class InsightsCleanupTask extends BaseTask {

	/**
	 * @var array LINKS_TABLES MediaWiki link tables that are relevant to Insights data and should have invalid data purged
	 * @see https://www.mediawiki.org/wiki/Manual:Database_layout
	 */
	const LINKS_TABLES = [ 'categorylinks', 'templatelinks', 'imagelinks', 'pagelinks' ];

	/** @var \DatabaseMysqli $db */
	private $db;

	public function __construct() {
		$this->db = wfGetDB( DB_MASTER );
	}

	/**
	 * Clears invalid data from all links tables
	 */
	public function cleanLinksTables() {
		foreach ( static::LINKS_TABLES as $table ) {
			$this->clearStaleEntriesFromTable( $table );
		}
	}

	/**
	 * Clear all entries with an invalid (deleted) referring page from this links table
	 * @param string $table Table name (one of the LINKS_TABLES)
	 */
	private function clearStaleEntriesFromTable( $table ) {
		( new \WikiaSQL() )->DELETE( $table )
			->FROM( $table )
			->LEFT_JOIN( 'page' )
			->ON( $table[0] . 'l_from', 'page_id' )
			->WHERE( 'page_title')->IS_NULL()->runLoop( $this->db );
	}
}
