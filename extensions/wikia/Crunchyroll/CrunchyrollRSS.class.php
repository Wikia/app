<?php

/**
 * CrunchyrollRSS class
 * Handles RSS for Crunchyroll extension
 *
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @date 2010-10-11
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class CrunchyrollRSS {

	private $feed;
	private $maxItems = 0;
	private $serie;
	private $allowedCategories = array( 'anime', 'Anime' );
	private $blacklistedSeries = array();

	public function setSerie( $serie ){

		$serie = (int)$serie;
		$this->serie = ( $serie < 0 ) ? 0 : $serie;
	}

	public function setMaxItems( $maxItems ){

		$maxItems = (int)$maxItems;
		$this->maxItems = ( $maxItems < 0 ) ? 0 : $maxItems;
	}

	public function __construct( $url ) {

		$this->feed = $this->getFromCache( $url );
		if(empty($this->feed)) {
			$rssContent = Http::get( $url );
			$this->feed = new SimplePie();
			$this->feed->set_raw_data($rssContent);
			$this->feed->set_cache_duration(0);
			$this->feed->init();
			$this->saveToCache( $url, $this->feed );
		}
		$this->blacklistedSeries = F::app()->getGlobal( 'wgCrunchyrollBlacklistedSeries' );
	}

	public static function newFromUrl( $url ){

		return new CrunchyrollRSS( $url );
	}

	public function getTitle(){

		return $this->feed->get_title();
	}

	public function getItems(){

		$aResult = array();
		foreach(  $this->feed->get_items( 0 ) as $item ){

			$link = SpecialPage::getTitleFor('Crunchyroll')->getInternalURL();
			$link .= '/0';

			$episodeId = 0;

			// look for serie in link params
			$urlParams = parse_url( $item->get_link() );
			if ( isset( $urlParams['query'] ) ){
				parse_str( urldecode( $urlParams['query'] ), $data );
			}

			// get serie from two possible sources
			if (	isset( $data['type'] ) &&
				( $data['type'] = 'episodes' ) &&
				isset( $data['amp;id'] ) )
			{
				$this->setSerie( $data['amp;id'] );
			} else {
				$outsideLink = $item->get_link();
				$explodedOutsideLink = explode( '-', $outsideLink );
				$episodeId = $explodedOutsideLink[ count( $explodedOutsideLink ) - 1 ];
			}

			// if no serie - do not display episodes
			if ( !empty( $this->serie ) ){

				if ( is_array( $this->blacklistedSeries ) && in_array( $this->serie, $this->blacklistedSeries ) ){
					continue;
				}

				$link.= '/'.$this->serie;
				if ( !empty( $episodeId ) ){
					$link.= '/'.$episodeId;
				}
			}

			$cat = $item->get_category();
			if ( is_object( $cat ) && in_array( $cat->term, $this->allowedCategories ) ){

				$enclosure = $item->get_enclosure();
				$rating = $enclosure->get_rating();
				if (!empty( $this->serie ) && $rating->value != 'adult'	){

					$aResult[] = array(
						'title'		=> $item->get_title(),
						'thumbnail'	=> $enclosure->get_thumbnail(),
						'link'		=> $link
					);
				}
			}

			if ( !empty( $this->maxItems) && count( $aResult ) >= $this->maxItems ){
				break;
			}
		}

		return $aResult;
	}

	// cache functions

	protected function getKey( $url ) {
		return wfSharedMemcKey(
			'CrunchyrollVideoRSSFeedParsed',
			$url
		);
	}

	protected function saveToCache( $url, $content ) {
		global $wgMemc;

		$wgMemc->set( $this->getKey( $url ), $content, 60*60*6 );
		return true;
	}

	protected function getFromCache ( $url ){

		global $wgMemc;
		return $wgMemc->get( $this->getKey( $url ) );
	}
}

\Wikia\Logger\WikiaLogger::instance()->warning( 'Crunchyroll extension in use', [ 'file' => __FILE__ ] );
