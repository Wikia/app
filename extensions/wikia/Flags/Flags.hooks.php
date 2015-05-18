<?php

namespace Flags;

class Hooks {

	public static function onParserBeforeInternalParse( \Parser $parser, &$text, &$stripState ) {
		$mwf = \MagicWord::get( 'flags' );
		$isMagicWordMatch = $mwf->match( $text );
		if ( $isMagicWordMatch || !$parser->mFlagsParsed ) {
			$helper = new \FlagsHelper();
			$addText = $helper->getFlagsForPageWikitext( $parser->getTitle()->getArticleID() );
			if ( $addText !== null ) {
				if ( $isMagicWordMatch ) {
					$text = $mwf->replace( $addText, $text );
				} else {
					$text = $addText . $text;
				}
			}
			$parser->mFlagsParsed = true;
		}
		return true;
	}
}
