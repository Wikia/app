<?php

/**
 * PlacesParserHookHandler class
 *
 * @author Jakub Kurcek <jakub at wikia-inc.com>
 * @author Maciej Brencz <macbre at wikia-inc.com>
 * @date 2010-10-11
 * @copyright Copyright (C) 2010 Jakub Kurcek, Wikia Inc.
 * @copyright Copyright (C) 2010 Maciej Brencz, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class PlacesParserHookHandler {

	static public function renderPlaceTag($content, array $attributes, Parser $parser, PPFrame $frame) {
		wfProfileIn(__METHOD__);

		$html = F::app()->sendRequest(
			'Places',
			'placeFromAttributes',
			array(
				'attributes'	=> $attributes
			)
		)->toString();

		wfProfileOut(__METHOD__);
		return $html;
	}

	static public function placesSetup(Parser $parser) {
		$parser->setHook( 'place', 'PlacesParserHookHandler::renderPlaceTag' );
		$parser->setHook( 'places', 'PlacesParserHookHandler::renderPlacesTag' );

		return true;
	}
}
