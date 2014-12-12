<?php

namespace VideosModule;

/**
 * Class VideosModuleRelated
 *
 * Use WikiaSearchController to find premium videos related to the local wiki. (Search video content by wiki topics)
 */
class Related extends Base {
	const SOURCE = 'wiki-topics';

	protected function getLogParams() {
		$params = parent::getLogParams();
		$params['sort'] = $this->sort;

		return $params;
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
		$videosWithDetails = $this->getVideoDetailFromVideoWiki( $this->getVideoTitles( $videoResults ) );

		foreach ( $videosWithDetails as $video ) {
			if ( $this->atVideoLimit() ) {
				break;
			}
			$this->addVideo( $video );
		}

		return $this->videos;
	}
}

