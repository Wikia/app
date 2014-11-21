<?php

class ArticleNavigationContributeMenuController extends WikiaController {

	public function getContributeActionsForDropdown() {
		$data = [
			'type' => 'menu',
			'caption' => wfMessage( 'oasis-button-contribute-tooltip' )->text(),
			'items' => []
		];

		$dropdownItems[] = $this->getMapItem();
		$dropdownItems[] = $this->getVideoUploadItem();
		$dropdownItems[] = $this->getAddPhotoItem();
		$dropdownItems[] = $this->getAddPageItem();
		$dropdownItems[] = $this->getEditWikiNavItem();

		foreach ( $dropdownItems as $item ) {
			if ( !empty( $item ) ) {
				$data['items'][] = $item;
			}
		}

		$this->response->setVal( 'data', $data );
	}

	private function getAddPhotoItem() {
		$caption = wfMessage( 'oasis-navigation-v2-add-photo' )->text();
		$href = SpecialPage::getTitleFor( 'Upload' )->getLocalURL();
		return $this->createDropdownItem( $caption, $href, 'add-a-photo' );
	}

	private function getMapItem() {
		if ( !empty( $this->wg->EnableWikiaInteractiveMaps ) ) {
			$caption = wfMessage( 'wikia-interactive-maps-create-a-map' )->text();
			$href = SpecialPage::getTitleFor( 'Maps' )->getLocalURL();
			return $this->createDropdownItem( $caption, $href, 'create-map-clicked' );
		}

		return false;
	}

	private function getVideoUploadItem() {
		if ( !empty( $this->wg->EnableSpecialVideosExt ) && $this->wg->User->isAllowed( 'videoupload' ) ) {
			$caption = wfMessage( 'oasis-navigation-v2-add-video' )->text();
			$href = SpecialPage::getTitleFor( 'WikiaVideoAdd' )->getLocalURL();
			return $this->createDropdownItem( $caption, $href, 'add-a-video' );
		}
		return false;
	}

	public function getEditNavItem() {
		if ( $this->wg->User->isAllowed( 'editinterface' ) ) {
			$caption = wfMessage( 'oasis-navigation-v2-edit-this-menu' )->escaped();
			$href = Title::newFromText( NavigationModel::WIKI_LOCAL_MESSAGE, NS_MEDIAWIKI )->getLocalURL( 'action=edit' );
			return $this->createDropdownItem( $caption, $href, 'wikinavedit' );
		}
		return false;
	}

	private function getAddPageItem() {
		$caption = wfMessage( 'oasis-navigation-v2-create-page' )->text();
		$href = SpecialPage::getTitleFor( 'CreatePage' )->getLocalURL();
		return $this->createDropdownItem( $caption, $href, 'add-a-page' );
	}

	private function getEditWikiNavItem() {
		if ( $this->wg->User->isAllowed( 'editinterface' ) ) {
			$caption = wfMessage( 'oasis-navigation-v2-edit-this-menu' )->escaped();
			$href = Title::newFromText( NavigationModel::WIKI_LOCAL_MESSAGE, NS_MEDIAWIKI )->getLocalURL( 'action=edit' );
			return $this->createDropdownItem( $caption, $href, 'edit-wiki-navigation' );
		}
		return false;
	}

	private function createDropdownItem( $caption, $href, $tracker ) {
		return [
			'caption' => $caption,
			'href' => $href,
			'tracker-name' => $tracker,
			'type' => 'link'
		];
	}
}
