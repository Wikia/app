<?php
class AbuseFilterViewImport extends AbuseFilterView {

	function show() {
		global $wgOut, $wgUser;
		if ( !$wgUser->isAllowed( 'abusefilter-modify' ) ) {
			$wgOut->addWikiMsg( 'abusefilter-edit-notallowed' );
			return;
		}

		$wgOut->addWikiMsg( 'abusefilter-import-intro' );

		$html = Xml::textarea( 'wpImportText', '', 40, 20 );
		$html .= Xml::submitButton( wfMsg( 'abusefilter-import-submit' ) );
		$url = SpecialPage::getTitleFor( 'AbuseFilter', 'new' )->getFullURL();

		$html = Xml::tags( 'form', array( 'method' => 'post', 'action' => $url ), $html );

		$wgOut->addHTML( $html );
	}
}
