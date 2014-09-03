<?php

class NjordHooks {
	public static $templateDir;

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( 'hero', 'NjordHooks::renderHeroTag' );
		return true;
	}

	public static function renderHeroTag( $content, array $attributes, Parser $parser, PPFrame $frame ) {
		$njordModel = new NjordModel();
		$wikiData = new WikiDataModel( Title::newMainPage()->getText() );
		$wikiData->setFromAttributes( $attributes );
		$wikiData->storeInProps();

		return ( new \Wikia\Template\PHPEngine() )
			->setData( [ 'wikiData' => $wikiData ] )
			->render( static::$templateDir . '/mainpage.php' );
	}
}
