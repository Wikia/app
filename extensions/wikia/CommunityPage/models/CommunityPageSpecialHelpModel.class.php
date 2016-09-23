<?php

class CommunityPageSpecialHelpModel {
	public function getData() {
		return [
			'title' => wfMessage( 'communitypage-help-module-title' )->text(),
			'editPage' => wfMessage( 'communitypage-help-edit-page' )->text(),
			'addLinks' => wfMessage( 'communitypage-help-add-link' )->text(),
			'addNewPage' => wfMessage( 'communitypage-help-add-new-page' )->text(),
			'editPageLink' => $this->getHelpPageLink( 'communitypage-help-module-edit-page-name' ),
			'addLinksPageLink' => $this->getHelpPageLink( 'communitypage-help-module-add-link-name' ),
			'addNewPageLink' => $this->getHelpPageLink( 'communitypage-help-module-new-page-name' )
		];
	}

	private function getHelpPageLink( $messageKey ){
		return Title::newFromText(
			wfMessage( $messageKey )->inContentLanguage()->plain(), NS_HELP
		)->getLocalURL();
	}
}
