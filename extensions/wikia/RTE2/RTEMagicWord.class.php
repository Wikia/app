<?php

/**
 * Handling of __NOWYSIWYG__ magic word
 */

class RTEMagicWord {

	/**
	 * Register __NOWYSIWYG__ magic word
	 */
	public static function register(&$magicWords) {
		$magicWords[] = 'MAG_NOWYSIWYG';
		return true;
	}

	public static function get(&$magicWords, $langCode) {
		$magicWords['MAG_NOWYSIWYG'] = array(0, '__NOWYSIWYG__');
		return true;
	}

	public static function remove(&$parser, &$text, &$strip_state) {
		MagicWord::get('MAG_NOWYSIWYG')->matchAndRemove($text);
		return true;
	}

	/**
	 * Check wikitext before being parser by parser (and add edgecase if needed)
	 */
	public static function checkParserBeforeStrip($parser, $text, $stripState) {
		wfProfileIn(__METHOD__);

		// only perform check when parsing for RTE
		global $wgRTEParserEnabled;
		if (empty($wgRTEParserEnabled)) {
			wfProfileOut(__METHOD__);
			return true;
		}

		if (self::searchForMagicWord($text)) {
			RTE::log('__NOWYSIWYG__ found in parsed wikitext');
			RTE::edgeCasesPush('NOWYSIWYG');
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Check for __NOWYSIWYG__ magic word inside whole article when doing section edit (and add edgecase if needed)
	 */
	public static function checkEditPageContent($editPage, $t) {
		wfProfileIn(__METHOD__);

		// only perform when doing section edit
		if (is_numeric($editPage->section)) {
			RTE::log('section edit');

			// get WHOLE article content (RT #17005)
			$text = $editPage->mArticle->getContent();

			if (self::searchForMagicWord($text)) {
				RTE::log('__NOWYSIWYG__ found in text of whole article');
				RTE::edgeCasesPush('NOWYSIWYG');
			}
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Check for __NOWYSIWYG__ magic word inside transcluded templates (RT #24167) -  and add edgecase if needed
	 *
	 * Note: hook Parser::FetchTemplateAndTitle is not called when doing RTE parsing
	 */
	public static function fetchTemplate($text, $finalTitle) {
		wfProfileIn(__METHOD__);

		RTE::log(__METHOD__, $finalTitle);

		if (self::searchForMagicWord($text)) {
			RTE::log('__NOWYSIWYG__ found inside ' . $finalTitle);
			RTE::edgeCasesPush('NOWYSIWYG');
		}

		wfProfileOut(__METHOD__);

		return true;
	}

	/**
	 * Helper method to find __NOWYSIWYG__ magic word in wikitext provided
	 */
	private static function searchForMagicWord($text) {
		wfProfileIn(__METHOD__);

		$ret = false;

		$mw = MagicWord::get('MAG_NOWYSIWYG');

		if ($mw->match($text)) {
			$matches = array();
			$countNoWysiwygAll = preg_match_all($mw->getRegex(), $text, $matches);
			$countNoWysiwygInNoWiki = preg_match_all('/\<nowiki\>__NOWYSIWYG__\<\/nowiki\>/si', $text, $matches);

			//RTE::log("__NOWYSIWYG__ (count: {$countNoWysiwygAll} / in <nowiki>: {$countNoWysiwygInNoWiki})");

			if ($countNoWysiwygAll > $countNoWysiwygInNoWiki) {
				$ret = true;
			}
		}

		wfProfileOut(__METHOD__);

		return $ret;
	}
}
