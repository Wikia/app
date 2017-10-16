<?php

namespace VideosModule\Modules;

/**
 * Class Related
 *
 * Use WikiaSearchController to find premium videos related to the local wiki. (Search video content by wiki topics)
 *
 * @package VideosModule\Modules
 */
class Related extends Base {

	public function getSource() {
		return 'wiki-topics';
	}

	/**
	 * @return array - Premium videos related to the local wiki.
	 */
	public function getModuleVideos() {
		// Strip Wiki off the end of the wiki name if it exists
		$wikiTitle = preg_replace( '/ Wiki$/', '', $this->wg->Sitename );

		$params = [
			'defaultTopic' => $wikiTitle,
			'limit' => $this->getPaddedVideoLimit( $this->limit ),
		];

		$videoResults = $this->app->sendRequest( 'WikiaSearchController', 'searchVideosByTopics', $params )->getData();
		$videosWithDetails = $this->getVideoDetailFromVideoWiki( array_column( $videoResults, 'title' ) );

		foreach ( $videosWithDetails as $video ) {
			if ( $this->atVideoLimit() ) {
				break;
			}
			$this->addVideo( $video );
		}

		return $this->videos;
	}

	public function getCacheKey() {
		$cacheKey = parent::getCacheKey();

		return $cacheKey . ':' . $this->wg->DBname;
	}
}

