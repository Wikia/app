<?php

class CreateNewWikiHooks {

	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $outputPage ) {
		if ( $outputPage->getTitle()->isSpecial( 'CreateNewWiki' ) ) {
			global $wgWikiaBaseDomain, $wgCreateLanguageWikisWithPath;

			$vars['wgWikiaBaseDomain'] = $wgWikiaBaseDomain;
			$vars['wgCreateLanguageWikisWithPath'] = $wgCreateLanguageWikisWithPath;
		}
	}
}
