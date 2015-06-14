<?php
/**
 * Handles adding and rendering of confirmations (green stripe below global nav)
 *
 * @author Maciej Brencz
 */

class BannerNotificationsController extends WikiaController {

	const SESSION_KEY = 'bannerConfirmation';

	// confirmation types
	const CONFIRMATION_CONFIRM = 'confirm'; // Green
	const CONFIRMATION_NOTIFY = 'notify'; // Blue
	const CONFIRMATION_ERROR = 'error'; // Red
	const CONFIRMATION_WARN = 'warn'; // Yellow


	public function init() {
		$this->confirmation = null;
		$this->confirmationClass = null;
	}

	/**
	 * @desc Add confirmation message to the user session (so it persists between redirects)
	 *
	 * @param String $message - message text
	 * @param String $type - notification type, one of CONFIRMATION_ constants
	 * @param Bool $force - flag that enforces to override existing notification
	 */
	public static function addConfirmation( $message, $type = self::CONFIRMATION_CONFIRM, $force = false ) {
		//Add confirmation if there was none set yet or if it's forced
		if ( !empty( $message ) &&
			( empty( $_SESSION[self::SESSION_KEY] ) || $force === true ) ) {
			$_SESSION[self::SESSION_KEY] = array(
				'message' => $message,
				'type' => $type,
			);

			wfDebug( __METHOD__ . " - {$message}\n" );
		}
	}

	/**
	 * Clear confirmation
	 */

	public static function clearConfirmation() {
		unset( $_SESSION[self::SESSION_KEY] );
	}

	/**
	 * Show confirmation stored in user session
	 */
	public function executeConfirmation() {
		if ( !empty( $_SESSION[self::SESSION_KEY] ) ) {
			$entry = $_SESSION[self::SESSION_KEY];

			$this->confirmation = $entry['message'];
			$this->confirmationClass = $entry['type'];

			// clear confirmation stack
			self::clearConfirmation();

			wfDebug( __METHOD__ . " - {$this->confirmation}\n" );
		}

	}

	/**
	 * Handle confirmations from special preferences
	 */
	public static function addPreferencesConfirmation( &$prefs ) {
		global $wgRequest;

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

		return true;
	}

	/**
	 * Handle confirmations when the page is moved
	 *
	 * @param $ot Title
	 * @param $nt Title
	 */
	public static function addPageMovedConfirmation( &$form, &$ot, &$nt ) {
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
					$oldLink,
					$newLink,
					$oldText,
					$newText
				)->inContentLanguage()->parse()
			);

			// redirect to page with new title
			$wgOut->redirect( $newUrl );
		}

		return true;
	}

	/**
	 * Handle confirmations when page is deleted
	 *
	 * @param WikiPage $article
	 */
	public static function addPageDeletedConfirmation( &$article, &$user, $reason, $articleId ) {
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

				return true;
			}

			$pageName = $title->getPrefixedText();

			$message = wfMessage(
				'oasis-confirmation-page-deleted',
				$pageName
			)->inContentLanguage()->parse();

			wfRunHooks( 'OasisAddPageDeletedConfirmationMessage', array( &$title, &$message ) );

			self::addConfirmation( $message, self::CONFIRMATION_CONFIRM, true );

			// redirect to main page
			$wgOut->redirect( Title::newMainPage()->getFullUrl( array( 'cb' => rand( 1, 1000 ) ) ) );
		}

		return true;
	}

	/**
	 * Handle confirmations when page is undeleted
	 *
	 * @param $title Title
	 */
	public static function addPageUndeletedConfirmation( $title, $create ) {
		global $wgOut;

		if ( F::app()->checkSkin( 'oasis' ) ) {
			self::addConfirmation(
				wfMessage( 'oasis-confirmation-page-undeleted' )->escaped()
			);

			// redirect to undeleted page
			$wgOut->redirect( $title->getFullUrl() );
		}

		return true;
	}

	/**
	 * Handle confirmations when user logs out
	 */
	public static function addLogOutConfirmation( &$user, &$injected_html, $oldName ) {
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

		return true;
	}

	/**
	 * Handle confirmations about edit being saved
	 */
	public static function addSaveConfirmation( $editPage, $code ) {
		global $wgUser;

		// as for now only add it for logged-in (BugId:1317)
		if ( F::app()->checkSkin( 'oasis' ) && $wgUser->isLoggedIn() ) {
			self::addConfirmation( wfMessage( 'oasis-edit-saved' )->escaped() );
		}

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
