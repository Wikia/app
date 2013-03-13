<?php
class CreateNewWikiHooks {
	public static function onBeforePageDisplay() {
		$wg = F::app()->wg;

		$wikiWelcome = $wg->request->getVal('wiki-welcome');
		$assetsManager = F::build( 'AssetsManager', array(), 'getInstance' );

		if(!empty($wikiWelcome)) {
			$wg->out->addStyle( $assetsManager->getSassCommonURL( 'extensions/wikia/CreateNewWiki/css/WikiWelcome.scss' ) );
			$wg->out->addScript( '<script src="' . $wg->ExtensionsPath . '/wikia/CreateNewWiki/js/WikiWelcome.js"></script>' );
		}
		return true;
	}
}
