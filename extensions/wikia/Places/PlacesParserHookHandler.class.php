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
		$html.= '<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false"></script>';
		$html .= F::build('JSSnippets')->addToStack(
			array(
				'/extensions/wikia/Places/css/Places.css',
				'/extensions/wikia/Places/js/Places.js'
			),
			array(),
			'Places.init'
		);

		// queue model to be stored  in database
		PlacesHookHandler::setModelToSave($placeModel);

		wfProfileOut(__METHOD__);
		return $html;
	}
}
