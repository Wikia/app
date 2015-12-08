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

	const OPTION_NON_DISMISSIBLE = 'nonDismissible';


	public function init() {
		$this->confirmation = null;
		$this->confirmationClass = null;
	}

	/**
	 * @desc Add confirmation message to the user session (so it persists between redirects)
	 *
	 * @param String $message - message text
	 * @param String $type - notification type, one of CONFIRMATION_ constants
	 * @param Array $options
	 * 	self::OPTION_NON_DISMISSIBLE - removes close button from notification
	 */
	public static function addConfirmation( $message, $type = self::CONFIRMATION_CONFIRM, $options = [] ) {
		//Add confirmation if there was none set yet or if it's forced
		if ( !empty( $message ) ) {
			if ( !isset( $_SESSION[self::SESSION_KEY] ) ) {
				$_SESSION[self::SESSION_KEY] = [];
			}

			// Making sure if the message is not already set in the session.
			// We're checking only the message text and not other message parameters,
			// because the text is the most important here.
			if ( in_array( $message, array_column( $_SESSION[self::SESSION_KEY], 'message' ) ) ) {
				\Wikia\Logger\WikiaLogger::instance()
					->debug( __METHOD__ . " - {$message}\n - already in the _SESSION array" );
				return;
			}

			$_SESSION[self::SESSION_KEY][] = [
				'message' => $message,
				'type' => $type,
				'options' => $options
			];

			\Wikia\Logger\WikiaLogger::instance()->debug( __METHOD__ . " - {$message}\n" );
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
			$notifications = [];

			foreach( $_SESSION[self::SESSION_KEY] as $sessionEntities ) {
				$notification = [
					'message' => $sessionEntities['message'],
					'class' => $sessionEntities['type']
				];

				if ( !empty( $sessionEntities['options'][self::OPTION_NON_DISMISSIBLE] ) ) {
					$notification['class'] .= ' non-dismissible';
				}

				$notifications[] = $notification;
			}

			$this->notifications = $notifications;

			// clear confirmation stack
			self::clearConfirmation();
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

			self::addConfirmation( $message, self::CONFIRMATION_CONFIRM );

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

		if ( F::app()->checkSkin( 'oasis' ) ) {

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
		global $wgUser;

		if ( $wgUser->isLoggedIn() ) {
			$message = null;

			if ( empty($wgUser->getEmail() ) && empty( $wgUser->getNewEmail() ) ) {
				$message = wfMessage( 'bannernotifications-no-email' )->parse();
			} elseif ( !$wgUser->isEmailConfirmed() ) {
				$message = wfMessage( 'bannernotifications-not-confirmed-email' )->parse();
			}

			if ( !empty( $message ) ) {
				self::addConfirmation(
					$message,
					self::CONFIRMATION_WARN,
					[ self::OPTION_NON_DISMISSIBLE => true ]
				);
			}
		}

		$out->addModules( 'ext.bannerNotifications' );
		return true;
	}
}
