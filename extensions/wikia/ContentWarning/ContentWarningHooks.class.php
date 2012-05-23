<?php 

/**
 * hook to set the java script var 
 */

class ContentWarningHooks {
	public static function onGetHTMLAfterBody( $skin, &$output ) {
		$out = F::app()->sendRequest('ContentWarningController', 'getContentWarningApproved', array());
		if(!$out->getVal('contentWarningApproved')) {
			$output .= "<script>".file_get_contents($dir = dirname(__FILE__) . '/js/' . 'ContentWarningBase.js')."</script>";
		}
		return true;
	}
}