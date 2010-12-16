<?php
/*
* Implement test wiki preference, magic word and prefix check on edit page
*/

class IncubatorTest
{
	static function onGetPreferences( $user, &$preferences ) {
		global $wmincPref, $wmincPrefProject, $wmincPrefNone, $wgDefaultUserOptions;

		$preferences['language']['help-message'] = 'wminc-prefinfo-language';

		$prefinsert[$wmincPref . '-project'] = array(
			'type' => 'select',
			'options' => array(	wfMsg( 'wminc-testwiki-none' ) => 'none',		'wikipedia' => 'p',		'wikibooks' => 'b',
			'wiktionary' => 't',	'wikiquote' => 'q',	'wikinews' => 'n',		'incubator' => 'inc' ),
			'section' => 'personal/i18n',
			'label-message' => 'wminc-testwiki',
			'id' => $wmincPref . '-project',
			'help-message' => 'wminc-prefinfo-project',
		);
		$prefinsert[$wmincPref . '-code'] = array(
			'type' => 'text',
			'section' => 'personal/i18n',
			'label-message' => 'wminc-testwiki',
			'id' => $wmincPref . '-code',
			'maxlength' => 3,
			'size' => 3,
			'help-message' => 'wminc-prefinfo-code',
			'validation-callback' => array( 'IncubatorTest', 'CodeValidation' ),
		);

		$wgDefaultUserOptions[$wmincPref . '-project'] = 'none';

		$preferences = wfArrayInsertAfter( $preferences, $prefinsert, 'language' );

		return true;
	}

	function codeValidation( $input, $alldata ) {
		global $wmincPref;
		// If the user selected a project that NEEDS a language code, but the user DID NOT enter a language code, give an error
		if ( !in_array( $alldata[$wmincPref . '-project'], array( '', 'none', 'inc' ) ) && !$input ) {
			return Xml::element( 'span', array( 'class' => 'error' ), wfMsg( 'wminc-prefinfo-error' ) );
		} else {
			return true;
		}
	}

	function isNormalPrefix() {
		global $wgUser, $wmincPref;
		if ( in_array( $wgUser->getOption($wmincPref . '-project'), array( '', 'none', 'inc' ) ) ) {
			return false; // false because this is NOT a normal prefix
		} else {
			return true; // true because this is a normal prefix
		}
	}
	function displayPrefix() {
		// display the prefix of the user preference
		global $wgUser, $wmincPref;
		if ( self::isNormalPrefix() == true ) {
			return 'W' . $wgUser->getOption($wmincPref . '-project') . '/' . $wgUser->getOption($wmincPref . '-code'); // return the prefix
		} else {
			return $wgUser->getOption($wmincPref . '-project'); // still provide the value
		}
	}

	function displayPrefixedTitle( $title, $namespace = '' ) {
		global $wgUser, $wmincPref;
		$out = '';
		if ( self::isNormalPrefix() ) {
			if ( $namespace ) { $out .= $namespace . ':'; }
			$out .= self::displayPrefix() . '/' . $title;
		} else {
			$out .= self::displayPrefix();
		}
		return $out;
	}

	function magicWordVariable( &$magicWords ) {
		$magicWords[] = 'usertestwiki';
		return true;
	}

	function magicWord( &$magicWords, $langCode ) {
		$magicWords['usertestwiki'] = array( 0, 'USERTESTWIKI' );
		return true;
	}

	function magicWordValue( &$parser, &$cache, &$magicWordId, &$ret ) {
		if( !self::displayPrefix() ) {
			$ret = 'none';
		} else {
			$ret = self::displayPrefix();
		}
		return true;
	}

	function editPageCheckPrefix( $editpage ) {
		// If user has "project" as test wiki preference, it isn't needed to check
		if ( self::displayPrefix() == 'inc' ) {
			return true;
		}
		global $wgTitle;
		$namespaces = array( NS_MAIN, NS_TALK, NS_TEMPLATE, NS_TEMPLATE_TALK, NS_CATEGORY, NS_CATEGORY_TALK );
		// If it is in one of the above namespace, check if the page title has a prefix
		if ( in_array( $wgTitle->getNamespace(), $namespaces ) && !preg_match( '/W[bnpqt]\/[a-z][a-z][a-z]?/', $wgTitle->getText() ) ) {
			global $wgOut;
			wfLoadExtensionMessages( 'WikimediaIncubator' );
				$warning = '<div id="wminc-warning"><span id="wm-warning-unprefixed">'
					. wfMsg( 'wminc-warning-unprefixed' )
					. '</span>';
				// If the user has a test wiki pref, suggest a page title with prefix
				if ( self::isNormalPrefix() ) {
					global $wgUser;
					$suggest = self::displayPrefixedTitle( $wgTitle->getText(), $wgTitle->getNsText() );
					if ( !$wgTitle->exists() ) { // Creating a page, so suggest to create a prefixed page
					$warning .= ' <span id="wminc-warning-suggest">'
						. wfMsg( 'wminc-warning-suggest', $suggest )
						. '</span>';
					} elseif ( $wgUser->isAllowed( 'move' ) ) { // Page exists, so suggest to move
					$warning .= ' <span id="wminc-warning-suggest-move" class="plainlinks">'
						. wfMsg( 'wminc-warning-suggest-move', $suggest, urlencode( $suggest ), urlencode( $wgTitle ) )
						. '</span>';
					}
				}
				$warning .= '</div>';
			$wgOut->addWikiText( $warning );
		}
		return true;
	}
}

/**
 * Add a link to Special:ViewUserLang from Special:Contributions/USERNAME
 * if the user has 'viewuserlang' permission
  * Based on code from extension LookupUser made by Tim Starling
 * @return true
 */
function efLoadViewUserLangLink( $id, $nt, &$links ) {
	global $wgUser;
	if ( $wgUser->isAllowed( 'viewuserlang' ) ) {
		wfLoadExtensionMessages( 'WikimediaIncubator' );
		$links[] = $wgUser->getSkin()->makeKnownLinkObj(
					SpecialPage::getTitleFor( 'ViewUserLang' ),
					wfMsgHtml( 'wminc-viewuserlang' ),
					'&target=' . urlencode( $nt->getText() ) );
	}
	return true;
}
