<?php
/**
 * Contains logic for special page Special:MyLanguage
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2010-2011 Niklas Laxström
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

/**
 * Unlisted special page just to redirect the user to the translated version of
 * a page, if it exists.
 *
 * Usage: [[Special:MyLanguage/Page name|link text]]
 *
 * @ingroup SpecialPage TranslateSpecialPage
 */
class SpecialMyLanguage extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct( 'MyLanguage' );
	}

	/// Only takes arguments from $par
	public function execute( $par ) {
		global $wgOut;

		$title = $this->findTitle( $par );
		// Go to the main page if given invalid title.
		if ( !$title ) {
			$title = Title::newMainPage();
		}

		$wgOut->redirect( $title->getLocalURL() );
	}

	/**
	 * Assuming the user's interface language is fi
	 * Given input Page, it returns Page/fi if it exists, otherwise Page
	 * Given input Page/de, it returns Page/fi if it exists, otherwise Page/de if it exists, otherwise Page
	 * @return Title|null
	 */
	protected function findTitle( $par ) {
		global $wgLang, $wgLanguageCode;
		// base = title without language code suffix
		// provided = the title as it was given
		$base = $provided = Title::newFromText( $par );

		if ( strpos( $par, '/' ) !== false ) {
			$pos = strrpos( $par, '/' );
			$basepage = substr( $par, 0, $pos );
			$code = substr( $par, $pos + 1 );
			$codes = Language::getLanguageNames( false );
			if ( isset( $codes[$code] ) ) {
				$base = Title::newFromText( $basepage );
			}
		}

		if ( !$base ) {
			return null;
		}

		$uiCode = $wgLang->getCode();
		$proposed = Title::newFromText( $base->getPrefixedText() . "/$uiCode" );
		if ( $uiCode !== $wgLanguageCode && $proposed && $proposed->exists() ) {
			return $proposed;
		} elseif ( $provided && $provided->exists() ) {
			return $provided;
		} else {
			return $base;
		}
	}

	/**
	 * Make Special:MyLanguage links red if the target page doesn't exists.
	 * A bit hacky because the core code is not so flexible.
	 * @param $dummy
	 * @param $target Title
	 * @param $html
	 * @param $customAttribs
	 * @param $query
	 * @param $options
	 * @param $ret
	 * @return bool
	 */
	public static function linkfix( $dummy, $target, &$html, &$customAttribs, &$query, &$options, &$ret ) {
		if ( $target->getNamespace() == NS_SPECIAL ) {
			list( $name, $subpage ) = SpecialPageFactory::resolveAlias( $target->getDBkey() );
			if ( $name === 'MyLanguage' ) {
				$realTarget = Title::newFromText( $subpage );
				if ( !$realTarget || !$realTarget->exists() ) {
					$options[] = 'broken';
					$index = array_search( 'known', $options, true );
					if ( $index !== false ) unset( $options[$index] );

					$index = array_search( 'noclasses', $options, true );
					if ( $index !== false ) unset( $options[$index] );
				}
			}
		}
		return true;
	}
}
