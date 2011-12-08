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

	// stores wikitextId to be used when rendering placeholder for RTE
	static public $lastWikitextId;

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

		// are we rendering for RTE?
		$inRTE = !empty(F::app()->wg->RTEParserEnabled);

		if ($inRTE) {
			$wikitext = F::build('RTEData', array('wikitext', self::$lastWikitextId), 'get');

			$data = array(
				'wikitext' => $wikitext,
				'placeholder' => 1,
			);

			$rteData = F::build('RTEData', array($data), 'convertDataToAttributes');
		}
		else {
			$rteData = false;
		}

		// render parser hook
		$html = F::app()->sendRequest(
			'Places',
			'placeFromModel',
			array(
				'model'	=> $placeModel,
				'rteData' => $rteData,
			)
		)->toString();

		// add JS snippets code
		if (!$inRTE) {
			$html .= self::getJSSnippet();
		}

		// add model to be stored in database
		PlacesHookHandler::setModelToSave($placeModel);

		$html = self::cleanHTML($html);

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
		$title = F::build('Title', array('Zajezdnia tramwajowa przy ulicy Gajowej'), 'newFromText');
		var_dump($places->getAll());
		var_dump($places->getNearbyByTitle($title, 15));
		var_dump($places->getFromCategories('Budynki'));
		var_dump($places->getFromCategories(array('Budynki', 'Stary Rynek')));
		var_dump($places->getFromCategoriesByTitle($title));
		**/

		$html = '';

		// add JS snippets code
		$html .= self::getJSSnippet();

		wfProfileOut(__METHOD__);
		return $html;
	}

	/**
	 * Remove whitespaces confusing MW parser
	 *
	 * @param string $html parser tag output to be cleaned up
	 * @return string cleaned up HTML
	 */
	static private function cleanHTML($html) {
		return strtr($html, array(
			"\n" => '',
			"\t" => '',
		));
	}

	/**
	 * Get JavaScript code snippet to be loaded
	 */
	static private function getJSSnippet() {
		$html = F::build('JSSnippets')->addToStack(
			array(
				'/extensions/wikia/Places/css/Places.css',
				'/extensions/wikia/Places/js/Places.js',
			),
			array(),
			'Places.init',
			null,
			array(JSSnippets::FILTER_NONE, 'wikiamobile')
		);

		return $html;
	}
}
