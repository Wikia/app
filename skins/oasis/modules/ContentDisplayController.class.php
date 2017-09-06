<?php
/**
 * Helper Functions: adds picture attribution info and replaces section edit links with pencil icon and link
 * Fixme: this is not really a proper module
 * @author Maciej Brencz
 */

class ContentDisplayController extends WikiaController {
	/**
	 * Show section edit link for anons (RT #79897)
	 * @param Parser $parser
	 * @param bool $showEditLink
	 * @return bool
	 */
	static function onShowEditLink( Parser $parser, bool &$showEditLink ): bool {
		global $wgUser;
		wfProfileIn(__METHOD__);

		if ($wgUser->isAnon() && $parser->mOptions->getEditSection()) {
			$showEditLink = true;
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Modify edit section link markup (for Oasis only)
	 * @param Skin $skin
	 * @param Title $title
	 * @param $section
	 * @param $tooltip
	 * @param $result
	 * @param bool $lang
	 * @return bool
	 */
	public static function onDoEditSectionLink( Skin $skin, Title $title, $section, $tooltip, &$result, $lang = false ): bool {
		global $wgBlankImgUrl;
		wfProfileIn(__METHOD__);

		// modify Oasis only (BugId:8444)
		if ( $skin->getSkinName() !== 'oasis' ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$result = ''; // reset result first

		$editUrl = $title->getLocalUrl( array( 'action' => 'edit', 'section' => $section ) );

		$class = 'editsection';

		$result .= Xml::openElement( 'span', array( 'class' => $class ) );
		$result .= Xml::openElement( 'a', array(
			'href' => $editUrl,
			'title' => wfMsg( 'oasis-section-edit-alt', $tooltip ),
		));
		$result .= Xml::element( 'img',	array(
			'src' => $wgBlankImgUrl,
			'class' => 'sprite edit-pencil',
		));
		$result .= wfMsg( 'oasis-section-edit' );
		$result .= Xml::closeElement( 'a' );
		$result .= Xml::closeElement( 'span' );

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Modify section headline markup (for Oasis only)
	 * @param Skin $skin
	 * @param $level
	 * @param $attribs
	 * @param $anchor
	 * @param $text
	 * @param $link
	 * @param $legacyAnchor
	 * @param $ret
	 * @return bool
	 */
	static public function onMakeHeadline( Skin $skin, $level, $attribs, $anchor, $text, $link, $legacyAnchor, &$ret ): bool {
		global $wgRTEParserEnabled;
		wfProfileIn(__METHOD__);

		// modify Oasis only (BugId:8444)
		if ( $skin->getSkinName() !== 'oasis' || !empty( $wgRTEParserEnabled ) ) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$ret = "<h$level$attribs"
			. "<span class=\"mw-headline\" id=\"$anchor\">$text</span>"
			. $link
			. "</h$level>";

		wfProfileOut(__METHOD__);
		return true;
	}

}
