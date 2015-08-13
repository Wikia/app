<?php
// @author: Inez

$wgHooks['AlternateEdit'][] = 'ProtectSiteJS_handler';
$wgHooks['ArticleSave'][] = 'ProtectSiteJS_handler';
$wgHooks['EditPage::attemptSave'][] = 'ProtectSiteJS_handler';
function ProtectSiteJS_handler() {
	global $wgTitle, $wgUser, $wgOut;
	if ( empty( $wgTitle ) ) {
		return true;
	}
	if ( strtoupper( substr( $wgTitle->getText(), -3 ) ) === '.JS' ) {
		$groups = $wgUser->getEffectiveGroups();
		if ( !in_array( 'staff', $groups ) ) {
			$wgOut->addHTML( '<div class="errorbox" style="width:92%;">' );
			$wgOut->addWikiMsg( 'actionthrottledtext' );
			$wgOut->addHTML( '</div>' );
			return false;
		}
	}
	return true;
}
