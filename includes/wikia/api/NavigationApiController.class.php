<?php

/**
 * Controller to get Wiki Navigation for a wiki
 *
 * @author Jakub "Student" Olek
 */
class NavigationApiController extends WikiaApiController {

	/**
	 * Fetches wiki navigation
	 *
	 * @responseParam array $navigation Wiki Navigation
	 *
	 * @example
	 */

	public function getData() {
		$model = new NavigationModel();
		$wikitext = $this->request->getVal('wikitext');
		if ( !empty($wikitext) ) {
			$nav = $model->getFormattedWiki(NavigationModel::WIKI_LOCAL_MESSAGE, $wikitext);
		} else {
			$nav = $model->getFormattedWiki();
		}

		$this->setResponseData(
			[ 'navigation' => $nav ],
			[ 'urlFields' => 'href' ],
			NavigationModel::CACHE_TTL
		);
	}
}
