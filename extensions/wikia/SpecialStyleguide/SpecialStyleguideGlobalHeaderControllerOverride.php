<?php

/**
 * Class GlobalHeaderController
 *
 * This is a Styleguide - specific override of global header
 * Ugly at the moment; Duplicated code and markup
 *
 * TODO: when next changes to Global Header are made, modularize it and remove this override
 */
class GlobalHeaderController extends WikiaController {

	public function index() {
		$this->response->setVal( 'centralUrl', $this->getCentralUrl() );

		$this->response->setVal( 'menuNodes', $this->getMenuNodes() );
		$this->response->setVal( 'menuNodesHash', ! empty( $this->menuNodes[0] ) ? $this->menuNodes[0]['hash'] : null );
		$this->response->setVal( 'topNavMenuItems', ! empty( $this->menuNodes[0] ) ? $this->menuNodes[0]['children'] : null );
	}

	/**
	 * Generates array of nodes for styleguide top menu bar
	 * @return array
	 */
	private function getMenuNodes() {
		$menuNodes = [
			0 => [ 'children' => [ 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5 ] ],
			1 => [ 'original' => '#', 'text' => wfMessage( 'styleguide-home' )->plain(), 'href' => '#', 'specialAttr' => 'active', 'parentIndex' => 0, 'depth' => 0, 'children' => [ ] ],
			2 => [ 'original' => '#', 'text' => wfMessage( 'styleguide-get-started' )->plain(), 'href' => '#', 'specialAttr' => null, 'parentIndex' => 0, 'depth' => 0, 'children' => [ ] ],
			3 => [ 'original' => '#', 'text' => wfMessage( 'styleguide-base-styles' )->plain(), 'href' => '#', 'specialAttr' => null, 'parentIndex' => 0, 'depth' => 0, 'children' => [ ] ],
			4 => [ 'original' => '#', 'text' => wfMessage( 'styleguide-components' )->plain(), 'href' => '#', 'specialAttr' => null, 'parentIndex' => 0, 'depth' => 0, 'children' => [ ] ],
			5 => [ 'original' => '#', 'text' => wfMessage( 'styleguide-design' )->plain(), 'href' => '#', 'specialAttr' => null, 'parentIndex' => 0, 'depth' => 0, 'children' => [ ] ] ];

		$menuNodes[0][NavigationModel::HASH] = md5( serialize( $menuNodes ) );
		return $menuNodes;
	}

	/**
	 * @return string
	 */
	private function getCentralUrl() {
		$userLang = $this->wg->Lang->getCode();

		// Link to Wikia home page
		$centralUrl = 'http://www.wikia.com/Wikia';
		if ( ! empty( $this->wg->LangToCentralMap[$userLang] ) ) {
			$centralUrl = $this->wg->LangToCentralMap[$userLang];
			return $centralUrl;
		}
		return $centralUrl;
	}
}
