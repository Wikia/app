<?php
class AbuseFilterViewImport extends AbuseFilterView {

	function show() {
		$out = $this->getOutput();
		if ( !$this->getUser()->isAllowed( 'abusefilter-modify' ) ) {
			$out->addWikiMsg( 'abusefilter-edit-notallowed' );
			return;
		}

		$out->addWikiMsg( 'abusefilter-import-intro' );

		$html = Xml::textarea( 'wpImportText', '', 40, 20 );
		$html .= Xml::submitButton(
			wfMsg( 'abusefilter-import-submit' ),
			array( 'accesskey' => 's' )
		);
		$url = SpecialPage::getTitleFor( 'AbuseFilter', 'new' )->getFullURL();

		$html = Xml::tags( 'form', array( 'method' => 'post', 'action' => $url ), $html );

		$out->addHTML( $html );
	}
}
