<?php 

/**
 * hook to set the java script var 
 */

class ContentWarningHooks {
	public static function onMakeGlobalVariablesScript( &$vars ) {
		$out = F::app()->sendRequest('ContentWarningController', 'getContentWarningApproved', array());		
		$vars['wgContentWarningApproved'] = $out->getVal('contentWarningApproved');
		return true;
	}
}