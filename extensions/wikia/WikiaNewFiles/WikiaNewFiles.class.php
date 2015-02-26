<?php
/**
 * @ingroup SpecialPage
 * Extends the IncludeableSpecialPage to override some of the header formatting
 *
 */

class WikiaNewFiles extends SpecialNewFiles {
	function execute( $par ) {
		global $wgUser;
		$this->mName  = 'WikiaNewFiles';
		$this->setHeaders();
		if (!$wgUser->isAnon()) {
			Wikia::addAssetsToOutput('upload_photos_dialog_js');
			Wikia::addAssetsToOutput('upload_photos_dialog_scss');
		}
		wfSpecialWikiaNewFiles( $par, $this );
	}

	/**
	 * @see SpecialPage::getDescription
	 */
	public function getDescription() {
		return $this->msg( 'wikianewfiles-title' )->text();
	}
}
