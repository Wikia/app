<?php
/*
 * Wall notifications allows us to manage notifications about new messages
 * and replies on users Walls
 *
 * Interface
 *  single instance of WallNotifications to interact with
 *  WallNotificationEntity - single notification data,
 *    only one exists for every notification event, but is linked from
 *    every user who is interested in specific notification
 *
 */

class WallNotifications {
	/**
	 * @var WikiaApp
	 */
	protected $app;

	private $cachedUsers = [];
	private $removedEntities;
	private $uniqueUsers = []; //used for since read email.

	public function __construct() {
		$this->app = F::app();
		$this->removedEntities = [];
	}

	/*
	 * Public Interface
	 */
	public function getWikiNotifications( $userId, $wikiId, $readSlice = 5, $countonly = false, $notifyeveryone = false ) {
		/* if since == null, get all notifications */
		/* possibly ignore $wiki at one point and fetch notifications from all wikis */
		wfProfileIn(__METHOD__);

		$memcSync = $this->getCache( $userId, $wikiId );

		// try fetching the list of notifications from memcache
		$list = $memcSync->get();
		if ( empty( $list ) && !is_array( $list ) ) {
			// nothing in the cache, so use the db as a fallback and store the result in cache
			$callback = function() use( $userId, $wikiId, &$list ) {
				$list = $this->rebuildData( $userId, $wikiId );
				return $list;
			};

			// this memcache data is synchronized so we're making sure nothing else is modifying it at the same time
			// we're using the same callback when we cannot acquire the lock, as we want to have the list of notifications
			// even if we won't be able to store it in the cache
			$memcSync->lockAndSetData( $callback, $callback );
		}

		if ( empty( $list ) ) {
			wfProfileOut(__METHOD__);
			return [];
		}
		$read = [];
		$unread = [];

		// walk through list of ids
		// $listval is unique_id field from wall_notification table in DB
		foreach ( array_reverse( $list['notification'] ) as $listval ) {
			if ( !empty( $listval ) ) {
				if ( !$countonly ) {
					$grouped = $this->groupEntity( $list['relation'][ $listval ]['list'] );
				} else {
					$grouped = [];
				}

				if ( !empty( $grouped ) || $countonly ) {
					if ( $list['relation'][ $listval ]['read'] ){
						if ( count( $read ) < $readSlice ){
							$read[] = [
								"grouped" => $grouped,
								"count" => 	empty( $list['relation'][ $listval ]['count'] )
											? count( $list['relation'][ $listval ]['list'] )
											: $list['relation'][ $listval ]['count']
							];
						} elseif ( $readSlice > 0 ) {
							// so we have more read notifications that we need for display
							// remove them
							$this->remNotificationsForUniqueID( $userId, $wikiId, $listval );
						}
					} else {
						if ( empty( $list['relation'][ $listval ]['notifyeveryone']) || $notifyeveryone ) {
							$unread[] = [
								"grouped" => $grouped,
								"count" => 	empty( $list['relation'][ $listval ]['count'] )
											? count( $list['relation'][ $listval ]['list'] )
											: $list['relation'][ $listval ]['count']
							];
						}
					}
				}
			}
		}

		// we are only ever asked for notifications for Wikis that are on WikiList
		// so if there are no unread notifications for that Wiki it should not
		// be on that list (this will save us some work for checking & fetching
		// notifications that are in fact, empty, since current Wiki is
		// an exception and is always checked this works for read notification
		// as well)
		if ( count( $unread ) == 0 ) {
			$this->remWikiFromList( $userId, $wikiId );
		}

		$user = $this->getUser( $userId );
		if ( in_array( 'sysop', $user->getEffectiveGroups() ) ) {
			$wna = new WallNotificationsAdmin;
			$unread = array_merge( $wna->getAdminNotifications( $wikiId, $userId ), $unread );
		}

		$wno = new WallNotificationsOwner;
		$unread = array_merge( $wno->getOwnerNotifications( $wikiId, $userId ), $unread );

		$unread = $this->sortByTimestamp( $unread );

		$out = [
			'unread'=> $unread,
			'unread_count' => count( $unread ),
			'read' => $read,
			'read_count' => count( $read )
		];

		wfProfileOut(__METHOD__);
		return $out;
	}

	/**
	 * Returns array with wikis' ids and number of unread notifications on that wiki
	 *
	 * example return
	 * 	$output = array(
	 * 		array(
	 * 			'id' => 831,
	 * 			'sitename' => "Muppet Wiki",
	 * 			'unread' => 5
	 * 		),
	 * 		array (
	 * 			'id' => 5915,
	 * 			'sitename' => "Poznańska Wiki",
	 * 			'unread' => 1
	 * 		)
	 * 	)
	 *
	 * @param int $userId
	 * @return array
	 */
	public function getCounts( $userId ) {
		global $wgMemc, $wgCityId;

		wfProfileIn(__METHOD__);
		$wikiList = $this->getWikiList( $userId );

		// prefetch data
		$keys = [];
		$wno = new WallNotificationsOwner;
		foreach ( $wikiList as $wiki ) {
			$keys[] = $this->getKey( $userId, $wiki['id'] );
			$keys[] = $wno->getKey( $wiki['id'], $userId );
		}
		$wgMemc->prefetch( $keys );

		$output = [];
		$total = 0;
		foreach ( $wikiList as $wiki ) {
			$wiki['unread'] = $this->getCount( $userId, $wiki['id'], $wiki['id'] == $wgCityId );
			$total += $wiki['unread'];
			// show only Wikis with unread notifications
			// current Wiki is an exception (show always)
			if ( $wiki['unread'] > 0 || $wiki['id'] == $wgCityId )
				$output[] = $wiki;
		}
		wfProfileOut(__METHOD__);
		return $output;
	}

	private function sortByTimestamp( $array ) {
		uasort($array, [ $this, 'sortByTimestampCB' ]);

		return $array;
	}

	private function sortByTimestampCB( $a, $b ) {
		if ( !empty( $a['grouped']) && !empty( $b['grouped'] ) ) {
			if ( $a['grouped'][0]->data->timestamp > $b['grouped'][0]->data->timestamp ) {
				return -1;
			}
		}
		return 1;
	}

	/**
	 * Returns number of unread user's notifications for wiki
	 * @param int $userId
	 * @param int $wikiId
	 * @param bool $notifyeveryone
	 * @return int
	 */
	private function getCount( $userId, $wikiId, $notifyeveryone = false ) {
		// fixme
		// should not to do the whole work of WikiNotifications
		$notifs = $this->getWikiNotifications( $userId, $wikiId, 5, true, $notifyeveryone );
		return $notifs['unread_count'];
	}

	private function getWikiList( $userId ) {
		global $wgMemc, $wgEnableWallEngine, $wgCityId, $wgSitename;

		$key = $this->getKey( $userId, 'LIST' );
		$val = $wgMemc->get( $key );

		if ( false === $val ) {
			$val = $this->loadWikiListFromDB( $userId );
			$wgMemc->set( $key, $val );
		}

		// make sure that current Wiki is on the list, as first entry, sort the rest
		asort( $val );
		if ( !empty( $wgEnableWallEngine ) ) {
			unset( $val[ $wgCityId ] );
			$output = [ [
				'id' => $wgCityId,
				'sitename' => $wgSitename] ];
		} else {
			$output = [];
		}
		WikiFactory::prefetchWikisById( array_keys( $val), WikiFactory::PREFETCH_VARIABLES );
		foreach ( $val as $wikiId => $wikiSitename ) {
			$output[] = [
				'id' => $wikiId,
				'sitename' => $wikiSitename
			];
		}
		return $output;

	}

	private function addWikiToList( $userId, $wikiId, $wikiSitename ) {
		global $wgMemc;

		$key = $this->getKey( $userId, 'LIST' );
		$val = $wgMemc->get( $key );

		if ( empty( $val ) ) {
			$val = $this->loadWikiListFromDB( $userId );
		}

		$val[$wikiId] = $wikiSitename;

		$wgMemc->set( $key, $val );

	}

	private function remWikiFromList( $userId, $wikiId ) {
		global $wgMemc;

		// TODO / FIXME
		// Currently there is a race condition in WikiList.
		// Access to memcache key is not synchronized,
		// waiting for new memcache implementation code
		// that supports update-if-key-did-not-change

		$key = $this->getKey( $userId, 'LIST' );
		$val = $wgMemc->get( $key );

		if ( empty( $val ) ) {
			// removing Wiki from list is just speed optimization
			// if list is not cached in memory there is no
			// need to recreate it from DB
		} else {
			unset( $val[$wikiId] );
			$wgMemc->set( $key, $val );
		}
	}

	private function loadWikiListFromDB( $userId ) {
		$db = $this->getDB( false );
		$res = $db->select( 'wall_notification',
			[ 'distinct wiki_id' ],
			[ 'user_id' => $userId ],
			__METHOD__
		);
		$ids = [];
		foreach ( $res as $row ) {
			/** @var Object $row */
			$ids[] = $row->wiki_id;
		}
		WikiFactory::prefetchWikisById( $ids, WikiFactory::PREFETCH_WIKI_METADATA );
		$output = [];
		foreach ( $ids as $id ) {
			$output[ $id ] = WikiFactory::getWikiByID( $id )->city_title;
		}
		return $output;
	}

	protected function groupEntity( $list ){
		$grouped = [];
		foreach ( array_reverse( $list ) as $obj ) {
			$notif = WallNotificationEntity::getById( $obj['entityKey'] );
			if ( !empty( $notif ) )
				$grouped[] = $notif;
		}
		return $grouped;
	}

	/**
	 * @param WallNotificationEntity $notif
	 */
	public function addNotification( WallNotificationEntity $notif ) {
		if ( !empty( $notif ) ) {
			$this->notifyEveryone( $notif );
		}
	}

	/*
	 * Helper functions
	 */

	/**
	 * @param WallNotificationEntity $notification
	 */
	public function notifyEveryone( WallNotificationEntity $notification ) {

		if ( empty( $notification->data_noncached ) || empty( $notification->data_noncached->parent_title_dbkey ) ) {
			$title = "";
		} else {
			$title = $notification->data_noncached->parent_title_dbkey;
		}

		if ( !empty( $notification->data->article_title_ns ) ) {
			$users = $this->getWatchlist( $notification->data->wall_username, $title, $notification->data->article_title_ns );
		} else {
			$users = $this->getWatchlist( $notification->data->wall_username, $title );
		}

		//FB:#11089
		$users[$notification->data->wall_userid] = $notification->data->wall_userid;

		if ( !empty( $users[$notification->data->msg_author_id] ) ) {
			unset( $users[$notification->data->msg_author_id] );
		}

		$this->addNotificationLinks( $users, $notification );
		$this->sendEmails( array_keys( $users ), $notification );
	}

	protected function createKeyForMailNotification( $watcher, WallNotificationEntity $notification ) {
		$data = $notification->data;

		if ( $notification->isMain() ) {
			if ( $watcher == $data->wall_userid ) {
				$key = 'mail-notification-new-your';
			} else {
				$key = 'mail-notification-new-someone';
			}
		} else {
			if ( $watcher == $data->parent_user_id ) {
				$key = 'mail-notification-reply-your';
			} elseif ( $data->msg_author_id == $data->parent_user_id && $data->msg_author_id != 0 ) {
				$key = 'mail-notification-reply-his';
			} else {
				$key = 'mail-notification-reply-someone';
			}
		}
		return $key;
	}

	protected function sendEmails( array $watchers, WallNotificationEntity $notification ) {
		$text = strip_tags( $notification->data_noncached->msg_text, '<p><br>' );
		$text = substr( $text, 0, 3000 ) . ( strlen( $text ) > 3000 ? '...' : '' );

		$textNoHtml = preg_replace( '#<br\s*/?>#i', "\n", $text );
		$textNoHtml = trim( preg_replace( '#</?p\s*/?>#i', "\n", $textNoHtml ) );
		$textNoHtml = substr( $textNoHtml, 0, 3000) . ( strlen( $textNoHtml ) > 3000 ? '...' : '' );

		$entityKey = $notification->getId();

		if ( empty( $this->uniqueUsers[$entityKey] ) ){
			$this->uniqueUsers[$entityKey] = [];
		}

		foreach ( $watchers as $val ){
			$watcher = $this->getUser( $val );
			$mode = $watcher->getOption( 'enotifwallthread' );

			if ( !empty( $mode ) && $watcher->getId() != 0 && (
				( $mode == WALL_EMAIL_EVERY ) ||
				( $mode == WALL_EMAIL_SINCEVISITED && empty( $this->uniqueUsers[$entityKey][$watcher->getId()] ) )
			)) {

				$key = $this->createKeyForMailNotification( $watcher->getId(), $notification );
				$watcherName = $watcher->getName();

				if ( $notification->data->msg_author_username == $notification->data->msg_author_displayname ) {
					$author_signature = $notification->data->msg_author_username;
				} else {
					$author_signature = $notification->data->msg_author_displayname .
						' (' . $notification->data->msg_author_username . ')';
				}

				$data = [];
				wfRunHooks( 'NotificationGetMailNotificationMessage', [
					&$notification, &$data, $key, $watcherName, $author_signature, $textNoHtml, $text
				]);
				if ( empty( $data ) ) {
					$data = [
						'$WATCHER' => $watcherName,
						'$WIKI' => $notification->data->wikiname,
						'$PARENT_AUTHOR_NAME' => 	(empty($notification->data->parent_displayname)
													? ''
													: $notification->data->parent_displayname),
						'$AUTHOR_NAME' => $notification->data->msg_author_displayname,
						'$AUTHOR' => $notification->data->msg_author_username,
						'$AUTHOR_SIGNATURE' => $author_signature,
						'$MAIL_SUBJECT' => wfMessage('mail-notification-subject', [
							'$1' => $notification->data->thread_title,
							'$2' => $notification->data->wikiname
						])->text(),
						'$METATITLE' => $notification->data->thread_title,
						'$MESSAGE_LINK' =>  $notification->data->url,
						'$MESSAGE_NO_HTML' =>  $textNoHtml,
						'$MESSAGE_HTML' =>  $text,
						'$MSG_KEY_SUBJECT' => $key,
						'$MSG_KEY_BODY' => 'mail-notification-body',
						'$MSG_KEY_GREETING' => 'mail-notification-html-greeting',
					];
				}

				if ( !( $watcher->getBoolOption('unsubscribed') === true ) ) {
					$this->sendEmail( $watcher, $data );
				}
			}
		}

		return true;
	}

	protected function sendEmail( User $watcher, array $data ) {
		global $wgPasswordSender, $wgNoReplyAddress;

		$from = new MailAddress( $wgPasswordSender, 'Wikia' );
		$replyTo = new MailAddress ( $wgNoReplyAddress );

		$keys = array_keys( $data );
		$values =  array_values( $data );

		$subject = wfMessage( $data['$MSG_KEY_SUBJECT'] )->inContentLanguage()->text();

		$text = wfMessage( $data['$MSG_KEY_BODY'] )->inContentLanguage()->text();

		$subject = str_replace( $keys, $values, $subject );

		$keys[] = '$SUBJECT';
		$values[] = $subject;

		$data['$SUBJECT'] = $subject;
		$html = $this->app->getView( 'WallExternal', 'mail', ['data' => $data] )->render();
		$text = str_replace( $keys, $values, $text );

		return $watcher->sendMail( $data['$MAIL_SUBJECT'], $text, $from, $replyTo, 'WallNotification', $html );
	}

	protected function getWatchlist( $name, $titleDbkey, $ns = NS_USER_WALL ) {
		//TODO: add some caching
		$userTitle = Title::newFromText( $name, MWNamespace::getSubject($ns) );

		$dbw = $this->getLocalDB( true );
		$res = $dbw->select(
			['watchlist' ],
			[ 'wl_user' ],
			[
				'wl_title' => [ $titleDbkey, $userTitle->getDBkey() ],
				'wl_namespace' => [ MWNamespace::getSubject($ns), MWNamespace::getTalk($ns) ],
				//THIS hack will be removed after runing script with will clear all notification copy
                "((wl_wikia_addedtimestamp > '2012-01-31' and wl_namespace = ".MWNamespace::getSubject($ns).") or ( wl_namespace = " .MWNamespace::getTalk($ns). " ))"
			],
			__METHOD__
		);

		$users = [];
		while ( $row = $dbw->fetchObject( $res ) ) {
			$userId = intval( $row->wl_user );
			$users[$userId] = $userId;
		}

		return $users;
	}

	/**
	 * @param array $userIds
	 * @param WallNotificationEntity $notification
	 */
	public function addNotificationLinks( Array $userIds, WallNotificationEntity $notification ) {
		$wg = F::app()->wg;
		foreach ( $userIds as $userId ) {
			$this->addNotificationLink( $userId, $notification );
			$this->addWikiToList( $userId, $wg->CityId, $wg->Sitename );
		}
	}

	protected function addNotificationLink( $userId, WallNotificationEntity $notification ) {
		$this->addNotificationLinkInternal(
			$userId,
			$notification->data->wiki,
			[
				'unique_id' => $notification->getUniqueId(),
				'entity_key' => $notification->getId(),
				'author_id' => $notification->data->msg_author_id,
				'is_reply' => !$notification->isMain(),
				'notifyeveryone' => $notification->data->notifyeveryone
			]
		);
	}

	public function markRead( $userId, $wikiId, $id = 0 ) {
		$updateDBlist = []; // we will update database AFTER unlocking

		$wasUnread = false; // function returns True if in fact there was unread notification

		$memcSync = $this->getCache( $userId, $wikiId );

		$memcSync->lockAndSetData(
			function() use( $memcSync, $userId, $wikiId, $id, &$updateDBlist, &$wasUnread ) {
				$data = $this->getData( $memcSync, $userId, $wikiId );

				if ($id == 0 && !empty( $data['relation'] ) ) {
					$ids = array_keys( $data['relation'] );
				} else {
					$ids = [ $id ];
				}

				foreach ($ids as $value) {
					if ( !empty( $data['relation'][ $value] ) ) {
						if ( $data['relation'][ $value ]['read'] == false ) {
							$wasUnread = true;
							$data['relation'][ $value ]['read'] = true;

							$updateDBlist[] = [
								'user_id' => $userId,
								'wiki_id' => $wikiId,
								'unique_id' => $value
							];
						}
					}
				}

				return $data;
			},
			function() use( $memcSync ) {
				// Delete the cache if we were unable to update to force a rebuild
				$memcSync->delete();
			}
		);

		foreach ( $updateDBlist as $value ) {
			$this->getDB( true )->update( 'wall_notification' , ['is_read' =>  1], $value, __METHOD__ );
		}

		if ( $id === 0 ) {
			$user = $this->getUser( $userId );
			if ( $user instanceof User &&
			    ( in_array( 'sysop', $user->getEffectiveGroups() )
					|| in_array( 'staff', $user->getEffectiveGroups() )	)
			) {
				$wna = new WallNotificationsAdmin;
				$wasUnread = $wasUnread || $wna->hideAdminNotifications( $wikiId, $userId );
			}
			$wno = new WallNotificationsOwner;
			$wasUnread = $wasUnread || $wno->removeAll( $wikiId, $userId );
		}

		return $wasUnread;
	}

	public function markReadAllWikis( $userId ) {
		$list = $this->getWikiList( $userId );
		foreach ( $list as $wikiData ) {
			$this->markRead( $userId, $wikiData['id'] );
		}
	}

	public function remNotificationsForUniqueID( $userId, $wikiId, $uniqueId, $hide = false ) {
		// hide = true - able to restore them later (after reenabling in DB and than rebuilding from DB)
		// hide = false - remove permanently, no ability to restore it

		if ( empty( $userId ) ) {
			$users = $this->getUsersWithNotificationsForUniqueID( $wikiId, $uniqueId );
		} else {
			$users = [ $userId ];
		}

		foreach ( $users as $uId ) {

			if ($this->isCachedData( $uId, $wikiId ) ) {
				$memcSync = $this->getCache( $uId, $wikiId );

				$memcSync->lockAndSetData(
					function() use( $memcSync, $uId, $wikiId, $uniqueId ) {
						$data = $this->getData( $memcSync, $uId, $wikiId );
						$this->remNotificationFromData( $data, $uniqueId );
						return $data;
					},
					function() use( $memcSync ) {
						// Delete the cache if we were unable to update to force a rebuild
						$memcSync->delete();
					}
				);
			}

			$this->remNotificationsForUniqueIDDB( $uId, $wikiId, $uniqueId, $hide );
		}
	}

	private function getUsersWithNotificationsForUniqueID( $wikiId, $uniqueId ) {
		$db = $this->getDB( true );

		$res = $db->select(
			'wall_notification',
			['distinct user_id'],
			[
				'wiki_id' => $wikiId,
				'unique_id' => $uniqueId
			],
			__METHOD__,
			[ "GROUP BY" => "user_id" ]
		);

		$users = [];
		while ( $row = $db->fetchRow( $res ) ) {
			$users[] = $row['user_id'];
		}
		return $users;
	}

	public function unhideNotificationsForUniqueID( $wikiId, $uniqueId ) {

		$this->unhideNotificationsForUniqueIDDB( $wikiId, $uniqueId );

		// find which users had notifications for that uniqueId and nuke their
		// in-memory representations

		$users = $this->getUsersWithNotificationsForUniqueID( $wikiId, $uniqueId );

		foreach ( $users as $user ) {
			$this->forceRebuild( $user, $wikiId );
		}
	}

	protected function remNotificationsForUniqueIDDB( $userId, $wikiId, $uniqueId, $hide = false ) {
		$where = [
			'user_id' => $userId,
			'wiki_id' => $wikiId,
			'unique_id' => $uniqueId
		];

		if ( $hide === true ) {
			$this->getDB( true )->update( 'wall_notification' , ['is_hidden' =>  1], $where, __METHOD__ );
		} else {
			$this->getDB( true )->delete( 'wall_notification' , $where, __METHOD__ );
		}
	}

	protected function unhideNotificationsForUniqueIDDB( $wikiId, $uniqueId ) {
		$where = [
			'wiki_id' => $wikiId,
			'unique_id' => $uniqueId
		];

		$this->getDB( true )->update( 'wall_notification' , ['is_hidden' => 0], $where, __METHOD__ );
	}

	protected function remNotificationDB( $userId, $wikiId, $uniqueId, $entityId ) {
		$where = [
			'user_id' => $userId,
			'wiki_id' => $wikiId,
			'unique_id' => $uniqueId,
			'entity_id' => $entityId
		];

		$this->getDB( true )->delete( 'wall_notification' , $where, __METHOD__ );
	}

	protected function addNotificationLinkInternal( $userId, $wikiId, $notification ) {
		if ( $userId < 1 ) {
			return;
		}

		$this->storeInDB( $userId, $wikiId, $notification );
		//id use to prevent having of extra entry after memc fail.

		$memcSync = $this->getCache( $userId, $wikiId );

		$memcSync->lockAndSetData(
			function() use ( $memcSync, $userId, $wikiId, $notification ) {
				$data = $this->getData( $memcSync, $userId, $wikiId );
				$notification['is_read'] = false;
				$this->addNotificationToData( $data, $userId, $wikiId, $notification );
				return $data;
			},
			function() use ( $memcSync ) {
				// Delete the cache if we were unable to update to force a rebuild
				$memcSync->delete();
			}
		);

		$this->cleanEntitiesFromDB();
	}

	protected function random_msleep( $max = 20 ) {
		usleep( rand( 1, $max*1000 ) );
	}

	protected function remNotificationFromData( &$data, $uniqueId ) {
		if ( isset( $data['relation'][ $uniqueId ]['last']) && $data['relation'][ $uniqueId ]['last'] > -1 ) {
			unset( $data['notification'][ $data['relation'][$uniqueId ]['last'] ] );
			unset( $data['relation'][$uniqueId ] );
		}
	}

	protected function addNotificationToData( &$data, $userId, $wikiId, $notificationData ) {
		$uniqueId = $notificationData['unique_id'];
		$entityKey = $notificationData['entity_key'];
		$isReply = $notificationData['is_reply'];
		$authorId = $notificationData['author_id'];
		$read = $notificationData['is_read'];
		$notifyeveryone = $notificationData['notifyeveryone'];

		// The code will call this method twice for the same notification at times.  Rather than unwind this terrible
		// mess of logic and state, just make sure we don't add the same notification twice.
		static $seen = [];
		if ( $seen[$entityKey] ) {
			return;
		}
		$seen[$entityKey] = true;

		// Add the new $uniqueId and keep track of the index of the new ID in $notificationIndex.  This end/key/reset
		// nonsense is required because of how PHP handles arrays.  Since we unset elements from this array later
		// we create 'holes' in the array and count($array) - 1 no longer reports the last 'key' in the array.
		// See: http://stackoverflow.com/questions/3275082/php-get-index-of-last-inserted-item-in-array
		$data['notification'][] = $uniqueId;
		end( $data['notification'] );
		$notificationIndex = key( $data['notification'] );
		reset( $data['notification'] );

		if ( isset( $data['relation'][ $uniqueId ] ) && $data['relation'][ $uniqueId ]['read'] != true ) {
			if ( empty( $this->uniqueUsers[$entityKey] ) ) {
				$this->uniqueUsers[$entityKey] = [];
			}
			$this->uniqueUsers[$entityKey][$userId] = 1;
		}

		if ( isset( $data['relation'][ $uniqueId ]['last'] ) && $data['relation'][ $uniqueId ]['last'] > -1 ) {
			// remove previous element from the list (to keep proper ordering)
			unset( $data['notification'][ $data['relation'][$uniqueId ]['last'] ] );

		}

		if ( empty($data['relation'][ $uniqueId ]['list']) || $data['relation'][ $uniqueId ]['read'] ) {
			// this is new Notification (new thread), so create some basic structure for it
			$data['relation'][ $uniqueId ]['list'] = [];
			$data['relation'][ $uniqueId ]['count'] = 0;
			$data['relation'][ $uniqueId ]['read'] = false;
		}

		// if there is no count for this Thread notification, create it
		if ( empty( $data['relation'][ $uniqueId ]['count'] ) ) {
			$data['relation'][ $uniqueId ]['count'] = count( $data['relation'][ $uniqueId ]['list'] );
		}

		// keep track of where we are references in Notifications list, so that
		// we can remove that entry and re-add it at the end, should the new
		// notification for that thread come in (to keep proper order)
		$data['relation'][ $uniqueId ]['last'] = $notificationIndex;


		// we are reply and currently stored information is not? ignore new notification
		// but only if we are still unread
		if ( $isReply == true ) {
			if ( $data['relation'][ $uniqueId ]['read'] == false ) {
				foreach ( $data['relation'][ $uniqueId ]['list'] as $rel ) {
					if ( $rel['isReply'] == false ) {
						return;
					}
				}
			} else {
				// we are reply but above wasn't true?
				// so we are adding unread notification to read notifications
				// get rid of all read elements

				// keep track of removed elements - we will remove them from db
				// table after we are done updating in-memory structures
				foreach ( $data['relation'][ $uniqueId ]['list'] as $rel ) {
					$this->removedEntities[] = [
						'user_id' => $userId,
						'wiki_id' => $wikiId,
						'unique_id'=>$uniqueId,
						'entity_key' => $rel['entityKey']
					];
				}
				$data['relation'][ $uniqueId ]['list'] = [];
				$data['relation'][ $uniqueId ]['count'] = 0;
			}
		}

		// scan relation list, remove element that has the same author
		// keep the old one, and remove the new one so that the notification link points to the oldest unread message
		$found = false;

		foreach ( $data['relation'][ $uniqueId ]['list'] as $rel ) {
			if ( $rel['authorId'] == $authorId ) {
				$found = true;

				// Check the $entityKey here to make sure we're not removing an entry we just added
				if ( $rel['entityKey'] != $entityKey ) {
					continue;
				}

				// keep track of removed elements - we will remove them from db
				// table after we are done updating in-memory structures
				$this->removedEntities[] = [
					'user_id' => $userId,
					'wiki_id' => $wikiId,
					'unique_id' => $uniqueId,
					'entity_key' => $entityKey
				];
			}
		}

		// if we didn't find same author in our list, we need to remove oldest element
		if ( $found == false && count( $data['relation'][ $uniqueId ]['list']) > 2 ) {
			$first = array_shift( $data['relation'][ $uniqueId ]['list'] );
			if ( $first ) {
				// keep track of removed elements - we will remove them from db
				// table after we are done updating in-memory structures
				$this->removedEntities[] = [
					'user_id' => $userId,
					'wiki_id' => $wikiId,
					'unique_id'=>$uniqueId,
					'entity_key' => $first['entityKey']
				];
			}
		}

		// if this was new author increase author count
		if ( $found == false ){
			// add new element
			$data['relation'][ $uniqueId ]['list'][] = [
				'entityKey' => $entityKey,
				'authorId' => $authorId,
				'isReply'=>$isReply
			];
			$data['relation'][ $uniqueId ]['count'] += 1;
			$data['relation'][ $uniqueId ]['notifyeveryone'] = $notifyeveryone;
		}

		$data['relation'][ $uniqueId ]['read'] = $read;
	}

	protected function cleanEntitiesFromDB() {
		foreach ( $this->removedEntities as $val ) {
			$this->getDB( true )->delete( 'wall_notification' , $val, __METHOD__ );
		}
		$this->removedEntities = [];
	}

	protected function isCachedData( $userId, $wikiId ) {
		global $wgMemc;

		$key = $this->getKey( $userId, $wikiId );
		$val = $wgMemc->get( $key );

		if ( empty( $val ) && !is_array( $val ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Used internally after acquiring cache entry lock
	 * Tries to fetch the list of notifications from a memcache, and if it's not there,
	 * it fetches it from the database
	 *
	 * @param MemcacheSync $cache
	 * @param $userId
	 * @param $wiki
	 *
	 * @return array|Mixed
	 */
	protected function getData( MemcacheSync $cache, $userId, $wiki ) {
		$val = $cache->get();

		if ( empty( $val ) && !is_array( $val ) ) {
			$val = $this->rebuildData( $userId, $wiki );

			// this normally would be unnessesery (after all everything should be
			// already removed from DB if we are just recreating our structures)
			// however because this "cleaning" functionality was added later it's
			// possible that we will find data to remove in rebuild process
			$this->cleanEntitiesFromDB();
		}

		return $val;
	}

	public function forceRebuild( $userId, $wikiId ) {
		$memcSync = $this->getCache( $userId, $wikiId );
		$memcSync->delete();
	}


	public function rebuildData( $userId, $wikiId ) {
		$data =[
			'notification' => [],
			'relation' => []
		];

		//TODO: solve problem with master slave replication
		$dbData = $this->getBackupData( $userId, $wikiId );

		foreach ( $dbData as $value ) {
			$this->addNotificationToData( $data, $userId, $wikiId, $value );
		}

		return $data;
	}

	/**
	 * Get notification entries from database for specific user on specific wiki
	 * Fetches bot read and unread ones that are not hidden
	 *
	 * @param int $userId
	 * @param int $wikiId
	 *
	 * @return array
	 */
	protected function getBackupData( $userId, $wikiId ) {
		$uniqueIds = [];
		// select distinct Unique_id from wall_notification where user_id = 1 and wiki_id = 1 order by id
		// unique_id field contains page id (like page_id in page table)
		// for many notifications we want to make sure we 50 notifications from different pages hance distinct
		$db = $this->getDB( true );
		$res = $db->select(
			[ 'wn1' => 'wall_notification','wn2' => 'wall_notification' ],
			[ 'wn1.unique_id' ],
			[
				'wn1.user_id' => $userId,
				'wn1.wiki_id' => $wikiId,
				'wn1.is_hidden' => 0,
				'wn2.id' => null
			],
			__METHOD__,
			[
				'LIMIT' => '50',
				'ORDER BY' => 'wn1.id DESC'
			],
			[
				'wn2' => [
					'LEFT JOIN',
					[
						'wn1.user_id = wn2.user_id',
						'wn1.wiki_id = wn2.wiki_id',
						'wn1.is_hidden = wn2.is_hidden',
						'wn1.unique_id = wn2.unique_id',
						'wn2.id < wn1.id'
					]
				],
			]
		);

		while ( $row = $db->fetchRow( $res ) ) {
			$uniqueIds[] = $row['unique_id'];
		}

		$out = [];
		if ( !empty( $uniqueIds ) ) {
			// fetch notification entries for pre fetched unique ids
			$res = $db->select(
				'wall_notification',
				['id', 'is_read', 'is_reply', 'unique_id', 'entity_key', 'author_id', 'notifyeveryone'],
				[
					'user_id' => $userId,
					'wiki_id' => $wikiId,
					'unique_id' => $uniqueIds,
					'is_hidden' => 0
				],
				__METHOD__,
				[ "ORDER BY" => "id" ]
			);

			while ( $row = $db->fetchRow( $res ) ) {
				$out[] = $row;
			}
		}

		return $out;
	}

	public function storeInDB( $userId, $wikiId, $notification ){
		$notification['is_read'] = 0;
		$notification['is_hidden'] = 0;
		$notification['user_id'] = $userId;
		$notification['wiki_id'] = $wikiId;

		$this->getDB(true)->insert( 'wall_notification', $notification, __METHOD__ );
		$this->getDB(true)->commit();
	}

	protected function getCache( $userId, $wikiId ) {
		global $wgMemc;
		return new MemcacheSync( $wgMemc, $this->getKey( $userId, $wikiId ) );
	}

	public function getDB( $master = false ){
		global $wgExternalDatawareDB;
		return wfGetDB( $master ? DB_MASTER:DB_SLAVE, [], $wgExternalDatawareDB );
	}

	public function getLocalDB( $master = false ){
		return wfGetDB( $master ? DB_MASTER:DB_SLAVE, [] );
	}

	public function getKey( $userId, $wikiId ){
		return wfSharedMemcKey( __CLASS__, $userId, $wikiId. 'v31' );
	}

	/**
	 * Get a user object with a given ID (cached results).
	 *
	 * Lots of methods used to construct the objects by themselves even a couple times for the same user.
	 *
	 * @author Władysław Bodzek <wladek@wikia-inc.com>
	 *
	 * @param int $userId User Id
	 * @return User User object
	 */
	protected function getUser( $userId ) {
		if ( !array_key_exists($userId,$this->cachedUsers ) ) {
			$this->cachedUsers[$userId] = User::newFromId($userId);
		}
		return $this->cachedUsers[$userId];
	}

}
