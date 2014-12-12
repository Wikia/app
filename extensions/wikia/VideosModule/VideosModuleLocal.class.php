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
	 * @return array - list of vertical videos (premium videos)
	 */
	public function getModuleVideos() {

		$filter = 'all';
		$paddedLimit = $this->getPaddedVideoLimit( $this->limit );

		$mediaService = new \MediaQueryService();
		$videoList = $mediaService->getVideoList( $this->sort, $filter, $paddedLimit );
		$videosWithDetails = $this->getVideoDetailFromLocalWiki( $videoList );

		foreach ( $videosWithDetails as $video ) {
			if ( $this->atVideoLimit() ) {
				break;
			}
			$this->addVideo( $video );
		}

		return $this->videos;
	}
}
