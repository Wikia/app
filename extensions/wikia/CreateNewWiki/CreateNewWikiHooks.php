<?php

class CreateNewWikiHooks {

	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $outputPage ) {
		if ( $outputPage->getTitle()->isSpecial( 'CreateNewWiki' ) ) {
			global $wgWikiaBaseDomain, $wgFandomBaseDomain,
				   $wgCreateLanguageWikisWithPath, $wgCreateEnglishWikisOnFandomCom;

			$vars['wgWikiaBaseDomain'] = $wgWikiaBaseDomain;
			$vars['wgFandomBaseDomain'] = $wgFandomBaseDomain;
			$vars['wgCreateLanguageWikisWithPath'] = $wgCreateLanguageWikisWithPath;
			$vars['wgCreateEnglishWikisOnFandomCom'] = $wgCreateEnglishWikisOnFandomCom;
		}
	}
}
