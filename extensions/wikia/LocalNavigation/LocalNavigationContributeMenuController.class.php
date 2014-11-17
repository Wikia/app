<?php

class LocalNavigationContributeMenuController extends WikiaController {

	private $dropdownItems = [];
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
		$this->dropdownItems = [];
		$contentActions = $this->app->getSkinTemplateObj()->data[ 'content_actions' ];
		if ( isset( $contentActions[ 'edit' ] ) ) {
			$this->dropdownItems[ 'edit' ] = $this->getEditPageItem( $contentActions[ 'edit' ][ 'href' ] );
		}

		// menu items linking to special pages
		foreach ( $this->getSpecialPagesLinks() as $specialPageName => $link ) {
			$specialPageTitle = SpecialPage::getTitleFor( $specialPageName );
			if ( !$specialPageTitle instanceof Title ) {
				continue;
			}

			$label = wfMessage( $link[ 'label' ] )->escaped();

			$attrs = [
				'text' => $label,
				'data-content' => $label,
				'href' =>  $specialPageTitle->getLocalURL(),
			];

			if ( isset( $link[ 'accesskey' ] ) ) {
				$attrs[ 'accesskey' ] = $link[ 'accesskey' ];
			}

			if ( isset( $link[ 'class' ] ) ) {
				$attrs[ 'class' ] = $link[ 'class' ];
			}

			$this->dropdownItems[ strtolower( $specialPageName ) ] = $attrs;
		}

		if( $this->wg->User->isAllowed( 'editinterface' ) ) {
			$this->dropdownItems[ 'wikinavedit' ] = $this->getEditNavItem();
		}

		$this->response->setVal( 'dropdownItemsRender', $this->setLinkAttributes() );
	}

	/**
	 * Helper method which returns an array of special pages links
	 * ContributeMenuController::executeIndex() to create uses the array returned by this method to build a menu items
	 * for contribution button in Wikia Nav
	 *
	 * @return Array
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
	 * @return Array
	 */
	public function getEditPageItem( $url ) {
		$content = wfMessage( 'oasis-navigation-v2-edit-page' )->escaped();
		return [
			'text' => $content,
			'data-content' => $content,
			'href' => $url,
			// don't use MenuButton module magic to get accesskey for this item (BugId:15698)
			'accesskey' => false,
		];
	}

	/**
	 * Returns an array passed later to the template; It's contribute menu "Edit navigation" item
	 * @return Array
	 */
	public function getEditNavItem() {
		$content = wfMessage( 'oasis-navigation-v2-edit-this-menu' )->escaped();
		return [
			'text' => $content,
			'data-content' => $content,
			'href' => Title::newFromText( NavigationModel::WIKI_LOCAL_MESSAGE, NS_MEDIAWIKI )->getLocalURL( 'action=edit' ),
		];
	}

	/**
	 * Simple getter returns ContributeMenuController::$defaultSpecialPagesData
	 * @return Array
	 */
	public function getDefaultSpecialPagesData() {
		return $this->defaultSpecialPagesData;
	}

	/**
	 * Returns a two item array with text and concatenated attributes for <a> tag to put into template
	 * @return Array list of rendered html for links' text contents and their attribute/value pairs
	 */
	private function setLinkAttributes() {
		$dropdownItemsRender = [];

		foreach( $this->dropdownItems as $itemName => $item ) {
			$dropdownItemsRender[ $itemName ][ 'attributes' ] = ' data-id="' . $itemName . '"';

			foreach ( $item as $attribute => $value ) {
				if ( $attribute === 'text' ) {
					$dropdownItemsRender[ $itemName ][ 'text' ] = $value;
					continue;
				} elseif ( $attribute === 'href' ) {
					$value = empty( $value ) ? '#' : $item[ 'href' ];
				}

				$dropdownItemsRender[ $itemName ][ 'attributes' ] .= empty( $value ) ? '' : ' ' . $attribute . '="' . $value . '"';
			}
		}

		return $dropdownItemsRender;
	}
}
