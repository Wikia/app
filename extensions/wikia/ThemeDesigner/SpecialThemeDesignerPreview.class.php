<?php

class SpecialThemeDesignerPreview extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'ThemeDesignerPreview', 'themedesignerpreview' );
	}

	public function execute() {
		wfProfileIn( __METHOD__ );
		wfProfileOut( __METHOD__ );
	}
}
