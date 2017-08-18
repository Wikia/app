<?php

class FacebookTagsHooks {
	/**
	 * Hook: ParserFirstCallInit
	 * Register preprocessor for XFBML widgets in wikitext
	 *
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/ParserFirstCallInit
	 * @param Parser $parser
	 */
	public static function onParserFirstCallInit( Parser $parser ) {
		foreach ( FacebookTagConstants::SUPPORTED_TAGS as $parserTagName ) {
			$colonPosition = strpos( $parserTagName, ':' );
			$htmlTagName = substr( $parserTagName, $colonPosition + 1 );

			$parser->setHook( $parserTagName, new FacebookTagParser( $htmlTagName ) );
		}
	}

	/**
	 * Hook: BeforePageDisplay
	 * Register JS module which will parse any Facebook widgets on article pages.
	 * Ideally this module would be added on-demand while parsing XFBML tags,
	 * but we also have to support HTML widgets added by users.
	 *
	 * @see https://www.mediawiki.org/wiki/Manual:Hooks/BeforePageDisplay
	 * @param OutputPage $out
	 * @param Skin $skin
	 */
	public static function onBeforePageDisplay( OutputPage $out, Skin $skin ) {
		// We don't want to load this on special pages etc. where such widgets won't be present
		if ( $out->isArticle() ) {
			$out->addModules( 'ext.wikia.facebookTags' );
		}
	}
}
