<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'Meebo',
	'author' => 'William Lee'
);

$wgHooks['MakeGlobalVariablesScript'][] = 'Meebo::onMakeGlobalVariablesScript';

class Meebo {
	public static function onMakeGlobalVariablesScript( &$vars ) {
		global $wgEnableMeeboExt;
		wfProfileIn( __METHOD__ );

		global $wgRequest, $wgNoExternals;
		$wgNoExternals = $wgRequest->getBool('noexternals', $wgNoExternals);

		$vars['wgEnableMeeboExt'] = $wgEnableMeeboExt && !$wgNoExternals;

		wfProfileOut( __METHOD__ );
		return true;
	} // end onMakeGlobalVariablesScript()
}
