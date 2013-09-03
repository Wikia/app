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
	
	/**
	 * @desc Array item in global header connected to Special:Styleguide/Home page
	 */
	const HOME_NODE = 1;
	
	/**
	 * @desc Array item in global header connected to Special:Styleguide/Get_started page
	 */
	const GET_STARTED_NODE = 2;

	/**
	 * @desc Array item in global header connected to Special:Styleguide/Base_styles page
	 */
	const BASE_STYLES_NODE = 3;

	/**
	 * @desc Array item in global header connected to Special:Styleguide/Components page
	 */
	const COMPONENTS_NODE = 4;

	/**
	 * @desc Array item in global header connected to Special:Styleguide/Design page
	 */
	const DESIGN_NODE = 5;


	public function index() {
		$this->response->setVal( 'centralUrl', $this->getCentralUrl() );
		
		$subpage = mb_strtolower( $this->getFirstTextAfterSlash( $this->wg->Title->getSubpageText() ) );
		
		switch( $subpage ) {
			case 'components':
				$this->response->setVal( 'menuNodes', $this->getMenuNodes( self::COMPONENTS_NODE ) );
				break;
			default:
				$this->response->setVal( 'menuNodes', $this->getMenuNodes() );
				break;
		}
		
		$this->response->setVal( 'menuNodesHash', ! empty( $this->menuNodes[0] ) ? $this->menuNodes[0]['hash'] : null );
		$this->response->setVal( 'topNavMenuItems', ! empty( $this->menuNodes[0] ) ? $this->menuNodes[0]['children'] : null );
	}

	/**
	 * Generates array of nodes for styleguide top menu bar
	 * @param int $activeElement
	 * @return array
	 */
	private function getMenuNodes( $activeElement = self::HOME_NODE ) {
		$menuNodes = [
			0 => [ 'children' => [ 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5 ] ],
			self::HOME_NODE => [
				'original' => '#',
				'text' => wfMessage( 'styleguide-home' )->plain(),
				'href' => $this->getLink(),
				'specialAttr' => null,
				'parentIndex' => 0,
				'depth' => 0,
				'children' => []
			],
			self::GET_STARTED_NODE => [
				'original' => '#',
				'text' => wfMessage( 'styleguide-get-started' )->plain(),
				'href' => $this->getLink( 'Get started' ),
				'specialAttr' => null, 'parentIndex' => 0,
				'depth' => 0,
				'children' => []
			],
			self::BASE_STYLES_NODE => [
				'original' => '#',
				'text' => wfMessage( 'styleguide-base-styles' )->plain(),
				'href' => $this->getLink( 'Base Styles' ),
				'specialAttr' => null,
				'parentIndex' => 0,
				'depth' => 0,
				'children' => []
			],
			self::COMPONENTS_NODE => [
				'original' => '#',
				'text' => wfMessage( 'styleguide-components' )->plain(),
				'href' => $this->getLink( 'Components' ),
				'specialAttr' => null,
				'parentIndex' => 0,
				'depth' => 0,
				'children' => []
			],
			self::DESIGN_NODE => [
				'original' => '#',
				'text' => wfMessage( 'styleguide-design' )->plain(),
				'href' => $this->getLink( 'Design' ),
				'specialAttr' => null,
				'parentIndex' => 0,
				'depth' => 0,
				'children' => []
			]
		];

		$menuNodes[$activeElement]['specialAttr'] = 'active';
		
		$menuNodes[0][NavigationModel::HASH] = md5( serialize( $menuNodes ) );
		return $menuNodes;
	}
	
	private function getFirstTextAfterSlash( $subpageText ) {
		$supageArr = explode( '/', $subpageText );
		return ( !empty($supageArr[1]) ) ? $supageArr[1] : '';
	}
	
	private function getLink( $pageName = false ) {
		$styleguideModel = new SpecialStyleguideDataModel();
		return $styleguideModel->getStyleguidePageUrl( $pageName );
	}

	/**
	 * @return string
	 */
	private function getCentralUrl() {
		$userLang = $this->wg->Lang->getCode();

		// Link to Wikia home page
		$centralUrl = wfMessage( 'styleguide-corporate-wiki-link' )->plain();
		if ( ! empty( $this->wg->LangToCentralMap[$userLang] ) ) {
			$centralUrl = $this->wg->LangToCentralMap[$userLang];
			return $centralUrl;
		}
		return $centralUrl;
	}
}
