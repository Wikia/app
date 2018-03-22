<?php

class CommunityPageSpecialHelpModel {
	public function getData() {
		return [
			'title' => wfMessage( 'communitypage-help-module-title' )->text(),
			'titleIcon' => DesignSystemHelper::renderSvg( 'wds-icons-help' ),
			'editPage' => wfMessage( 'communitypage-help-edit-page' )->text(),
			'addLinks' => wfMessage( 'communitypage-help-add-link' )->text(),
			'addNewPage' => wfMessage( 'communitypage-help-add-new-page' )->text(),
			'communityPolicy' => wfMessage( 'communitypage-help-policy' )->text(),
			'editPageLink' => $this->getHelpPageLink( 'communitypage-help-module-edit-page-name' ),
			'addLinksPageLink' => $this->getHelpPageLink( 'communitypage-help-module-add-link-name' ),
			'addNewPageLink' => $this->getHelpPageLink( 'communitypage-help-module-new-page-name' ),
			'communityPolicyIcon' => DesignSystemHelper::renderSvg( 'wds-icons-clipboard-small' ),
			'communityPolicyLink' => $this->getPolicyLink()
		];
	}

	private function getHelpPageLink( $messageKey ){
		return Title::newFromText(
			wfMessage( $messageKey )->inContentLanguage()->plain(), NS_HELP
		)->getLocalURL();
	}

	private function getPolicyLink() {
		global $wgUser;

		$title = Title::newFromText(
			wfMessage( 'communitypage-policy-module-link-page-name' )->inContentLanguage()->plain(),
 			NS_MAIN
		);

 		if ( $title instanceof Title ) {
			return $title->getFullURL();
 		}

 		// this is a business decision: fallback to landing page taken from preferences
 		return UserService::getMainPage( $wgUser )->getLocalURL();
 	}
}
