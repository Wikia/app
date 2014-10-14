<?php
class CreateNewWikiHooks {
	public static function onBeforePageDisplay(OutputPage $out, Skin $skin) {
		$wg = F::app()->wg;

		$wikiWelcome = $wg->request->getVal('wiki-welcome');
		$assetsManager = F::build( 'AssetsManager', array(), 'getInstance' );

		if(!empty($wikiWelcome)) {
			$out->addStyle( $assetsManager->getSassCommonURL( 'extensions/wikia/CreateNewWiki/css/WikiWelcome.scss' ) );
			$out->addScript( '<script src="' . $wg->ExtensionsPath . '/wikia/CreateNewWiki/js/WikiWelcome.js"></script>' );
		}
		return true;
	}
}
