<?php 

/**
 * Hooks to inject javascript in page to detect whether or not to display the content warning message 
 */
class ContentWarningHooks {
	public static function onGetHTMLAfterBody( $skin, &$output ) {
		$response = F::app()->sendRequest('ContentWarningController', 'getContentWarningApproved', array());

		// Logged in user has not approved content warning message or user is anonymous
		// in which case we will need to check the cookie on the client.
		if (!$response->getVal('contentWarningApproved')) {
			$output .= '<script>' . file_get_contents(dirname(__FILE__) . '/js/ContentWarningDetect.js') . '</script>';
		}

		return true;
	}

	public static function onBeforePageDisplay( OutputPage &$out, Skin &$skin ) {
		$out->addScriptFile(F::app()->wg->ExtensionsPath . '/wikia/ContentWarning/js/ContentWarning.js');
		$out->addStyle(AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/ContentWarning/css/ContentWarning.scss'));

		return true;
	}
}