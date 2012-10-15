<?php
/**
 * @ingroup SpecialPage
 * Extends the IncludeableSpecialPage to override some of the header formatting
 *
 */

class WikiaNewFiles extends SpecialNewFiles {
	function execute( $par ) {
		$this->mName  = 'WikiaNewFiles';
		$this->setHeaders();

		wfSpecialWikiaNewFiles( $par, $this );
	}

	/**
	 * @see SpecialPage::getDescription
	 */
	public function getDescription() {
		return wfMsg( 'wikianewfiles-title' );
	}
}
