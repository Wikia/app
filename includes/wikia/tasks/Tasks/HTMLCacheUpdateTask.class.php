<?php

/**
 * HTMLCacheUpdateTask (replaces core MediaWiki HTMLCacheUpdateJob)
 *
 * @author Scott Rabin (srabin@wikia-inc.com)
 */

namespace Wikia\Tasks\Tasks;


class HTMLCacheUpdateTask extends BaseTask {
	/**
	 * Purge the cache for backlinking pages (that is, pages containing
	 * a reference to the Title associated with this task)
	 *
	 * @param string|array $tables
	 */
	public function purge( $tables ) {
		global $wgUseFileCache, $wgUseSquid;

		$affectedTitles = $this->getAffectedTitles( (array)$tables );
		$affectedCount  = count( $affectedTitles );

		\Wikia\Logger\WikiaLogger::instance()->info( "Purge Request", [
			'title' => $this->title->getPrefixedText(),
			'count' => $affectedCount,
			'tables' => $tables,
		] );

		// abort if no pages link to the associated Title
		if ( $affectedCount == 0 ) {
			return;
		}

		$dbw = wfGetDB( DB_MASTER );
		$timestamp = $dbw->timestamp();

		$dbw->update( 'page',
			array( 'page_touched' => $timestamp ),
			array( 'page_id' => $affectedTitles ),
			__METHOD__
		);

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
		$ids = [];
		foreach ( $tables as $table ) {
			$numRows = $cache->getNumLinks( $table );
			$titles = $cache->getLinks( $table );
			foreach ( $titles as $title ) {
				$ids[] = $title->getArticleID();
			}
		}
		sr_log("Total:", $ids);
		return $ids;
	}
}
