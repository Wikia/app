<?php
/**
 * Handles adding and rendering of confirmations (green stripe below global nav) and notifications (blue bubble boxes just above the fold)
 *
 * @author Maciej Brencz
 */

class NotificationsController extends WikiaController {

	const SESSION_KEY = 'oasisConfirmation';

	// confirmation types
	const CONFIRMATION_CONFIRM = 1; // Green
	const CONFIRMATION_NOTIFY = 2; // Blue
	const CONFIRMATION_ERROR = 3; // Red
	const CONFIRMATION_WARN = 4; // Yellow

	// notification types
	const NOTIFICATION_GENERIC_MESSAGE = 0;
	const NOTIFICATION_TALK_PAGE_MESSAGE = 1;
	const NOTIFICATION_COMMUNITY_MESSAGE = 2;
	const NOTIFICATION_NEW_ACHIEVEMENTS_BADGE = 3;
	const NOTIFICATION_EDIT_SIMILAR = 4;
	const NOTIFICATION_SITEWIDE = 5;

	const NOTIFICATION_CUSTOM = 10;

	// stack for notifications
	static private $notificationsStack;

	// HTML of user messages notification (rendered by MW core -- skin variable)

	public function init() {
		$this->notifications = null;
		$this->confirmation = null;
		$this->confirmationClass = null;
		$this->usernewmessages = $this->app->getSkinTemplateObj()->data['usernewmessages'];
	}
	/**
	 * Add notification message to the stack
	 */
	public static function addNotification($message, $data = array(), $type = 0) {
		wfProfileIn(__METHOD__);

		self::$notificationsStack[] = array(
			'message' => $message,
			'data' => $data,
			'type' => $type,
		);

		wfDebug(__METHOD__ . " - {$message}\n");
		wfProfileOut(__METHOD__);
	}

	/**
	 * Remove all notifications queued for display
	 */
	public static function clearNotifications() {
		self::$notificationsStack = array();
	}

	/**
	 * Show notifications
	 */
	public function executeIndex() {
		wfProfileIn(__METHOD__);

		// add testing notification
		/*
		self::addNotification('test test test test test test test test test test test test test test test test test test test test');
		self::addNotification('new talk page', array(), self::NOTIFICATION_TALK_PAGE_MESSAGE);
		self::addNotification('test test <a href="#">test</a> test', array(), self::NOTIFICATION_COMMUNITY_MESSAGE);
		self::addNotification('test test test test test <details>test <a href="#">test</a> test</details>', array('points' => 10, 'picture' => '', 'name' => 'foo bar'), self::NOTIFICATION_NEW_ACHIEVEMENTS_BADGE);
		self::addNotification('custom notifiation', array(
			'name' => 'foo-bar',
			'dismissUrl' => '/index.php?action=test',
		), self::NOTIFICATION_CUSTOM);
		/**/

		// render notifications
		$this->notifications = self::$notificationsStack;

		// add CSS class to <body> (add padding to the bottom of article content)
		if (!empty($this->notifications)) {
			OasisController::addBodyClass('notifications');
		}

		#var_dump($this->notifications);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Add confirmation message to the user session (so it persists between redirects)
	 */
	public static function addConfirmation($message, $type = 1) {
		wfProfileIn(__METHOD__);

		if ( !empty( $message ) ) {
			$_SESSION[self::SESSION_KEY] = array(
				'message' => $message,
				'type' => $type,
			);

			wfDebug(__METHOD__ . " - {$message}\n");
		}

		wfProfileOut(__METHOD__);
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
		wfProfileIn(__METHOD__);

		// call hook to trigger user messages from extensions
		#wfRunHooks('SkinTemplatePageBeforeUserMsg', array(&$ntl));

		// add testing confirmation
		# self::addConfirmation('test');

		if (!empty($_SESSION[self::SESSION_KEY])) {
			$entry = $_SESSION[self::SESSION_KEY];

			$this->confirmation = $entry['message'];

			switch($entry['type']) {
				case self::CONFIRMATION_NOTIFY:
					$this->confirmationClass = 'notify';
					break;

				case self::CONFIRMATION_CONFIRM:
					$this->confirmationClass = 'confirm';
					break;

				case self::CONFIRMATION_ERROR:
					$this->confirmationClass = 'error';
					break;

				case self::CONFIRMATION_WARN:
					$this->confirmationClass = 'warn';
					break;
			}

			// clear confirmation stack
			unset($_SESSION[self::SESSION_KEY]);

			wfDebug(__METHOD__ . " - {$this->confirmation}\n");
		}

		wfProfileOut(__METHOD__);
	}

	/**
	 * Handle confirmations from special preferences
	 */
	public static function addPreferencesConfirmation(&$prefs) {
		global $wgRequest;
		wfProfileIn(__METHOD__);

		if ( F::app()->checkSkin( 'oasis' ) ) {
			if ($wgRequest->getCheck('success')) {
				self::addConfirmation(wfMsg('savedprefs'));
			}
			else if ($wgRequest->getCheck('eauth')) {
				self::addConfirmation(wfMsg('eauthentsent'), self::CONFIRMATION_ERROR);
			}

			// clear the state, so that MW core doesn't render any message
			$wgRequest->setVal('eauth', null);
			$wgRequest->setVal('success', null);
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Handle confirmations when the page is moved
	 *
	 * @param $ot Title
	 * @param $nt Title
	 */
	public static function addPageMovedConfirmation(&$form, &$ot, &$nt) {
		wfProfileIn(__METHOD__);
		global $wgOut;

		if ( F::app()->checkSkin( 'oasis' ) ) {
			$oldUrl = $ot->getFullUrl('redirect=no');
			$newUrl = $nt->getFullUrl();
			$oldText = $ot->getPrefixedText();
			$newText = $nt->getPrefixedText();

			// don't render links
			$oldLink = $oldText;
			$newLink = $newText;

			self::addConfirmation(wfMsgExt('movepage-moved', array('parseinline'), $oldLink, $newLink, $oldText, $newText));

			// redirect to page with new title
			$wgOut->redirect($newUrl);
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Handle confirmations when page is deleted
	 *
	 * @param WikiPage $article
	 */
	public static function addPageDeletedConfirmation(&$article, &$user, $reason, $articleId) {
		wfProfileIn(__METHOD__);
		global $wgOut;

		if ( F::app()->checkSkin( 'oasis' ) ) {
			$title = $article->getTitle();
			// special handling of ArticleComments
			if (class_exists('ArticleComment') && MWNamespace::isTalk($title->getNamespace()) && ArticleComment::isTitleComment($title) && $title->getNamespace() != NS_USER_WALL ) {
				self::addConfirmation(wfMsg('oasis-confirmation-comment-deleted'));

				wfProfileOut(__METHOD__);
				return true;
			}

			$pageName = $title->getPrefixedText();

			$message = wfMsgExt( 'oasis-confirmation-page-deleted', array('parseinline'), $pageName );
			wfRunHooks( 'OasisAddPageDeletedConfirmationMessage', array( &$title, &$message ) );

			self::addConfirmation( $message );

			// redirect to main page
			$wgOut->redirect(Title::newMainPage()->getFullUrl( array( 'cb' => rand( 1, 1000 ) ) ));
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Handle confirmations when page is undeleted
	 *
	 * @param $title Title
	 */
	public static function addPageUndeletedConfirmation($title, $create) {
		wfProfileIn(__METHOD__);
		global $wgOut;

		if ( F::app()->checkSkin( 'oasis' ) ) {
			self::addConfirmation(wfMsg('oasis-confirmation-page-undeleted'));

			// redirect to undeleted page
			$wgOut->redirect($title->getFullUrl());
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Handle confirmations when user logs out
	 */
	public static function addLogOutConfirmation(&$user, &$injected_html, $oldName) {
		wfProfileIn(__METHOD__);
		global $wgOut, $wgRequest;

		if ( F::app()->checkSkin( 'oasis' ) ) {
			self::addConfirmation(wfMsg('oasis-confirmation-user-logout'));

			// redirect the page user has been on when he clicked "log out" link
			$mReturnTo = $wgRequest->getVal('returnto');
			$mReturnToQuery = $wgRequest->getVal('returntoquery');

			$title = Title::newFromText($mReturnTo);
			if (!empty($title)) {
				$mResolvedReturnTo = strtolower(array_shift(SpecialPageFactory::resolveAlias($title->getDBKey())));
				if (in_array($mResolvedReturnTo,array('userlogout','signup','connect'))) {
					$title = Title::newMainPage();
					$mReturnToQuery = '';
				}

				$redirectUrl = $title->getFullUrl($mReturnToQuery);
				$wgOut->redirect($redirectUrl);

				wfDebug(__METHOD__ . " - {$redirectUrl}\n");
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Handle confirmations from Facebook Connect
	 */
	public static function addFacebookConnectConfirmation(&$html) {
		wfProfileIn(__METHOD__);
		global $wgRequest, $wgUser;


		// FBConnect messages
		if ( F::app()->checkSkin( 'oasis' ) && class_exists('FBConnectHooks')) {

			$preferencesUrl = SpecialPage::getTitleFor('Preferences')->getFullUrl();
			$fbStatus = $wgRequest->getVal('fbconnected');

			switch($fbStatus) {
				// success
				case 1:
					$id = FBConnectDB::getFacebookIDs($wgUser, DB_MASTER);
					if (count($id) > 0) {

						global $wgEnableFacebookSync;
						if ($wgEnableFacebookSync == true) {
							$userURL = AvatarService::getUrl($wgUser->mName);
							self::addConfirmation(wfMsg('fbconnect-connect-msg-sync-profile', $preferencesUrl, $userURL));
						}
						else {
							self::addConfirmation(wfMsg('fbconnect-connect-msg', $preferencesUrl));
						}
					}
					break;

				// error
				case 2:
					$fb = new FBConnectAPI();
					if (strlen($fb->user()) < 1) {
						self::addConfirmation(wfMsgExt('fbconnect-connect-error-msg', array('parseinline'), $preferencesUrl), self::CONFIRMATION_ERROR);
					}
					break;
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Handle confirmations about edit being saved
	 */
	public static function addSaveConfirmation($editPage, $code) {
		global $wgUser;
		wfProfileIn(__METHOD__);

		// as for now only add it for logged-in (BugId:1317)
		if ( F::app()->checkSkin( 'oasis' ) && $wgUser->isLoggedIn()) {
			self::addConfirmation(wfMsg('oasis-edit-saved'));
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Handle notifications about new message(s)
	 */
	public static function addMessageNotification(&$skin, &$tpl) {
		wfProfileIn(__METHOD__);

		if ( F::app()->checkSkin( 'oasis' ) ) {
			// Add talk page notificaations
			$msg = $tpl->data['usernewmessages'];
			if ($msg != '') {
				self::addNotification($msg, null, self::NOTIFICATION_TALK_PAGE_MESSAGE);
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Handle notifications from the SiteWide messaging tool
	 */
	public static function addSiteWideMessageNotification($msgs) {
		wfProfileIn(__METHOD__);

		if ( F::app()->checkSkin( 'oasis' ) ) {
			self::addNotification($msgs, null, self::NOTIFICATION_SITEWIDE);
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Handle notifications about new badges
	 *
	 * @param $user User
	 * @param $badge AchBadge
	 */
	public static function addBadgeNotification($user, $badge, &$html) {
		wfProfileIn(__METHOD__);

		if ( F::app()->checkSkin( 'oasis' ) ) {
			// clear old-style notification
			$html = '';

			// add notification
			$data = array(
				'name' => $badge->getName(),
				'picture' => $badge->getPictureUrl(90),
				'points' => wfMsg('achievements-points', AchConfig::getInstance()->getLevelScore($badge->getLevel())),
				'reason' => $badge->getPersonalGivenFor(),
				'userName' => $user->getName(),
				'userPage' => $user->getUserPage()->getLocalUrl(),
			);
			#var_dump($data);

			$message = wfMsg('oasis-badge-notification', $data['userName'], $data['name'], $data['reason']);
			self::addNotification($message, $data, self::NOTIFICATION_NEW_ACHIEVEMENTS_BADGE);
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Handle notifications with edit suggestions
	 */
	public static function addEditSimilarNotification(&$html) {
		wfProfileIn(__METHOD__);

		if ( F::app()->checkSkin( 'oasis' ) ) {
			self::addNotification($html, array(), self::NOTIFICATION_EDIT_SIMILAR);

			// stop hook processing - don't show default message from extensions
			$ret = false;
		}
		else {
			$ret = true;
		}

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Handle notifications about updated community message
	 */
	public static function addCommunityMessagesNotification(&$msg) {
		wfProfileIn(__METHOD__);

		if ( F::app()->checkSkin( 'oasis' ) ) {
			self::addNotification($msg, array(), self::NOTIFICATION_COMMUNITY_MESSAGE);
		}

		wfProfileOut(__METHOD__);
		return true;
	}
}
