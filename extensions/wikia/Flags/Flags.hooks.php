<?php

namespace Flags;

use Flags\Helper;

class Hooks {

	/**
	 * Hooks into the internalParse() process and injects a wikitext
	 * with notices for the given page.
	 * @param \Parser $parser
	 * @param string $text
	 * @param \StripState $stripState
	 * @return bool
	 */
	public static function onParserBeforeInternalParse( \Parser $parser, &$text, &$stripState ) {
		global $wgRequest;

		/**
		 * Don't check for flags if:
		 * - you've already checked
		 * - a user is on an edit page
		 * - the request is from VE
		 */
		$helper = new Helper();
		if ( !$parser->mFlagsParsed
			&& $helper->shouldDisplayFlags()
			&& !( $wgRequest->getVal( 'action' ) == 'visualeditor' )
		) {
			$addText = $helper->getFlagsForPageWikitext( $parser->getTitle()->getArticleID() );

			if ( $addText !== null ) {
				$mwf = \MagicWord::get( 'flags' );
				if ( $mwf->match( $text ) ) {
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
