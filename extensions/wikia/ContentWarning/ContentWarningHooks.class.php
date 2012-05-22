<?php 

class ContentWarningHooks {
	public static function onMakeGlobalVariablesScript( &$vars ) {
		$vars['wgContentWarningApproved'] = false;
		return true;
	}
}