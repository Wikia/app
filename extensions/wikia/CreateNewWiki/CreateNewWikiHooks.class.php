<?php
class CreateNewWikiHooks {
	public static function onBeforePageDisplay() {
		global $wgOut, $wgRequest;

		$wg = F::app()->wg;

		$wikiWelcome = $wgRequest->getVal('wiki-welcome');
		$assetsManager = F::build( 'AssetsManager', array(), 'getInstance' );

		if(!empty($wikiWelcome)) {
			$wgOut->addStyle( $assetsManager->getSassCommonURL( 'extensions/wikia/CreateNewWiki/css/WikiWelcome.scss' ) );
			$wgOut->addScript( '<script src="' . $wg->ExtensionsPath . '/wikia/CreateNewWiki/js/WikiWelcome.js"></script>' );
		}
		return true;
	}
}
