<?php
/**
 * Handles adding and rendering of confirmations (green stripe below global nav) and notifications (blue bubble boxes just above the fold)
 *
 * @author Maciej Brencz
 */

class NotificationsModule extends Module {

	const SESSION_KEY = 'oasisConfirmation';

	// confirmation types
	const CONFIRMATION_NOTICE = 1;
	const CONFIRMATION_PREVIEW = 2;
	const CONFIRMATION_ERROR = 3;

	// notification types
	const NOTIFICATION_MESSAGE = 1;
	const NOTIFICATION_COMMUNITY_MESSAGE = 2;
	const NOTIFICATION_NEW_ACHIEVEMENTS_BADGE = 3;
	const NOTIFICATION_EDIT_SIMILAR = 4;

	// stack for notifications
	static private $notificationsStack;

	// HTML of user messages notification (render my MW core)
	var $usernewmessages;

	var $wgBlankImgUrl;

	var $confirmation;
	var $confirmationClass;
	var $notifications;

	/**
	 * Add notification message to the stack
	 */
	public static function addNotification($message, $data = array(), $type = 1) {
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
		self::addNotification('test test <a href="#">test</a> test', array(), self::NOTIFICATION_COMMUNITY_MESSAGE);
		self::addNotification('test test test test test <details>test <a href="#">test</a> test</details>');
		*/

		// render notifications
		$this->notifications = self::$notificationsStack;

		// add CSS class to <body> (add padding to the bottom of article content)
		if (!empty($this->notifications)) {
			OasisModule::addBodyClass('notifications');
		}

		#var_dump($this->notifications);

		wfProfileOut(__METHOD__);
	}

	/**
	 * Add confirmation message to the user session (so it persists between redirects)
	 */
	public static function addConfirmation($message, $type = 1) {
		wfProfileIn(__METHOD__);

		$_SESSION[self::SESSION_KEY] = array(
			'message' => $message,
			'type' => $type,
		);

		wfDebug(__METHOD__ . " - {$message}\n");
		wfProfileOut(__METHOD__);
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
				case self::CONFIRMATION_PREVIEW:
					$this->confirmationClass = ' preview';
					break;

				case self::CONFIRMATION_ERROR:
					$this->confirmationClass = ' error';
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
	public static function addPreferencesConfirmation(&$prefs, &$status, $message) {
		wfProfileIn(__METHOD__);

		if (Wikia::isOasis()) {
			if ($prefs->mSuccess || 'success' == $status) {
				self::addConfirmation(wfMsg('savedprefs'));
			}
			else if ('error' == $status) {
				self::addConfirmation($message, self::CONFIRMATION_ERROR);
			}
			else if ('' != $status) {
				self::addConfirmation($message);
			}

			// clear the state, so that MW core doesn't render any message
			$prefs->mSuccess = false;
			$status = '';
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Handle confirmations when the page is moved
	 */
	public static function addPageMovedConfirmation(&$form, &$ot, &$nt) {
		wfProfileIn(__METHOD__);
		global $wgOut;

		if (Wikia::isOasis()) {
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
	 */
	public static function addPageDeletedConfirmation(&$article, &$user, $reason, $articleId) {
		wfProfileIn(__METHOD__);
		global $wgOut;

		if (Wikia::isOasis()) {
			$title = $article->getTitle();

			// special handling of ArticleComments
			if (class_exists('ArticleComment') && MWNamespace::isTalk($title->getNamespace()) && ArticleComment::isTitleComment($title)) {
				self::addConfirmation(wfMsg('oasis-confirmation-comment-deleted'));

				wfProfileOut(__METHOD__);
				return true;
			}

			$pageName = $title->getPrefixedText();

			self::addConfirmation(wfMsgExt('oasis-confirmation-page-deleted', array('parseinline'), $pageName));

			// redirect to main page
			$wgOut->redirect(Title::newMainPage()->getFullUrl());
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Handle confirmations when page is undeleted
	 */
	public static function addPageUndeletedConfirmation($title, $create) {
		wfProfileIn(__METHOD__);
		global $wgOut;

		if (Wikia::isOasis()) {
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

		if (Wikia::isOasis()) {
			self::addConfirmation(wfMsg('oasis-confirmation-user-logout'));

			// redirect the page user has been on when he clicked "log out" link
			$mReturnTo = $wgRequest->getVal('returnto');
			$mReturnToQuery = $wgRequest->getVal('returntoquery');

			$title = Title::newFromText($mReturnTo);
			if (!empty($title)) {
				$mResolvedReturnTo = strtolower(SpecialPage::resolveAlias($title->getDBKey()));
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
		if (Wikia::isOasis() && class_exists('FBConnectHooks')) {
			wfLoadExtensionMessages('FBConnect');

			$preferencesUrl = SpecialPage::getTitleFor('Preferences')->getFullUrl();
			$fbStatus = $wgRequest->getVal('fbconnected');

			switch($fbStatus) {
				// success
				case 1:
					$id = FBConnectDB::getFacebookIDs($wgUser, DB_MASTER);
					if (count($id) > 0) {
						self::addConfirmation(wfMsg('fbconnect-connect-msg', $preferencesUrl));
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
	 * Handle notifications about new message(s)
	 */
	public static function addMessageNotification(&$skin, &$tpl) {
		global $wgUser, $wgOut;
		wfProfileIn(__METHOD__);

		if (Wikia::isOasis()) {
			$msg = SiteWideMessages::getAllUserMessages($wgUser, false, false);

			if ($msg != '') {
				foreach ($msg as $msgId => &$data) {
					$data['text'] = $wgOut->parse($data['text']);
				}
				
				self::addNotification($msg);
			}
		}

		wfProfileOut(__METHOD__);
		return true;
	}

	/**
	 * Handle notifications about new badges
	 */
	public static function addBadgeNotification($user, $badge, &$html) {
		wfProfileIn(__METHOD__);

		if (Wikia::isOasis()) {
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

		if (Wikia::isOasis()) {
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

		if (Wikia::isOasis()) {
			self::addNotification($msg, array(), self::NOTIFICATION_COMMUNITY_MESSAGE);
		}

		wfProfileOut(__METHOD__);
		return true;
	}

}