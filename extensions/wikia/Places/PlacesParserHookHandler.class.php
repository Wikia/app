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

	/**
	 * Render <place> tag
	 *
	 * @param string $content tag content (will be ignored)
	 * @param array $attributes tag attributes
	 * @param Parser $parser MW parser instance
	 * @param PPFrame $frame parent frame with the context
	 * @return string HTML output of the tag
	 */
	static public function renderPlaceTag($content, array $attributes, Parser $parser, PPFrame $frame) {
		wfProfileIn(__METHOD__);

		// wrap data in a model object
		$placeModel = F::build('PlaceModel', array($attributes), 'newFromAttributes');

		// render parser hook
		$html = F::app()->sendRequest(
			'Places',
			'placeFromModel',
			array(
				'model'	=> $placeModel
			)
		)->toString();

		// add JS snippets code
		$html .= self::getJSSnippet();

		// add model to be stored in database
		PlacesHookHandler::setModelToSave($placeModel);

		wfProfileOut(__METHOD__);
		return $html;
	}

	/**
	 * Render <places> tag
	 *
	 * @param string $content tag content (will be ignored)
	 * @param array $attributes tag attributes
	 * @param Parser $parser MW parser instance
	 * @param PPFrame $frame parent frame with the context
	 * @return string HTML output of the tag
	 */
	static public function renderPlacesTag($content, array $attributes, Parser $parser, PPFrame $frame) {
		wfProfileIn(__METHOD__);

		// debug code !!!
		/**
		$places = F::build('PlacesModel');
		var_dump($places->getAll());
		var_dump($places->getNearby(F::build('PlaceModel', array('lat' => 52.408893, 'lon' => 16.9335963), 'newFromAttributes')), 15);
		var_dump($places->getNearbyByTitle(F::build('Title', array('Dworzec Letni'), 'newFromText')), 15);
		var_dump($places->getFromCategories('Budynki'));
		var_dump($places->getFromCategories(array('Budynki', 'Stary Rynek')));
		**/

		$html = '';

		// add JS snippets code
		$html .= self::getJSSnippet();

		wfProfileOut(__METHOD__);
		return $html;
	}

	/**
	 * Get JavaScript code snippet to be loaded
	 */
	static private function getJSSnippet() {
		$html = F::build('JSSnippets')->addToStack(
			array(
				'/extensions/wikia/Places/css/Places.css',
				'/extensions/wikia/Places/js/Places.js',
				'http://maps.googleapis.com/maps/api/js?sensor=false&callback=$.noop',
			),
			array(),
			'Places.init'
		);

		return $html;
	}
}
