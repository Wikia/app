<?php

class CommunityPageSpecialCommunityPolicyModel {
	public function getData( $userId ) {
		$admins = ( new WikiService() )->getWikiAdminIds( 0, false, false, null, false );
		$isAdmin = in_array( $userId, $admins );

		$title = Title::newFromText(
			wfMessage( 'communitypage-policy-pagetitle', [ 'content' ] )->inContentLanguage()->plain(),
			NS_HELP
		);
		$policyText = Title::newFromText( 'communitypage-policy-text', NS_MEDIAWIKI );

		return [
			'policyUrl' => $title->getFullURL(),
			'editPolicyUrl' => $policyText->getFullURL( [ 'action' => 'edit' ] ),
			'policyHeading' => wfMessage( 'communitypage-policy-heading' )->plain(),
			'policyText' => wfMessage( 'communitypage-policy-text' )->plain(),
			'policyEdit' => wfMessage( 'communitypage-policy-edit' )->plain(),
			'policyView' => wfMessage( 'communitypage-policy-view' )->plain(),
			'showEditLink' => $isAdmin,
		];
	}
}
