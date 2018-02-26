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

		$totalGalleryPageCount = 0; // Keeps track of actual existing titles with gallery
		$dbGalleryCount = $this->getGalleryPageCount(); // All counts including those with missing titles

		// Paginate the operation to prevent db/memory overload
		for ( $limitCount = 0; $limitCount < $dbGalleryCount; $limitCount += self::PAGE_COUNT_LIMIT ) {
			$galleryPageIds = $this->getGalleryPageIds( $limitCount );

			$galleryPageTitles = \Title::newFromIDs( $galleryPageIds );

			$galleryPageCount  = count( $galleryPageTitles );

			// abort if no pages were found
			if ( $galleryPageCount == 0 ) {
				continue;
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
		}

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
		global $wgSpecialsDB;
		$app = \F::app();

		$specialsDB = wfGetDB( DB_SLAVE, null, $wgSpecialsDB );
		$pages = ( new \WikiaSQL() )
			->SELECT( 'DISTINCT ct_page_id' )
			->FROM( 'city_used_tags' )
			->WHERE( 'ct_wikia_id' )->EQUAL_TO( $app->wg->CityId )
			->LIMIT( self::PAGE_COUNT_LIMIT )
			->OFFSET( $offset )
			->runLoop( $specialsDB, function ( &$pages, $row ) {
				$pages[] = $row->ct_page_id;
			} );

		return $pages;
	}

	/**
	 * Get count of all pages with gallery tag
	 * @return int
	 */
	protected function getGalleryPageCount() {
		global $wgSpecialsDB;
		$app = \F::app();

		$specialsDB = wfGetDB( DB_SLAVE, null, $wgSpecialsDB );
		$count = ( new \WikiaSQL() )
			->SELECT( 'COUNT(DISTINCT ct_page_id)' )->AS_( 'count' )
			->FROM( 'city_used_tags' )
			->WHERE( 'ct_wikia_id' )->EQUAL_TO( $app->wg->CityId )
			->run( $specialsDB, function ( $row ) {
				$row = $row->fetchObject();
				return empty($row) ? 0 : $row->count;
			} );

		return $count;
	}

}
