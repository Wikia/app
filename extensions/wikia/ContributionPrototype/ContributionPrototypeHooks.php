<?php

namespace ContributionPrototype;

use RequestContext;

class ContributionPrototypeHooks {

	/**
	 *  Loads a custom EditPage class, which gives us complete control of the HTML on the edit page
	 */

	static function onAlternateEditPageClass( &$editPage ) {
		global $wgArticle;
		$editPage = new CPEditor( $wgArticle );
		return true;
	}

	/**
	 *
	 * @param $page \Article|\Page
	 * @param $user \User
	 * @return bool
	 */
	public static function onCustomEditor( $page, $user ) {
		global $wgExtensionsPath;
		$title = $page->getTitle();
		$request = RequestContext::getMain()->getRequest();
		$out = RequestContext::getMain()->getOutput();

		// Temporarily load editor this way.  Figure out how to load editor properly.
		$out->addScriptFile($wgExtensionsPath. '/wikia/EditPageLayout/js/editor/WikiaEditor.js');
		$out->addScriptFile($wgExtensionsPath. '/wikia/ContributionPrototype/scripts/LoadEditor.js');

		return true;
	}

	public static function onMakeGlobalVariablesScript( Array &$vars ) {
		global $wgContributionPrototypeExternalHost;
		$vars['wgContributionPrototypeExternalHost'] = $wgContributionPrototypeExternalHost;
		return true;
	}


}