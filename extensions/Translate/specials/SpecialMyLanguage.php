<?php
/**
 * Contains logic for special page Special:MyLanguage
 *
 * @file
 * @author Niklas Laxström
 * @copyright Copyright © 2010 Niklas Laxström
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
	/**
	 * Construct
	 */
	public function __construct() {
		parent::__construct( 'MyLanguage' );
	}

	/**
	 * Execute method
	 */
	public function execute( $par ) {
		global $wgOut, $wgLang;

		$title = null;
		if ( strval( $par ) !== '' ) {
			$title = Title::newFromText( $par );
			if ( $title && $title->exists() ) {
				$local = Title::newFromText( "$par/" . $wgLang->getCode() );
				if ( $local && $local->exists() ) {
					$title = $local;
				}
			}
		}

		/**
		 * Go to the main page if given invalid title.
		 */
		if ( !$title ) {
			$title = Title::newMainPage();
		}

		$wgOut->redirect( $title->getLocalURL() );
	}
}
