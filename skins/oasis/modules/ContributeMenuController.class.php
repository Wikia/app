<?php

class ContributeMenuController extends WikiaController {

	private $defaultSpecialPagesData = [
		'Upload' => [
			'label' => 'oasis-navigation-v2-add-photo'
		],
		'CreatePage' => [
			'label' => 'oasis-navigation-v2-create-page',
			'class' => 'createpage',
		],
		'WikiActivity' => [
			'label' => 'oasis-button-wiki-activity',
			'accesskey' => 'g',
		]
	];

	public function executeIndex() {
		// add "edit this page" item
		$dropdownItems = array();
		$content_actions = $this->app->getSkinTemplateObj()->data[ 'content_actions' ];
		if ( isset($content_actions[ 'edit' ] ) ) {
			$dropdownItems[ 'edit' ] = $this->getEditPageItem( $content_actions[ 'edit' ][ 'href' ] );
		}

		// menu items linking to special pages
		foreach ($this->getSpecialPagesLinks() as $specialPageName => $link) {
			$specialPageTitle = SpecialPage::getTitleFor( $specialPageName );
			if (!$specialPageTitle instanceof Title) {
				continue;
			}

			$attrs = [
				'text' => wfMsg( $link[ 'label' ] ),
				'href' =>  $specialPageTitle->getLocalURL(),
			];

			if ( isset( $link[ 'accesskey' ] ) ) {
				$attrs[ 'accesskey' ] = $link[ 'accesskey' ];
			}

			if ( isset( $link[ 'class' ] ) ) {
				$attrs[ 'class' ] = $link[ 'class' ];
			}

			$dropdownItems[ strtolower( $specialPageName ) ] = $attrs;
		}

		if( $this->wg->User->isAllowed( 'editinterface' ) ) {
			$dropdownItems[ 'wikinavedit' ] = $this->getEditNavItem();
		}

		$this->response->setVal( 'dropdownItems', $dropdownItems );
	}

	/**
	 * Helper method which returns an array of special pages links
	 * ContributeMenuController::executeIndex() to create uses the array returned by this method to build a menu items
	 * for contribution button in Wikia Nav
	 *
	 * @return array
	 */
	public function getSpecialPagesLinks() {
		$specialPages = $this->defaultSpecialPagesData;

		// check if Special:Videos is enabled before showing 'add video' link
		// add video button
		if( !empty( $this->wg->EnableSpecialVideosExt) && $this->wg->User->isAllowed( 'videoupload' ) ) {
			$addVideoLink = array(
				'WikiaVideoAdd' => array(
					'label' => 'oasis-navigation-v2-add-video'
				)
			);

			$specialPages = array_merge( $addVideoLink, $specialPages );
		}

		if( !empty( $this->wg->EnableWikiaInteractiveMaps ) ) {
			$addMapsLink = [
				'Maps' => [
					'label' => 'wikia-interactive-maps-create-a-map',
					'class' => 'wikia-maps-create-map'
				]
			];

			$specialPages = array_merge( $addMapsLink, $specialPages );
		}

		return $specialPages;
	}

	public function getEditPageItem( $url ) {
		return [
			'text' => wfMsg( 'oasis-navigation-v2-edit-page' ),
			'href' => $url,
			// don't use MenuButton module magic to get accesskey for this item (BugId:15698)
			'accesskey' => false,
		];
	}

	public function getEditNavItem() {
		return [
			'text' => wfMsg( 'oasis-navigation-v2-edit-this-menu' ),
			'href' => Title::newFromText( NavigationModel::WIKI_LOCAL_MESSAGE, NS_MEDIAWIKI )->getLocalURL( 'action=edit' ),
		];
	}

}
