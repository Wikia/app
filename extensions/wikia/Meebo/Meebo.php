<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'Meebo',
	'author' => 'William Lee'
);

$wgHooks['MakeGlobalVariablesScript'][] = 'Meebo::onMakeGlobalVariablesScript';

class Meebo {
	private static $PROHIBITED_DBNAMES = array('fallout', 'answers');
	public static function onMakeGlobalVariablesScript( &$vars ) {
		global $wgEnableMeeboExt, $wgContLang, $wgDBname;
		wfProfileIn( __METHOD__ );

		global $wgRequest, $wgNoExternals, $wgUser;
		$wgNoExternals = $wgRequest->getBool('noexternals', $wgNoExternals);

		if ($wgEnableMeeboExt) {
			if (!$wgNoExternals) {
				if ($wgContLang->getCode() == 'en') {
					if ($wgUser->isAnon()) {
						if ($wgUser->getSkin()->getSkinName() == 'oasis') {
							if ($wgRequest->getText( 'action', 'view' ) == 'view') {
								if (array_search($wgDBname, self::$PROHIBITED_DBNAMES) === FALSE) {
									$vars['wgEnableMeeboExt'] = true;
								}
							}
						}
					}
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	} // end onMakeGlobalVariablesScript()
}
