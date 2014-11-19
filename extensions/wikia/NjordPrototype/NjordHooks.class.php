<?php

class NjordHooks {
	public static $templateDir;

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( 'hero', 'NjordHooks::renderHeroTag' );
		$parser->setHook( 'modula', 'NjordHooks::renderModuleContainerTag' );
		return true;
	}

	public static function onCreateNewWikiComplete( $params ) {
		if ( !empty( $params['city_id'] ) ) {
			WikiFactory::setVarByName( 'wgEnableNjordExt', $params['city_id'], true );
		}
		return true;
	}

	public static function onGetFeatureLabs( ) {
		global $wgContLang, $wgWikiFeatures;

		if ( $wgContLang->getCode() == 'en' ) {
			$wgWikiFeatures['labs'] [] = 'wgEnableNjordExt';
		}

		return true;
	}

	public static function renderHeroTag( $content, array $attributes, Parser $parser, PPFrame $frame ) {
		$wikiData = new WikiDataModel( Title::newMainPage()->getText() );
		$wikiData->setFromAttributes( $attributes );
		$wikiData->storeInProps();
		return '';
	}

	public static function renderModuleContainerTag( $content, array $attributes, Parser $parser, PPFrame $frame ) {
		if ( !empty( $attributes['content-title'] ) ) {
			$title = Title::newFromText( $attributes['content-title'] );
			if ( $title->exists() ) {
				$article = Article::newFromTitle( $title, RequestContext::getMain() );
				$attributes['content'] = $parser->recursiveTagParse( $article->getContent() );
			}
		}
		return F::app()->renderView( 'Njord', 'modula', $attributes );
	}
}
