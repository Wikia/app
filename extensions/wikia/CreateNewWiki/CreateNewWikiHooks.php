<?php

class CreateNewWikiHooks {

	public static function onMakeGlobalVariablesScript( array &$vars, OutputPage $outputPage ) {
		if ( $outputPage->getTitle()->isSpecial( 'CreateNewWiki' ) ) {
			global $wgFandomBaseDomain;

			$vars['wgFandomBaseDomain'] = $wgFandomBaseDomain;
		}
	}
}
