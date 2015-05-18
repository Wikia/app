<?php

namespace Flags;

class Hooks {

	/**
	 * Hooks into the internalParse() process and injects a wikitext
	 * with notices for the given page.
	 * @param \Parser $parser
	 * @param $text
	 * @param $stripState
	 * @return bool
	 */
	public static function onParserBeforeInternalParse( \Parser $parser, &$text, &$stripState ) {
		global $wgRequest;

		/**
		 * Don't check for flags if:
		 * - a user is on an edit page
		 * - the request is from VE
		 */
		if ( !\WikiaPageType::isEditPage() && !( $wgRequest->getVal( 'action' ) == 'visualeditor' ) ) {
			$mwf = \MagicWord::get('flags');
			$isMagicWordMatch = $mwf->match( $text );

			if ( $isMagicWordMatch || ! $parser->mFlagsParsed ) {
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
		}

		return true;
	}
}
