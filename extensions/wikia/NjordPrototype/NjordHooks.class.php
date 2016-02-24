<?php

class NjordHooks {
	public static $templateDir;

	public static function onParserFirstCallInit( Parser $parser ) {
		$parser->setHook( 'hero', 'NjordHooks::renderHeroTag' );
		$parser->setHook( 'modula', 'NjordHooks::renderModuleContainerTag' );
		return true;
	}

	/**
	 * Removes Hero Module from WikiLabs if it is disabled (allows for opt-out only)
	 * @return bool
	 */
	public static function onGetFeatureLabs( ) {
		global $wgWikiFeatures, $wgEnableNjordExt;

		if ( empty( $wgEnableNjordExt ) ) {
			$wgWikiFeatures['labs'] = array_diff( $wgWikiFeatures['labs'], [ 'wgEnableNjordExt' ] );
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
		if ( !empty( $attributes[ 'content-title' ] ) ) {
			$title = Title::newFromText( $attributes[ 'content-title' ] );
			if ( $title->exists() ) {
				$article = Article::newFromTitle( $title, RequestContext::getMain() );
				$attributes[ 'content' ] = $parser->recursiveTagParse( $article->getContent() );
			}
		}
		return F::app()->renderView( 'Njord', 'modula', $attributes );
	}

	public static function onSkinAfterBottomScripts( $skin, &$text ) {
		if ( WikiaPageType::isMainPage() ) {
			$scripts = AssetsManager::getInstance()->getURL( 'njord_js' );

			foreach ( $scripts as $script ) {
				$text .= Html::linkedScript( $script );
			}
		}
		return true;
	}

	static public function purgeMainPage( $args ) {
		if ( $args['name'] === 'wgEnableNjordExt' ) {
			Article::newFromTitle( Title::newFromText( self::MAINPAGE_PAGE ), RequestContext::getMain() )->doPurge();
		}

		return true;
	}
}
