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

		$nav = $model->getFormattedWiki( NavigationModel::WIKI_LOCAL_MESSAGE );

		$this->setResponseData(
			[ 'navigation' => $nav ],
			[ 'urlFields' => 'href' ],
			NavigationModel::CACHE_TTL
		);
	}
}
