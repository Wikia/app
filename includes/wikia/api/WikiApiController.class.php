<?php
/**
 * Controller to fetch information about wikis
 *
 * @author Adam Robak <adamr@wikia-inc.com>
 */

class WikiApiController extends WikiaApiController {

	const CACHE_VALIDITY = 86400;//1 day
	const MEMC_NAME = 'SharedWikiApiData:';
	private $keys;

	/**
	 * Gets the information about wikis
	 *
	 * @requestParam array $ids The list of wiki ids that will be fetched
	 * @requestParam int $height [OPTIONAL] Thumbnail height in pixels
	 * @requestParam int $width [OPTIONAL] Thumbnail width in pixels
	 * @requestParam int $snippet [OPTIONAL] Maximum number of words returned in description
	 *
	 * @responseParam array $items The list of wikis, each containing: title, url, description, thumbnail, no. of articles, no. of photos, list of top contributors, no. of videos
	 *
	 * @example &ids=159,831,3125
	 * @example &ids=159,831,3125&height=100&width=100
	 * @example &ids=159,831,3125&height=100&width=100&snippet=25
	 */
	public function getWikiData() {
		$ids = $this->request->getArray( 'ids' );
		$imageWidth = $this->request->getInt( 'width', 250 );

		$items = array();
		foreach ( $ids as $wikiId ) {
			if ( ( $cached = $this->getFromCacheWiki( $wikiId ) ) !== false ) {
				//get from cache
//				F::app()->wg->memc->delete( $this->getMemCacheKey( $wikiId ));
				$items[] = $cached;
			} else {
				//get data providers
				$wikiObj = WikiFactory::getWikiByID( $wikiId );
				$service = new WikiService();
				$wikiStats = $service->getSiteStats( $wikiId );
				$wikiDesc = $service->getWikiDescription( [ $wikiId ], $imageWidth );

				//missing table on dev-box, its available on production
//				$topUsers = $service->getTopEditors( $wikiId, 10, true );

				$wikiInfo = array(
					'wikiId' => (int) $wikiId,
					'articles' => (int) $wikiStats[ 'articles' ],
					'images' => (int) $wikiStats[ 'images' ],
					'videos' => (int) $service->getTotalVideos( $wikiId ),
//					'topUsers' => get from $topUsers,
					'title' => $wikiObj->city_title,
					'url' => $wikiObj->city_url,
					'thumbnail' => isset( $wikiDesc[ $wikiId ] ) ? $wikiDesc[ $wikiId ]['image_url'] : '',
					'description' => isset( $wikiDesc[ $wikiId ] ) ? $wikiDesc[ $wikiId ]['desc'] : '',
				);
				//cache data
//				$this->cacheWikiData( $wikiInfo );
				$items[] = $wikiInfo;
			}
		}

		$this->response->setVal( 'items', $items );
	}

	private function getMemCacheKey( $wikiId ) {
		if ( !isset( $this->keys[ $wikiId ] ) ) {
			$this->keys[ $wikiId ] =  F::app()->wf->sharedMemcKey( static::MEMC_NAME.$wikiId );
		}
		return $this->keys[ $wikiId ];
	}

	private function cacheWikiData( $wikiInfo ) {
		$key = $this->getMemCacheKey( $wikiInfo[ 'wikiId' ] );
		F::app()->wg->memc->set( $key, $wikiInfo, static::CACHE_VALIDITY );
	}

	private function getFromCacheWiki( $wikiId ) {
		$key = $this->getMemCacheKey( $wikiId );
		return F::app()->wg->memc->get( $key );
	}

}