<?php

/**
 * HTMLCacheUpdateTask (replaces core MediaWiki HTMLCacheUpdateJob)
 *
 * @author Scott Rabin (srabin@wikia-inc.com)
 */

namespace Wikia\Tasks\Tasks;


class HTMLCacheUpdateTask extends BaseTask {
	/**
	 * @return array black list of method names to hide on Special:Tasks
	 */
	public function getAdminNonExecuteables() {
		$blacklist = parent::getAdminNonExecuteables();
		$blacklist[] = 'purge';
		return $blacklist;
	}

	/**
	 * Purge the cache for backlinking pages (that is, pages containing
	 * a reference to the Title associated with this task)
	 *
	 * @param string|array $tables
	 */
	public function purge( $tables ) {
		global $wgUseFileCache, $wgUseSquid;

		$affectedTitles = $this->getAffectedTitles( (array)$tables );
		wfRunHooks( "BacklinksPurge", [ $affectedTitles ] );
		$affectedCount  = count( $affectedTitles );

		$this->info( "Purge Request", [
			'title' => $this->title->getPrefixedText(),
			'count' => $affectedCount,
			'tables' => $tables,
		] );

		// abort if no pages link to the associated Title
		if ( $affectedCount == 0 ) {
			return 0;
		}

		$dbw = wfGetDB( DB_MASTER );
		( new \WikiaSQL() )
			->UPDATE( 'page' )
			->SET( 'page_touched', $dbw->timestamp() )
			->WHERE( 'page_id' )->IN( array_map(function($t) {
				return $t->getArticleID();
			}, $affectedTitles) )
			->run( $dbw );

		// Update squid/varnish
		if ( $wgUseSquid ) {
			\SquidUpdate::newFromTitles( $affectedTitles )->doUpdate();
		}

		// Update file cache
		if  ( $wgUseFileCache ) {
			foreach ( $affectedTitles as $title ) {
				\HTMLFileCache::clearFileCache( $title );
			}
		}

		return $affectedCount;
	}

	/**
	 * Get the set of titles in the given tables that are affected by updating
	 * the associated Title
	 *
	 * @param array $tables
	 * @return array
	 */
	protected function getAffectedTitles( array $tables ) {
		$cache = $this->title->getBacklinkCache();
		$titles = [];
		foreach ( $tables as $table ) {
			foreach ( $cache->getLinks($table) as $title ) {
				$titles[] = $title;
			}
		}
		return $titles;
	}
}
