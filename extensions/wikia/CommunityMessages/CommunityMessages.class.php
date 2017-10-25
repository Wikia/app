<?php
/**
 * CommunityMessages
 *
 * A CommunityMessages extension for MediaWiki
 * Helper extension for Community Messages
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @date 2010-07-30
 * @copyright Copyright (C) 2010 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/CommunityMessages/CommunityMessages_setup.php");
 */

class CommunityMessages {
	//used as type in user_flags table
	const USER_FLAGS_COMMUNITY_MESSAGES = 0;

	static $messageSeen = false;

	/**
	 * hook handler
	 * check conditions and display message
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 * @param string $msgs
	 * @param Skin $skin
	 * @return bool
	 */
	static function onSkinTemplatePageBeforeUserMsg( string &$msgs, Skin $skin ): bool {
		global $wgUser, $wgMemc, $wgCookiePrefix;

		if (self::$messageSeen) {
			//user is just seeing the message - hide notification for this session
			return true;
		}

		//get timestamp of message
		$cacheKey = static::getCommunityMessagesCacheKey();
		$communityMessagesTimestamp = $wgMemc->get( $cacheKey );

		if ( !$communityMessagesTimestamp ||
			 $communityMessagesTimestamp < ( time() - 86400 /*24h*/ ) ) {
			// no message or message older than 24h - do not inform user about it
			return true;
		}

		if ($wgUser->isLoggedIn()) {
			$userTimestamp = self::getUserTimestamp($wgUser);

			if ($userTimestamp !== false && $userTimestamp >= $communityMessagesTimestamp) {
				//old, seen message
				return true;
			}
		} else {
			//anon
			//compare timestamp from cookie
			if (isset($_COOKIE[$wgCookiePrefix . 'CommunityMessages']) && $_COOKIE[$wgCookiePrefix . 'CommunityMessages'] >= $communityMessagesTimestamp) {
				//old, seen message
				return true;
			}
		}

		if ($msgs != '') {
			$msgs .= '<br/>';
		}

		// render message
		$msg = '';
		if( SpecialPageFactory::exists( 'WikiActivity' ) ) {
			$msg = wfMsgExt('communitymessages-notice-msg', array( 'parseinline', 'content' ));
		}

		// macbre: add an easy way for Oasis to show it's own notification for community messages
		Hooks::run('CommunityMessages::showMessage', [ &$msg, $skin ] );

		return true;
	}

	/**
	 * hook handler
	 * update timestamp of newest message
	 *
	 * @param WikiPage $article
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 * @return bool
	 */
	static function onArticleSaveComplete( WikiPage $article, User $user, $text, $summary, $minoredit, $watchthis, $sectionanchor, $flags, $revision, Status &$status, $baseRevId ): bool {
		global $wgMemc;
		$title = $article->getTitle();

		if ($title->getNamespace() == NS_MEDIAWIKI && strtolower($title->getText()) == 'community-corner' && !$minoredit) {
			// SUS-2566: Skip DB call here. We just made an edit, let's just use the current time.
			$wgMemc->set( static::getCommunityMessagesCacheKey(), time(), 86400 /*24h*/ );
		}

		return true;
	}

	/**
	 * hook handler
	 * update user's timestamp of seen message
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 * @param OutputPage $out
	 * @param Skin $skin
	 * @return bool
	 */
	static function onBeforePageDisplay( OutputPage $out, Skin $skin ): bool {
		$title = $out->getTitle();

		if ( !$title->isSpecial( 'ActivityFeed' ) && !$title->isSpecial( 'MyHome' ) &&
			 !$title->isSpecial( 'WikiActivity' ) ) {
			return true;
		}

		global $wgMemc;
		$communityMessagesTimestamp = $wgMemc->get( static::getCommunityMessagesCacheKey() ) ?? time();

		// SUS-2585: Update table for logged in users
		$user = $out->getUser();
		if ( $user->isLoggedIn() && $communityMessagesTimestamp > (int) static::getUserTimestamp( $user ) ) {
			global $wgCityId;

			$task = ( new \Wikia\Tasks\Tasks\DismissCommunityMessageTask() )
				->wikiId( $wgCityId )
				->createdBy( $user );

			$task->call( 'dismissCommunityMessage', $communityMessagesTimestamp );
			$task->queue();

			return true;
		}

		// set cookie for anons
		$out->getRequest()->response()
			->setcookie('CommunityMessages', $communityMessagesTimestamp, time() + 86400 /*24h*/);

		return true;
	}

	/**
	 * Dismisses notification about updated community message
	 *
	 * Moved from BeforePageDisplay into separate method by Macbre
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	static function dismissMessage() {
		wfProfileIn(__METHOD__);
		global $wgUser, $wgMemc, $wgCityId, $wgExternalDatawareDB;

		$communityMessagesTimestamp = $wgMemc->get(wfMemcKey('CommunityMessagesTimestamp'));
		if (!$communityMessagesTimestamp) {
			//do not waste time on getting timestamp from 'community-corner' - `now` will be enough
			$communityMessagesTimestamp = time();
		}

		if ($wgUser->isLoggedIn()) {
			$userTimestamp = self::getUserTimestamp($wgUser);
			//we have newer message - update user's timestamp
			if (($userTimestamp === false || $communityMessagesTimestamp > $userTimestamp) && !wfReadOnly()) {
				$dbw = wfGetDB(DB_MASTER, array(), $wgExternalDatawareDB);
				$dbw->replace('user_flags', null /*not used*/,
					array(
						'city_id' => $wgCityId,
						'user_id' => $wgUser->getID(),
						'type' => self::USER_FLAGS_COMMUNITY_MESSAGES,
						'data' => wfTimestamp(TS_DB, $communityMessagesTimestamp)
					),
					__METHOD__
				);

				// fix for AJAX calls
				$dbw->commit();
			}
		} else {
			//anon
			$req = new WebRequest();
			$req->response()->setcookie('CommunityMessages', $communityMessagesTimestamp, time() + 86400 /*24h*/);
		}

		//hide notice in this session [omit need to send cookie back (anon) or slave lag (logged in)]
		self::$messageSeen = true;
		wfDebug(__METHOD__ . " - message dismissed\n");

		wfProfileOut(__METHOD__);
	}

	/**
	 * helper function
	 *
	 * @author Maciej Błaszkowski <marooned at wikia-inc.com>
	 */
	private static function getUserTimestamp(User $user) {
		global $wgCityId, $wgExternalDatawareDB;
		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);
		$userTimestamp = $dbr->selectField(
			'user_flags',
			'data',
			array('city_id' => $wgCityId, 'user_id' => $user->getId(), 'type' => self::USER_FLAGS_COMMUNITY_MESSAGES),
			__METHOD__
		);
		return $userTimestamp ? wfTimestamp(TS_UNIX, $userTimestamp) : false;
	}

	private static function getCommunityMessagesCacheKey(): string {
		return wfMemcKey( 'CommunityMessagesTimestamp' );
	}
}
