<?php
/**
 * Handles adding and rendering of confirmations (green stripe below global nav) and notifications (blue bubble boxes just above the fold)
 *
 * @author Maciej Brencz
 */

class NotificationsController extends WikiaController {

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

		wfDebug(__METHOD__ . " - " . (is_array( $message ) ) ? json_encode($message) : $message . "\n" );
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

		wfProfileOut(__METHOD__);
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
