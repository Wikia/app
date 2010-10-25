<?php

/**
 * RelatedVideoRSS class
 * Handles RSS parsing for RelatedVideos extension
 *
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @date 2010-10-11
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class RelatedVideoRSS {

	private $feed;

	public function __construct( $url ) {

		$itemCount = 0;
		$rssContent = Http::get( $url );
		$this->feed = new SimplePie();
		$this->feed->set_raw_data($rssContent);
		$this->feed->set_cache_duration(0);
		$this->feed->init();
	}

	public static function newFromUrl( $url ){
		return new RelatedVideoRSS( $url );
	}

	public function getTitle() {
		foreach ($this->feed->get_items() as $item) {
			return $this->getTagData( $item->get_item_tags( '', 'title' ) );
		}
	}

	public function getPlayer() {
		foreach ($this->feed->get_items() as $item) {
			return $this->getTagData( $item->get_item_tags( SIMPLEPIE_NAMESPACE_MEDIARSS, 'player' ) );
		}
	}

	public function getRelated() {
		$result = array();
		foreach ( $this->feed->get_items() as $item ) {
			$data = $item->get_item_tags( '', 'related' );
			foreach ( $data[0]['child']['']['item'] as $subItem ){
				$result[] = array(
					'id'	=>	$this->getTagData( $subItem['child']['']['id'] ),
					'title' =>	$this->getTagData( $subItem['child']['']['title'] ),
					'thumbnail' =>	$this->getTagData( $subItem['child']['']['image'][0]['child']['']['url'] )
				);
			}
		}
		return $result;
	}

	private function getTagData( $tagResult ){
		return $tagResult[0]["data"];
	}
}

