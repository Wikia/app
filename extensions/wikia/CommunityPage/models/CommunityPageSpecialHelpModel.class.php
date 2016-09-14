<?php

class CommunityPageSpecialHelpModel {
	public function getData() {
		return [
			'title' => wfMessage( 'communitypage-help-module-title' )->plain(),
			'titleIcon' => file_get_contents( 'extensions/wikia/CommunityPage/images/help_icon.svg' ),
			'editPage' => wfMessage( 'communitypage-help-edit-page' )->plain(),
			'addLinks' => wfMessage( 'communitypage-help-add-link' )->plain(),
			'addNewPage' => wfMessage( 'communitypage-help-add-new-page' )->plain(),
			'editPageLink' => $this->getHelpPageLink( 'communitypage-help-module-edit-page-name' ),
			'addLinksPageLink' => $this->getHelpPageLink( 'communitypage-help-module-add-link-name' ),
			'addNewPageLink' => $this->getHelpPageLink( 'communitypage-help-module-new-page-name' ),
			'communityPolicyIcon' => file_get_contents( 'extensions/wikia/CommunityPage/images/help_community_policy.svg' )
		];
	}

	private function getHelpPageLink( $messageKey ){
		return Title::newFromText(
			wfMessage( $messageKey )->inContentLanguage()->plain(), NS_HELP
		)->getLocalURL();
	}
}
