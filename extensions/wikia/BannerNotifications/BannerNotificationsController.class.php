<?php
/**
 * Handles adding and rendering of confirmations (green stripe below global nav) and notifications (blue bubble boxes just above the fold)
 *
 * @author Maciej Brencz
 */

class BannerNotificationsController extends WikiaController {

	const SESSION_KEY = 'oasisConfirmation';

	// confirmation types
	const CONFIRMATION_CONFIRM = 'confirm'; // Green
	const CONFIRMATION_NOTIFY = 'notify'; // Blue
	const CONFIRMATION_ERROR = 'error'; // Red
	const CONFIRMATION_WARN = 'warn'; // Yellow

	// HTML of user messages notification (rendered by MW core -- skin variable)

	public function init() {
		$this->confirmation = null;
		$this->confirmationClass = null;
	}

	/**
	 * Add confirmation message to the user session (so it persists between redirects)
	 */
	public static function addConfirmation( $message, $type = self::CONFIRMATION_CONFIRM ) {
		wfProfileIn( __METHOD__ );

		if ( !empty( $message ) ) {
			$_SESSION[self::SESSION_KEY] = array(
				'message' => $message,
				'type' => $type,
			);

			wfDebug( __METHOD__ . " - {$message}\n" );
		}

		wfProfileOut( __METHOD__ );
	}

	/**
	 * Clear confirmation
	 */

	public static function clearConfirmation() {
		$_SESSION[self::SESSION_KEY] = null;
	}

	/**
	 * Show confirmation stored in user session
	 */
	public function executeConfirmation() {
		wfProfileIn( __METHOD__ );

		if ( !empty( $_SESSION[self::SESSION_KEY] ) ) {
			$entry = $_SESSION[self::SESSION_KEY];

			$this->confirmation = $entry['message'];
			$this->confirmationClass = $entry['type'];

			// clear confirmation stack
			unset( $_SESSION[self::SESSION_KEY] );

			wfDebug( __METHOD__ . " - {$this->confirmation}\n" );
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Handle confirmations from special preferences
	 */
	public static function addPreferencesConfirmation( &$prefs ) {
		global $wgRequest;
		wfProfileIn( __METHOD__ );

		if ( F::app()->checkSkin( 'oasis' ) ) {
			if ( $wgRequest->getCheck( 'success' ) ) {
				self::addConfirmation( wfMessage( 'savedprefs' )->escaped() );
			}
			else if ( $wgRequest->getCheck( 'eauth' ) ) {
				self::addConfirmation(
					wfMessage( 'eauthentsent' )->escaped(),
					self::CONFIRMATION_ERROR
				);
			}

			// clear the state, so that MW core doesn't render any message
			$wgRequest->setVal( 'eauth', null );
			$wgRequest->setVal( 'success', null );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Handle confirmations when the page is moved
	 *
	 * @param $ot Title
	 * @param $nt Title
	 */
	public static function addPageMovedConfirmation( &$form, &$ot, &$nt ) {
		wfProfileIn( __METHOD__ );
		global $wgOut;

		if ( F::app()->checkSkin( 'oasis' ) ) {
			$oldUrl = $ot->getFullUrl( 'redirect=no' );
			$newUrl = $nt->getFullUrl();
			$oldText = $ot->getPrefixedText();
			$newText = $nt->getPrefixedText();

			// don't render links
			$oldLink = $oldText;
			$newLink = $newText;

			self::addConfirmation(
				wfMessage(
					'movepage-moved',
					array('parseinline'),
					$oldLink,
					$newLink,
					$oldText,
					$newText
				)->inContentLanguage()->escaped()
			);

			// redirect to page with new title
			$wgOut->redirect( $newUrl );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Handle confirmations when page is deleted
	 *
	 * @param WikiPage $article
	 */
	public static function addPageDeletedConfirmation( &$article, &$user, $reason, $articleId ) {
		wfProfileIn( __METHOD__ );
		global $wgOut;

		if ( F::app()->checkSkin( 'oasis' ) ) {
			$title = $article->getTitle();
			// special handling of ArticleComments
			if ( class_exists( 'ArticleComment' ) &&
				MWNamespace::isTalk( $title->getNamespace() ) &&
				ArticleComment::isTitleComment( $title ) &&
				$title->getNamespace() != NS_USER_WALL
			) {
				self::addConfirmation(
					wfMessage( 'oasis-confirmation-comment-deleted' )->escaped()
				);

				wfProfileOut( __METHOD__ );
				return true;
			}

			$pageName = $title->getPrefixedText();

			$message = wfMessage(
				'oasis-confirmation-page-deleted',
				array( 'parseinline' ),
				$pageName
			)->inContentLanguage()->escaped();

			wfRunHooks( 'OasisAddPageDeletedConfirmationMessage', array( &$title, &$message ) );

			self::addConfirmation( $message );

			// redirect to main page
			$wgOut->redirect( Title::newMainPage()->getFullUrl( array( 'cb' => rand( 1, 1000 ) ) ) );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Handle confirmations when page is undeleted
	 *
	 * @param $title Title
	 */
	public static function addPageUndeletedConfirmation( $title, $create ) {
		wfProfileIn( __METHOD__ );
		global $wgOut;

		if ( F::app()->checkSkin( 'oasis' ) ) {
			self::addConfirmation(
				wfMessage( 'oasis-confirmation-page-undeleted' )->escaped()
			);

			// redirect to undeleted page
			$wgOut->redirect( $title->getFullUrl() );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Handle confirmations when user logs out
	 */
	public static function addLogOutConfirmation( &$user, &$injected_html, $oldName ) {
		wfProfileIn( __METHOD__ );
		global $wgOut, $wgRequest;

		if ( F::app()->checkSkin( 'oasis' ) || F::app()->checkSkin( 'venus' ) ) {

			self::addConfirmation(
				wfMessage( 'oasis-confirmation-user-logout' )->escaped()
			);

			// redirect the page user has been on when he clicked "log out" link
			$mReturnTo = $wgRequest->getVal( 'returnto' );
			$mReturnToQuery = $wgRequest->getVal( 'returntoquery' );

			$title = Title::newFromText( $mReturnTo );
			if ( !empty( $title ) ) {
				$mResolvedReturnTo = strtolower(
					array_shift( SpecialPageFactory::resolveAlias( $title->getDBKey() ) )
				);
				if ( in_array( $mResolvedReturnTo,
					array( 'userlogout','signup','connect' ) )
				) {
					$title = Title::newMainPage();
					$mReturnToQuery = '';
				}

				$redirectUrl = $title->getFullUrl( $mReturnToQuery );
				$wgOut->redirect( $redirectUrl );

				wfDebug( __METHOD__ . " - {$redirectUrl}\n" );
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Handle confirmations about edit being saved
	 */
	public static function addSaveConfirmation( $editPage, $code ) {
		global $wgUser;
		wfProfileIn( __METHOD__ );

		// as for now only add it for logged-in (BugId:1317)
		if ( F::app()->checkSkin( 'oasis' ) && $wgUser->isLoggedIn() ) {
			self::addConfirmation( wfMessage( 'oasis-edit-saved' )->escaped() );
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Adds assets for BannerNotifications on the bottom of the body on Monobook
	 *
	 * @param {String} $skin
	 * @param {String} $text
	 *
	 * @return true
	 */
	public static function onSkinAfterBottomScripts( $skin, &$text ) {

		if ( F::app()->checkSkin( 'monobook', $skin ) ) {
			$styles = AssetsManager::getInstance()->getURL( 'banner_notifications_scss' );

			foreach ( $styles as $style ) {
				$text .= Html::linkedStyle( $style );
			}
		}

		return true;
	}

	/**
	 * Add JS message to the ResourceLoader output
	 * @param \OutputPage $out
	 * @return bool
	 */
	public static function onBeforePageDisplay( \OutputPage $out ) {
		$out->addModules( 'ext.bannerNotifications' );
		return true;
	}
}
