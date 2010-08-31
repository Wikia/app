<?php

class SpecialThemeDesigner extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'ThemeDesigner', 'themedesigner' );
	}

	public function execute() {
		Wikia::setVar('OasisEntryModuleName', 'ThemeDesigner');
		
		wfLoadExtensionMessages('ThemeDesigner');
	}
}
