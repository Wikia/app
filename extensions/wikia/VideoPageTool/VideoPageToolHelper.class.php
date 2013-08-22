<?php

class VideoPageToolHelper extends WikiaModel {

	const DEFAULT_SECTION = 'featured';

	/**
	 * get list of sections
	 * @return array $sections
	 */
	public function getSections() {
		$sections = array(
			'featured' => wfMessage( 'videopagetool-section-featured' )->plain(),
			'trending' => wfMessage( 'videopagetool-section-trending' )->plain(),
			'fan' => wfMessage( 'videopagetool-section-fan' )->plain(),
		);

		return $sections;
	}

	/**
	 * get left menu items
	 * @param string $selected [featured/trending/fan]
	 * @return array $leftMenuItems
	 */
	public function getLeftMenuItems( $selected ) {
		$sections = $this->getSections();

		$leftMenuItems = array();
		foreach( $sections as $key => $value ) {
			$leftMenuItems[] = array(
				'title' => $value,
				'anchor' => $value,
				'href' => '#', // TODO: get the URL
				'selected' => ($selected == $key),
			);
		}

		return $leftMenuItems;
	}
}