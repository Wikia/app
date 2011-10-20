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

	static public function makePlace( $contents, $attributes, $parser ) {

		return F::app()->sendRequest(
			'Places',
			'placeFromAttributes',
			array(
				'attributes'	=> $attributes
			)
		)->toString();
	}

	static public function placesSetup( &$parser ) {

		$parser->setHook( 'place', 'PlacesParserHookHandler::makePlace' );
		$parser->setHook( 'places', 'PlacesParserHookHandler::makePlaces' );

		return true;
	}
}
