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

	public function setSerie( $serie ){

		$serie = (int)$serie;
		$this->serie = ( $serie < 0 ) ? 0 : $serie;
	}

	public function setMaxItems( $maxItems ){

		$maxItems = (int)$maxItems;
		$this->maxItems = ( $maxItems < 0 ) ? 0 : $maxItems;
	}

	public function __construct( $url ) {

		$itemCount = 0;
		$rssContent = Http::get( $url );
		$this->feed = new SimplePie();
		$this->feed->set_raw_data($rssContent);
		$this->feed->set_cache_duration(0);
		$this->feed->init();
	}

	public static function newFromUrl( $url ){
		
		return new CrunchyrollRSS( $url );
	}

	public function getTitle(){
		
		return $this->feed->get_title();

	}

	public function getItems(){

		$aResult = array();
		foreach(  $this->feed->get_items( 0, $this->maxItems ) as $item ){

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
				
				$link.= '/'.$this->serie;
				if ( !empty( $episodeId ) ){
					$link.= '/'.$episodeId;
				}
			}

			$enclosure = $item->get_enclosure();
				$aResult[] = array(
				'title'		=> $item->get_title(),
				'thumbnail'	=> $enclosure->get_thumbnail(),
				'link'		=> $link
			);
		}

		return $aResult;
	}	
}

