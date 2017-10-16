<?php

class SpecialThemeDesigner extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'ThemeDesigner', 'themedesigner' );
	}

	public function execute( $par ) {
		// check rights
		if ( !ThemeDesignerHelper::checkAccess() ) {
			$this->displayRestrictionError();

			return;
		}

		Wikia::setVar( 'OasisEntryControllerName', 'ThemeDesigner' );
	}
}
