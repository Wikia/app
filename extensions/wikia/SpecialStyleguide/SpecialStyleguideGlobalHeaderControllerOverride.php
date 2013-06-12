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
		$userLang = $this->wg->Lang->getCode();

		// Link to Wikia home page
		$centralUrl = 'http://www.wikia.com/Wikia';
		if ( ! empty( $this->wg->LangToCentralMap[$userLang] ) ) {
			$centralUrl = $this->wg->LangToCentralMap[$userLang];
		}

		$this->response->setVal( 'centralUrl', $centralUrl );

		$menuNodes = [
			0 => [ 'children' => [ 1 => 1, 2 => 2, 3 => 3 ] ],
			1 => [ 'original' => '#', 'text' => wfMessage('styleguide-home')->plain(), 'href' => '#', 'specialAttr' => null, 'parentIndex' => 0, 'depth' => 0, 'children' => [ ] ],
			2 => [ 'original' => '#', 'text' => wfMessage('styleguide-getting-started')->plain(), 'href' => '#', 'specialAttr' => null, 'parentIndex' => 0, 'depth' => 0, 'children' => [ ] ],
			3 => [ 'original' => '#', 'text' => wfMessage('styleguide-components')->plain(), 'href' => '#', 'specialAttr' => null, 'parentIndex' => 0, 'depth' => 0, 'children' => [ ] ]


		];

		$menuNodes[0][NavigationModel::HASH] = md5( serialize( $menuNodes ) );
		$this->response->setVal( 'menuNodes', $menuNodes );
		$this->response->setVal( 'menuNodesHash', ! empty( $this->menuNodes[0] ) ? $this->menuNodes[0]['hash'] : null );
		$this->response->setVal( 'topNavMenuItems', ! empty( $this->menuNodes[0] ) ? $this->menuNodes[0]['children'] : null );

		$this->response->setVal( 'altMessage', $this->wg->CityId % 5 == 1 ? '-alt' : '' );
		$this->response->setVal( 'displayHeader', ! $this->wg->HideNavigationHeaders );
	}
}
