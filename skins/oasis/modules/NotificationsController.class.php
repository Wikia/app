<?php
/**
 * Handles notifications (blue bubble boxes just above the fold)
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
	public static function addNotification( $message, $data = array(), $type = 0 ) {

		self::$notificationsStack[] = array(
			'message' => $message,
			'data' => $data,
			'type' => $type,
		);

		wfDebug(__METHOD__ . " - " . ( is_array( $message ) ) ?
			json_encode( $message ) : $message . "\n" );
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
		// render notifications
		$this->notifications = self::$notificationsStack;

		// add CSS class to <body> (add padding to the bottom of article content)
		if ( !empty( $this->notifications ) ) {
			OasisController::addBodyClass( 'notifications' );
		}
	}

	/**
	 * Handle notifications about new message(s)
	 */
	public static function addMessageNotification( &$skin, &$tpl ) {
		if ( F::app()->checkSkin( 'oasis' ) ) {
			// Add talk page notificaations
			$msg = $tpl->data['usernewmessages'];
			if ( $msg != '' ) {
				self::addNotification( $msg, null, self::NOTIFICATION_TALK_PAGE_MESSAGE );
			}
		}
		return true;
	}

	/**
	 * Handle notifications from the SiteWide messaging tool
	 */
	public static function addSiteWideMessageNotification( $msgs ) {
		if ( F::app()->checkSkin( 'oasis' ) ) {
			self::addNotification( $msgs, null, self::NOTIFICATION_SITEWIDE );
		}
		return true;
	}

	/**
	 * Handle notifications about new badges
	 *
	 * @param $user User
	 * @param $badge AchBadge
	 */
	public static function addBadgeNotification( $user, $badge, &$html ) {
		if ( F::app()->checkSkin( 'oasis' ) ) {
			// clear old-style notification
			$html = '';

			// add notification
			$data = array(
				'name' => $badge->getName(),
				'picture' => $badge->getPictureUrl(90),
				'points' => wfMessage(
					'achievements-points',
					AchConfig::getInstance()->getLevelScore( $badge->getLevel() )
				)->escaped(),
				'reason' => $badge->getPersonalGivenFor(),
				'userName' => $user->getName(),
				'userPage' => $user->getUserPage()->getLocalUrl(),
			);

			$message = wfMessage(
				'oasis-badge-notification',
				$data['userName'],
				$data['name'],
				$data['reason']
			)->escaped();

			self::addNotification(
				$message,
				$data,
				self::NOTIFICATION_NEW_ACHIEVEMENTS_BADGE
			);
		}
		return true;
	}

	/**
	 * Handle notifications with edit suggestions
	 */
	public static function addEditSimilarNotification( &$html ) {
		if ( F::app()->checkSkin( 'oasis' ) ) {
			self::addNotification( $html, array(), self::NOTIFICATION_EDIT_SIMILAR );

			// stop hook processing - don't show default message from extensions
			$ret = false;
		}
		else {
			$ret = true;
		}
		return $ret;
	}

	/**
	 * Handle notifications about updated community message
	 */
	public static function addCommunityMessagesNotification( &$msg ) {
		if ( F::app()->checkSkin( 'oasis' ) ) {
			self::addNotification( $msg, array(), self::NOTIFICATION_COMMUNITY_MESSAGE );
		}
		return true;
	}
}
