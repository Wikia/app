<?php

class CommunityPageSpecialCommunityPolicyModel {
	public function getData() {
		global $wgUser;

		return [
			'policyUrl' => $this->getPolicyLink(),
			'editPolicyUrl' => $this->getPolicyTextEditLink(),
			'policyHeading' => wfMessage( 'communitypage-policy-heading' )->plain(),
			'policyText' => wfMessage( 'communitypage-policy-text' )->plain(),
			'policyEdit' => wfMessage( 'communitypage-policy-edit' )->plain(),
			'policyView' => wfMessage( 'communitypage-policy-view' )->plain(),
			'showEditLink' => true,//in_array( 'sysop', $wgUser->getEffectiveGroups() ),
		];
	}

	private function getPolicyLink() {
		$title = Title::newFromText(
			wfMessage( 'communitypage-policy-pagetitle' )->inContentLanguage()->plain(),
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
