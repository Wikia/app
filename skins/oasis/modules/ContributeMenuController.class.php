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
		$title = $this->wg->title;
		$user = $this->wg->user;

		if ($title->quickUserCan( 'edit', $user ) && ( $title->exists() || $title->quickUserCan( 'create', $user ) )) {
			$dropdownItems[ 'edit' ] = $this->getEditPageItem( $title->getLocalURL( [ 'action' => 'edit' ] ) );
		}

		// menu items linking to special pages
		foreach ($this->getSpecialPagesLinks() as $specialPageName => $link) {
			$specialPageTitle = SpecialPage::getTitleFor( $specialPageName );
			if (!$specialPageTitle instanceof Title) {
				continue;
			}

			$attrs = [
				'text' => wfMessage( $link[ 'label' ] )->escaped(),
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
		$specialPages = $this->getDefaultSpecialPagesData();

		// check if Special:Videos is enabled before showing 'add video' link
		// add video button
		if( !empty( $this->wg->EnableSpecialVideosExt ) && $this->wg->User->isAllowed( 'videoupload' ) ) {
			$addVideoLink = array(
				'WikiaVideoAdd' => [
					'label' => 'oasis-navigation-v2-add-video'
				]
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

	/**
	 * Returns an array passed later to the template; It's contribute menu "Edit" item
	 * @param String $url an URL to the page with action=edit parameter
	 * @return array
	 */
	public function getEditPageItem( $url ) {
		return [
			'text' => wfMessage( 'oasis-navigation-v2-edit-page' )->escaped(),
			'href' => $url,
			// don't use MenuButton module magic to get accesskey for this item (BugId:15698)
			'accesskey' => false,
		];
	}

	/**
	 * Returns an array passed later to the template; It's contribute menu "Edit navigation" item
	 * @return array
	 */
	public function getEditNavItem() {
		return [
			'text' => wfMessage( 'oasis-navigation-v2-edit-this-menu' )->escaped(),
			'href' => Title::newFromText( NavigationModel::WIKI_LOCAL_MESSAGE, NS_MEDIAWIKI )->getLocalURL( 'action=edit' ),
		];
	}

	/**
	 * Simple getter returns ContributeMenuController::$defaultSpecialPagesData
	 * @return array
	 */
	public function getDefaultSpecialPagesData() {
		return $this->defaultSpecialPagesData;
	}

}
