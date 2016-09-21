<?php

class SpecialThemeDesigner extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'ThemeDesigner', 'themedesigner' );
	}

	public function execute( $par ) {
		wfProfileIn( __METHOD__ );

		// check rights
		if ( !ThemeDesignerHelper::checkAccess() ) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return;
		}

		Wikia::setVar( 'OasisEntryControllerName', 'ThemeDesigner' );

		wfProfileOut( __METHOD__ );
	}
}