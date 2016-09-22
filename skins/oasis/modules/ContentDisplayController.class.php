<?php

/**
 * Helper Functions: adds picture attribution info and replaces section edit links with pencil icon and link
 * Fixme: this is not really a proper module
 * @author Maciej Brencz
 */
class ContentDisplayController extends WikiaController {
	/**
	 * Show section edit link for anons (RT #79897)
	 */
	static function onShowEditLink( &$parser, &$showEditLink ) {
		global $wgUser;
		wfProfileIn( __METHOD__ );

		if ( $wgUser->isAnon() && $parser->mOptions->getEditSection() ) {
			$showEditLink = true;
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Modify edit section link markup (for Oasis only)
	 */
	public static function onDoEditSectionLink( $skin, Title $title, $section, $tooltip, &$result, $lang = false ) {
		global $wgBlankImgUrl, $wgUser;
		wfProfileIn( __METHOD__ );

		// modify Oasis only (BugId:8444)
		if ( !$skin instanceof SkinOasis ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$result = ''; // reset result first

		$editUrl = $title->getLocalURL( [ 'action' => 'edit', 'section' => $section ] );

		$class = 'editsection';

		$result .= Xml::openElement( 'span', [ 'class' => $class ] );
		$result .= Xml::openElement( 'a', [
			'href' => $editUrl,
			'title' => wfMessage( 'oasis-section-edit-alt', $tooltip )->text(),
		] );
		$result .= Xml::element( 'img', [
			'src' => $wgBlankImgUrl,
			'class' => 'sprite edit-pencil',
		] );
		$result .= wfMessage( 'oasis-section-edit' )->escaped();
		$result .= Xml::closeElement( 'a' );
		$result .= Xml::closeElement( 'span' );

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Modify section headline markup (for Oasis only)
	 */
	static public function onMakeHeadline( $skin, $level, $attribs, $anchor, $text, $link, $legacyAnchor, &$ret ) {
		global $wgRTEParserEnabled;
		wfProfileIn( __METHOD__ );

		// modify Oasis only (BugId:8444)
		if ( ( !$skin instanceof SkinOasis ) || !empty( $wgRTEParserEnabled ) ) {
			wfProfileOut( __METHOD__ );
			return true;
		}

		$ret = "<h$level$attribs"
			. "<span class=\"mw-headline\" id=\"$anchor\">$text</span>"
			. $link
			. "</h$level>";

		wfProfileOut( __METHOD__ );
		return true;
	}

}
