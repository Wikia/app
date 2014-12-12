<?php

namespace VideosModule;

/**
 * Class VideosModuleLocal
 *
 * Get videos added to the wiki
 */
class Local extends Base {

	const SOURCE = 'local';

	public function getCacheKey() {
		$cacheKey = parent::getCacheKey();

		return implode( ':', $cacheKey, $this->sort );
	}

	protected function getLogParams() {
		$params = parent::getLogParams();
		$params['sort'] = $this->sort;

		return $params;
	}

	/**
	 * @param string $sort [recent/trend] - how to sort the results
	 * @return array - list of vertical videos (premium videos)
	 */
	public function getModuleVideos() {

		$filter = 'all';
		$paddedLimit = $this->getPaddedVideoLimit( $this->limit );

		$mediaService = new \MediaQueryService();
		$videoList = $mediaService->getVideoList( $this->sort, $filter, $paddedLimit );
		$videosWithDetails = $this->getVideoDetailFromLocalWiki( $videoList );

		$videos = [];
		foreach ( $videosWithDetails as $video ) {
			if ( count( $videos ) >= $this->limit ) {
				break;
			}
			$this->addToList( $videos, $video );
		}

		return $videos;
	}
}
