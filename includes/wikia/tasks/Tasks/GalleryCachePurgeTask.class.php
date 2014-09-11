<?php

/**
 * GalleryCacheUpdateTask - Purge cache for all pages containing gallery tag
 */

namespace Wikia\Tasks\Tasks;


class GalleryCachePurgeTask extends BaseTask {

	const PAGE_COUNT_LIMIT = 1000;

	/**
	 * Purge the cache for pages containing gallery tags
	 */
	public function purge() {
		global $wgUseFileCache, $wgUseSquid;

		$totalGalleryPageCount = 0;

		// Paginate the operation to prevent db/memory overload
		do {
			$galleryPageIds = $this->getGalleryPageIds( $totalGalleryPageCount );

			$galleryPageTitles = \Title::newFromIDs( $galleryPageIds );

			$galleryPageCount  = count( $galleryPageTitles );

			// abort if no pages were found
			if ( $galleryPageCount == 0 ) {
				break;
			}

			// Update squid/varnish/parser cache
			if ( $wgUseSquid ) {
				foreach ( $galleryPageTitles as $title ) {
					$title->purgeSquid();
				}
			}

			// Update file cache if used
			if  ( $wgUseFileCache ) {
				foreach ( $galleryPageTitles as $title ) {
					\HTMLFileCache::clearFileCache( $title );
				}
			}

			$totalGalleryPageCount += $galleryPageCount;

		} while ( true ); // Bails when gallery pages are depleted

		$this->info( 'Gallery page purge request', [
			'title' => __METHOD__,
			'count' => $totalGalleryPageCount,
		] );

		return $totalGalleryPageCount;
	}

	/**
	 * Retrieve ids for all pages that contain gallery tag
	 * @param int $offset
	 * @return array
	 */
	protected function getGalleryPageIds( $offset = 0 ) {
		$app = \F::app();

		$statsdb = wfGetDB( DB_SLAVE, null, $app->wg->StatsDB );
		$pages = ( new \WikiaSQL() )
			->SELECT( 'DISTINCT ct_page_id' )
			->FROM( 'city_used_tags' )
			->WHERE( 'ct_wikia_id' )->EQUAL_TO( $app->wg->CityId )
			->LIMIT( self::PAGE_COUNT_LIMIT )
			->OFFSET( $offset )
			->runLoop( $statsdb, function ( &$pages, $row ) {
				$pages[] = $row->ct_page_id;
			} );

		return $pages;
	}

}
