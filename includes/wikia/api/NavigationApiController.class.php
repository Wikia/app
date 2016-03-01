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
		$nav = $model->getWiki();

		$ret = array();
		foreach( $nav as $type => $list ){
			$ret[$type] = $this->getChildren( $list );
		}

		$this->setResponseData(
			[ 'navigation' => $ret ],
			[ 'urlFields' => 'href' ],
			NavigationModel::CACHE_TTL
		);
	}

	private function getChildren( $list, $i = 0 ){
		$children = array();
		$next = array();

		$element = $list[$i];

		if ( isset( $element['children'] ) ) {
			foreach( $element['children'] as $child ){
				$children[] = $this->getChildren( $list, $child );
			}
		}

		if ( isset( $element['text'] ) ) {
			$next = array(
				'text' => $element['text'],
				'href' => $element['href']
			);

			if( !empty( $children ) ) {
				$next['children'] = $children;
			}

		} else if ( !empty( $children ) ) {
			$next = $children;
		}

		return $next;
	}
}
