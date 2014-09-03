<?php

class NjordHooks {
	public static $templateDir;

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( 'hero', 'NjordHooks::renderHeroTag' );
		return true;
	}

	public static function renderHeroTag( $content, array $attributes, Parser $parser, PPFrame $frame ) {
		$wikiData = new WikiDataModel( Title::newMainPage()->getText() );
		$wikiData->setFromAttributes( $attributes );
		$wikiData->storeInProps();
		return '';
	}
}
