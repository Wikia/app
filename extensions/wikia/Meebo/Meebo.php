<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'Meebo',
	'author' => 'William Lee'
);

$wgHooks['MakeGlobalVariablesScript'][] = 'Meebo::onMakeGlobalVariablesScript';

class Meebo {
	private static $PROHIBITED_DBNAMES = array('answers');

	public static function onMakeGlobalVariablesScript(Array &$vars) {
		global $wgEnableMeeboExt, $wgEnableWikiaBarExt, $wgDBname;
		wfProfileIn(__METHOD__);

		global $wgRequest, $wgNoExternals, $wgUser;
		$wgNoExternals = $wgRequest->getBool('noexternals', $wgNoExternals);

		if (
			!empty($wgEnableMeeboExt)
			&& empty($wgEnableWikiaBarExt)
			&& !$wgNoExternals
			&& $wgUser->isAnon()
			&& RequestContext::getMain()->getSkin()->getSkinName() == 'oasis'
			&& $wgRequest->getText('action', 'view') == 'view'
			&& array_search($wgDBname, self::$PROHIBITED_DBNAMES) === FALSE
		) {
			$vars['wgEnableMeeboExt'] = true;
		}

		wfProfileOut(__METHOD__);
		return true;
	} // end onMakeGlobalVariablesScript()
}
