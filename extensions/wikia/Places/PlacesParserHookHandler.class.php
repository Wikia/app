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
		$placeModel = PlaceModel::newFromAttributes($attributes);

		// are we rendering for RTE?
		$inRTE = !empty(F::app()->wg->RTEParserEnabled);

		if ($inRTE) {
			$wikitext = RTEData::get('wikitext', self::$lastWikitextId);

			$data = array(
				'wikitext' => $wikitext,
				'placeholder' => 1,
			);

			$rteData = RTEData::convertDataToAttributes($data);
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
		(new PlacesHooks)->setModelToSave($placeModel);

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

		// parse attributes
		$height = !empty($attributes['height']) && is_numeric($attributes['height']) ? $attributes['height'] : 400;
		$categories = !empty($attributes['category']) ? explode('|', $attributes['category']) : false;
		$animate = !empty($attributes['animate'])
			?
			is_numeric($attributes['animate']) ? intval($attributes['animate']) : 5 /* default animation delay in sec */
			:
			false;

		// get all places on this wiki
		$placesModel = new PlacesModel();
		$markers = empty($categories) ? $placesModel->getAll() : $placesModel->getFromCategories($categories);

		// render parser hook
		$html = F::app()->sendRequest(
			'Places',
			'renderMarkers',
			array(
				'markers' => $markers,
				'height' => $height,
				'options' => array(
					'animate' => $animate
				)
			)
		)->toString();

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
	static public function getJSSnippet(Array $options = array()) {
		$am = AssetsManager::getInstance();

		$html = JSSnippets::addToStack(
			array( 'places_css', 'places_js' ),
			array(),
			'Places.init',
			$options
		);

		return $html;
	}
}
