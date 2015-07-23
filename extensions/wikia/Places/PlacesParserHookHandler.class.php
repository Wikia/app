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

	static private $recursionLock = false;

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

			// support "hidden" atrribute
			// <place ... hidden />
			if (!empty($attributes['hidden'])) {
				$html = '<!-- hidden place tag -->';
			}
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
	 * @param string $content tag content
	 * @param array $attributes tag attributes
	 * @param Parser $parser MW parser instance
	 * @param PPFrame $frame parent frame with the context
	 * @return string HTML output of the tag
	 */
	static public function renderPlacesTag($content, array $attributes, Parser $parser, PPFrame $frame) {

		/**
		 * Prevent "Fatal error: Maximum function nesting level of '200' reached"
		 *
		 * PlacesModel calls ArticleSnippet and ImageServing that can trigger the parsing of the current article.
		 * This can lead to an end-less recursion.
		 */
		if ( self::$recursionLock ) {
			wfDebug( __METHOD__ . " - recursion detected, leaving\n" );
			return '';
		}
		self::$recursionLock = true;

		wfProfileIn(__METHOD__);

		// parse attributes
		$content = trim($content);
		$height = !empty($attributes['height']) && is_numeric($attributes['height']) ? $attributes['height'] : 400;
		$categories = !empty($attributes['category']) ? explode('|', $attributes['category']) : false;
		$animate = !empty($attributes['animate'])
			?
			is_numeric($attributes['animate']) ? intval($attributes['animate']) : 5 /* default animation delay in sec */
			:
			false;

		$placesModel = new PlacesModel();
		$markers = false;

		// <places>
		// Foo
		// Bar
		// </places>
		// render places for a given list of articles
		if ($content !== '') {
			#$content = $parser->recursiveTagParse($content, $frame); // TODO: parse nested parser hooks like <dpl>
			$markers = $placesModel->getFromText($content);
		}
		// <places category="Foo" />
		// render places in a given category / categories
		else if (is_array($categories)) {
			$markers = $placesModel->getFromCategories($categories);
		}
		// <places />
		// render all places defined on this wiki (up to 100)
		else {
			$markers = $placesModel->getAll(100);
		}

		#self::$recursionLock = false; return print_r($markers, true); # debug

		if (!empty($markers)) {
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
		}
		else {
			// render an error messages
			$html = Html::element(
				'span',
				['class' => 'error'],
				wfMessage('places-error-no-matches')->text()
			);
		}

		self::$recursionLock = false;
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
