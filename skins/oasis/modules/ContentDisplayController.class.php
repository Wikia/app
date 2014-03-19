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
	static function onShowEditLink(&$parser, &$showEditLink) {
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
	 */
	public static function onDoEditSectionLink( $skin, Title $title, $section, $tooltip, &$result, $lang = false ) {
		global $wgBlankImgUrl, $wgUser, $wgEnableEditorPreferenceExt;
		wfProfileIn(__METHOD__);

		// modify Oasis only (BugId:8444)
		if (!$skin instanceof SkinOasis) {
			wfProfileOut(__METHOD__);
			return true;
		}

		$result = ''; // reset result first

		$params = array( 'action' => 'edit', 'section' => $section );
		if ( $wgEnableEditorPreferenceExt && EditorPreference::getPrimaryEditor() === EditorPreference::OPTION_EDITOR_SOURCE ) {
			$params['useeditor'] = 'source';
		}
		$editUrl = $title->getLocalUrl( $params );

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
	 */
	static public function onMakeHeadline( $skin, $level, $attribs, $anchor, $text, $link, $legacyAnchor, &$ret ) {
		global $wgRTEParserEnabled;
		wfProfileIn(__METHOD__);

		// modify Oasis only (BugId:8444)
		if ((!$skin instanceof SkinOasis) || !empty($wgRTEParserEnabled)) {
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
