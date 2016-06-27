<?php

class CommunityPageSpecialHelpModel {
	public function getData() {
		return [
			'title' => wfMessage( 'communitypage-help-module-title' )->plain(),
			'editPage' => wfMessage( 'communitypage-help-edit-pages' )->plain(),
			'addLinks' => wfMessage( 'communitypage-help-add-link' )->plain(),
			'addNewPage' => wfMessage( 'communitypage-help-add-new-page' )->plain(),
			'editPageLink' => $this->geteditPageLink(),
			'addLinksPageLink' => $this->getAddLinksPageLink(),
			'addNewPageLink' => $this->getAddNewPageLink()
		];
	}
	
	private function geteditPageLink() {
		return Title::newFromText(
			wfMessage( 'communitypage-help-module-edit-page-name' )->inContentLanguage()->plain(), NS_HELP
		)->getLocalURL();
	}

	private function getAddLinksPageLink() {
		return Title::newFromText(
			wfMessage( 'communitypage-help-module-add-link-name' )->inContentLanguage()->plain(), NS_HELP
		)->getLocalURL();
	}

	private function getAddNewPageLink() {
		return Title::newFromText(
			wfMessage( 'communitypage-help-module-new-page-name' )->inContentLanguage()->plain(), NS_HELP
		)->getLocalURL();
	}
}
