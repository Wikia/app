<?php

class GlobalNavigationHooks {

	//In case monobook skin is selected we need to set wgMWSuggestTemplate variable.
	//By default wgEnableMWSuggest is disabled when GlobalNav extension is enabled.
	//ResourceLoaderStartUpModule operates on different web request than main context.
	//That's why changing wgEnableMWSuggest to true in hook is not enough
	static public function onResourceLoaderGetConfigVarsWithContext(&$vars, $context) {
		global $wgUseAjax;
		$skin = $context->getSkin();

		if ($skin == 'monobook' || $skin == 'uncyclopedia') {
			if (!empty($wgUseAjax)) {
				$vars['wgMWSuggestTemplate'] = SearchEngine::getMWSuggestTemplate();
			}
		}

		return true;
	}

	//In case of monobook, GlobalNavigation is not present and we want to show to users MW suggestions.
	static public function onOutputPageParserOutput( OutputPage &$out, ParserOutput $parseroutput ) {
		global $wgEnableMWSuggest;
		$skin = $out->getSkin()->getSkinName();

		if ($skin == 'monobook' || $skin == 'uncyclopedia') {
			$wgEnableMWSuggest = true;
		}
		return true;
	}
}
