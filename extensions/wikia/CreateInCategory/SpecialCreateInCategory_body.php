<?php
/**
 * CreateInCategory
 *
 * This extension is used by Wikia Staff to manage essential user account information
 * in the case of a lost password and/or invalid e-mail submitted during registration.
 *
 * @file
 * @ingroup Extensions
 * @author Łukasz Garczewski (TOR) <tor@wikia-inc.com>
 * @date 2008-09-17
 * @copyright Copyright © 2008 Łukasz Garczewski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo "This is a MediaWiki extension named CreateInCategory.\n";
	exit( 1 );
}

class CreateInCategory extends SpecialPage {
	var $mUser = null;
	var $mStatus = null;
	var $mStatusMsg;

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'CreateInCategory'/*class*/ );
//		wfLoadExtensionMessages( 'CreateInCategory' ); // Load internationalization messages
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	public function execute( $par ) {
		global $wgOut, $wgUser, $wgRequest;

		// Set page title and other stuff
		$this->setHeaders();

		# Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		# If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		$title = $wgRequest->getVal( 'wpTitle' );
		$category = $wgRequest->getVal( 'wpCategory' );

		if ( empty( $title ) || empty( $category ) ) {
			return;
		}

		$oTitle = Title::newFromText( $title );
		if ( !is_object( $oTitle ) ) {
			return;
		}

		$oArticle = new Article( $oTitle );

		if ( $oTitle->exists() ) {
			$text = $oArticle->getContent();
		} else {
			$text = self::getCreateplate( $category );
		}

		$text .= "\n[[Category:" . $category . ']]';

		$oArticle->doEdit( $text, wfMsgForContent( 'createincategory-comment', $category ) );

		$wgOut->redirect( $oTitle->getFullUrl() );

	}

	static function getCreateplate( $category ) {
		global $wgEnableAnswers;

		if ( !empty( $wgEnableAnswers ) ) {
			return Answers::getUnansweredCategory();
		}

		$categoryKey = 'newpagelayout-' . $category;
		$categoryCreateplate = wfMsgForContent( $categoryKey );
		if ( !wfEmptyMsg( $categoryKey, $categoryCreateplate ) ) {
			return $categoryCreateplate;
		}

		return wfMsgForContent( 'newpagelayout' );
	}
}
