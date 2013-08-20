<?php

class VideoPageToolHelper {
	public static function getLeftMenuItems( $selected ) {
		$sections = array( 'featured', 'trending', 'fan' );

		if( !in_array( $selected, $sections ) ) {
			// optional: add an error message here, otherwise just send them to "featured"
			$selected = $sections[0];
		}

		$leftMenuItems = array();

		foreach( $sections as $section ) {
			$leftMenuItems[] = array(
				'title' => wfMessage( 'videopagetool-section-' . $section ),
				'anchor' => wfMessage( 'videopagetool-section-' . $section ),
				'href' => '#', // TODO: get the URL
				'selected' => ($selected == $section),
			);
		}

		return $leftMenuItems;
	}
}