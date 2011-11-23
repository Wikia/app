<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'VisualDNA',
	'author' => 'William Lee'
);

$wgHooks['MakeGlobalVariablesScript'][] = 'VisualDNA::onMakeGlobalVariablesScript';

class VisualDNA {
	public static function onMakeGlobalVariablesScript( &$vars ) {
		global $wgIntegrateVisualDNAAAT;
		wfProfileIn( __METHOD__ );

		global $wgRequest, $wgNoExternals;
		$wgNoExternals = $wgRequest->getBool('noexternals', $wgNoExternals);

		$vars['wgIntegrateVisualDNAAAT'] = $wgIntegrateVisualDNAAAT && !$wgNoExternals;

		wfProfileOut( __METHOD__ );
		return true;
	} // end onMakeGlobalVariablesScript()
}
