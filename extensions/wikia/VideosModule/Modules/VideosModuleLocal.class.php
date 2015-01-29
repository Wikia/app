<?php

namespace VideosModule\Modules;

/**
 * Class Local
 *
 * Get videos added to the wiki
 *
 * @package VideosModule\Modules
 */
class Local extends Base {

	const SORT = 'trend';

	public function getSource() {
		return 'local';
	}

	public function getCacheKey() {
		$cacheKey = parent::getCacheKey();

		return implode( ':', [ $cacheKey, $this->sort ] );
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

	/**
	 * Get the video details (things like videoId, provider, description, regional restrictions, etc)
	 * for video from the local wiki.
	 *
	 * @param array $videos A list of video titles
	 * @return array
	 */
	public function getVideoDetailFromLocalWiki( array $videos ) {
		$videoDetails = [];
		$helper = new \VideoHandlerHelper();
		foreach ( $videos as $video ) {
			$details = $helper->getVideoDetail( $video, self::$videoOptions );
			if ( !empty( $details ) ) {
				$videoDetails[] = $details;
			}
		}
		return $videoDetails;
	}
}
