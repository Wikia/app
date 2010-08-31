<?php

class ThemeDesignerHelper {

	/**
	 * Add Special:ThemeDesigner to MyTools menu
	 */
	public static function addToMyTools(&$tools) {
		global $wgUser;

		if ($wgUser->isAllowed('themedesigner')) {
			wfLoadExtensionMessages('ThemeDesigner');
			$tools[] = 'ThemeDesigner';
		}

		return true;
	}
}
