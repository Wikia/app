<?php

class AbuseFilterViewImport extends AbuseFilterView {
	
	function show( ) {
		global $wgOut;
		
		$wgOut->addWikiMsg( 'abusefilter-import-intro' );
		
		$html = Xml::textarea( 'wpImportText', '', 40, 20 );
		$html .= Xml::submitButton( wfMsg( 'abusefilter-import-submit' ) );
		$url = SpecialPage::getTitleFor( 'AbuseFilter', 'new' )->getFullURL();
		
		$html = Xml::tags( 'form', array( 'method' => 'post', 'action' => $url ), $html );
		
		$wgOut->addHTML( $html );
	}
}
