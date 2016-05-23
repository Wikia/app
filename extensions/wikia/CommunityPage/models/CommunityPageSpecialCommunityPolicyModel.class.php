<?php

class CommunityPageSpecialCommunityPolicyModel {
	public function getData() {
		global $wgUser;

		return [
			'link' => $this->getPolicyLink(),
			'editLink' => $this->getPolicyTextEditLink(),
			'title' => wfMessage( 'communitypage-policy-module-title' )->plain(),
			'text' => wfMessage( 'communitypage-policy-module-text' )->plain(),
			'editText' => wfMessage( 'communitypage-policy-module-edit-link-text' )->plain(),
			'linkText' => wfMessage( 'communitypage-policy-module-link-text' )->plain(),
			'showEditLink' => in_array( 'sysop', $wgUser->getEffectiveGroups() ),
		];
	}

	private function getPolicyLink() {
		$title = Title::newFromText(
			wfMessage( 'communitypage-policy-module-link-page-name' )->inContentLanguage()->plain(),
			NS_HELP
		);

		if ( $title instanceof Title ) {
			return $title->getFullURL();
		}

		return '';
	}

	private function getPolicyTextEditLink() {
		$title = Title::newFromText(
			'communitypage-policy-text',
			NS_MEDIAWIKI
		);

		if ( $title instanceof Title ) {
			return $title->getFullURL( ['action' => 'edit'] );
		}

		return '';
	}
}
