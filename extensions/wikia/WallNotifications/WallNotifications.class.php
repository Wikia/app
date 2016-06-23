<?php

use Wikia\Logger\WikiaLogger;

/**
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
	const MAX_ABSTRACT_LENGTH = 3000;
	const TTL = 300; // 5 minutes

	/**
	 * @var WikiaApp
	 */
	protected $app;

	private $cachedUsers = [];
	private $removedEntities;
	private $uniqueUsers = []; // used for since read email.

	public function __construct() {
		$this->app = F::app();
		$this->removedEntities = [];
	}

	/**
	 * Get all notifications for a user on a wiki
	 *
	 * @param int $userId The user ID receiving notifications
	 * @param int $wikiId The wikia on which the notifications originated
	 * @param int $readSlice Max number of already read messages to show
	 * @param bool $countOnly Set to true to only return a count.  This should be split out to another function
	 * @param bool $notifyEveryone
	 *
	 * @return array|Mixed
	 */
	public function getWikiNotifications( $userId, $wikiId, $readSlice = 5, $countOnly = false, $notifyEveryone = false ) {

		$list = $this->getWikiNotificationList( $userId, $wikiId );
		if ( empty( $list ) ) {
			return [];
		}

		$read = [];
		$unread = [];
		$cacheCleared = false;

		// walk through list of ids from wall_notification table in DB
		foreach ( array_reverse( $list['notification'] ) as $notifyUniqueId ) {
			$notifyRelation = $list['relation'][$notifyUniqueId];

			if ( empty( $notifyUniqueId ) ) {
				continue;
			}

			$grouped = [];
			if ( !$countOnly ) {
				$grouped = $this->groupEntity( $notifyRelation['list'] );

				if ( empty( $grouped ) ) {
					continue;
				}
			}

			if ( $notifyRelation['read'] ) {
				if ( count( $read ) < $readSlice ) {
					$read[] = [
						"grouped" => $grouped,
						"count" => 	empty( $notifyRelation['count'] )
									? count( $notifyRelation['list'] )
									: $notifyRelation['count']
					];
				} elseif ( $readSlice > 0 ) {
					// so we have more read notifications that we need for display
					// remove them
					$this->remNotificationsForUniqueID( $userId, $wikiId, $notifyUniqueId );

					// After removing the notifications above, make sure we don't still
					// have them in this cache and thus try to remove them again. SOC-815
					if ( !$cacheCleared ) {
						$this->clearWikiNotificationListCache( $userId, $wikiId );
						$cacheCleared = true;
					}
				}
			} else {
				if ( empty( $notifyRelation['notifyeveryone'] ) || $notifyEveryone ) {
					$unread[] = [
						"grouped" => $grouped,
						"count" => 	empty( $notifyRelation['count'] )
									? count( $notifyRelation['list'] )
									: $notifyRelation['count']
					];
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
			'unread' => $unread,
			'unread_count' => count( $unread ),
			'read' => $read,
			'read_count' => count( $read )
		];

		return $out;
	}

	private function getWikiNotificationList( $userId, $wikiId ) {
		$memcSync = $this->getCache( $userId, $wikiId );

		// try fetching the list of notifications from memcache
		$list = $memcSync->get();
		if ( empty( $list ) && !is_array( $list ) ) {
			// nothing in the cache, so use the db as a fallback and store the result in cache
			$callback = function() use( $userId, $wikiId, &$list ) {
				$list = $this->rebuildData( $userId, $wikiId, false );
				return $list;
			};

			// this memcache data is synchronized so we're making sure nothing else is modifying it at the same time
			// we're using the same callback when we cannot acquire the lock, as we want to have the list of notifications
			// even if we won't be able to store it in the cache
			$memcSync->lockAndSetData( $callback, $callback );
		}

		return $list;
	}

	private function clearWikiNotificationListCache( $userId, $wikiId ) {
		$memcSync = $this->getCache( $userId, $wikiId );
		$memcSync->delete();
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
		return WikiaDataAccess::cache(
			$this->getCountsCacheKey( $userId ),
			self::TTL,
			function() use ( $userId ) {
				global $wgMemc, $wgCityId;

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
					if ( $wiki['unread'] > 0 || $wiki['id'] == $wgCityId ) {
						$output[] = $wiki;
					}
				}
				return $output;
			}
		);
	}

	private function getCountsCacheKey( $userId ) {
		return wfMemcKey( __CLASS__, 'getCounts', $userId );
	}

	private function purgeCountsCache( $userId ) {
		WikiaDataAccess::cachePurge( $this->getCountsCacheKey( $userId ) );
	}

	private function sortByTimestamp( $array ) {
		uasort( $array, [ $this, 'sortByTimestampCB' ] );

		return $array;
	}

	private function sortByTimestampCB( $a, $b ) {
		if ( !empty( $a['grouped'] ) && !empty( $b['grouped'] ) ) {
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
		WikiFactory::prefetchWikisById( array_keys( $val ), WikiFactory::PREFETCH_VARIABLES );
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

	protected function groupEntity( $list ) {
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
		$title = $notification->parentTitleDbKey;
		$notifData = $notification->data;

		if ( !empty( $notifData->article_title_ns ) ) {
			$users = $this->getWatchlist( $notifData->wall_username, $title, $notifData->article_title_ns );
		} else {
			$users = $this->getWatchlist( $notifData->wall_username, $title );
		}

		// FB:#11089
		$users[$notifData->wall_userid] = $notifData->wall_userid;

		if ( !empty( $users[$notifData->msg_author_id] ) ) {
			unset( $users[$notifData->msg_author_id] );
		}

		$this->addNotificationLinks( $users, $notification );
		$this->sendEmails( array_keys( $users ), $notification );
	}

	protected function sendEmails( array $watchers, WallNotificationEntity $notification ) {
		$text = $this->getAbstract( $notification->msgText );

		$entityKey = $notification->id;
		$notifData = $notification->data;

		if ( empty( $this->uniqueUsers[$entityKey] ) ) {
			$this->uniqueUsers[$entityKey] = [];
		}

		foreach ( $watchers as $watcherUserId ) {
			$watcher = $this->getUser( $watcherUserId );

			if ( !$this->canSendToWatcher( $watcher, $entityKey ) ) {
				continue;
			}

			$watcherName = $watcher->getName();
			$controller = $this->getEmailExtensionController( $notification, $watcherName );

			$params = [
				'boardNamespace' => $notifData->article_title_ns,
				'boardTitle' => $notifData->article_title_text,
				'titleText' => $notifData->thread_title,
				'titleUrl' => $notifData->url,
				'details' => $text,
				'targetUser' => $watcherName,
				'wallUserName' => $notifData->wall_username,
				'threadId' => $notifData->title_id,
				'parentId' => $notifData->parent_id,
			];

			F::app()->sendRequest( $controller, 'handle', $params );
		}

		return true;
	}

	protected function canSendToWatcher( User $watcher, $entityKey ) {
		if ( $watcher->getId() == 0 ) {
			return false;
		}

		// Don't send an email to users that unsubscribed their email address
		if ( (bool)$watcher->getGlobalPreference( 'unsubscribed' ) === true ) {
			return false;
		}

		$mode = $watcher->getGlobalPreference( 'enotifwallthread' );
		if ( empty( $mode ) ) {
			return false;
		}

		if ( $mode == WALL_EMAIL_EVERY ) {
			return true;
		}

		if ( $mode == WALL_EMAIL_SINCEVISITED ) {
			return empty( $this->uniqueUsers[$entityKey][$watcher->getId()] );
		}

		return false;
	}

	protected function getEmailExtensionController( WallNotificationEntity $notification, $watcherName ) {
		if ( !empty( $notification->data->article_title_ns )
			&& MWNamespace::getSubject( $notification->data->article_title_ns ) == NS_WIKIA_FORUM_BOARD
		) {
			if ( $notification->isMain() ) {
				$controller = Email\Controller\ForumController::class;
			} else {
				$controller = Email\Controller\ReplyForumController::class;
			}
		} else if ( $notification->isMain() && $notification->data->wall_username != $watcherName ) {
			$controller = Email\Controller\FollowedWallMessageController::class;
		} else if ( !$notification->isMain() ) {
			$controller = Email\Controller\ReplyWallMessageController::class;
		} else {
			$controller = Email\Controller\OwnWallMessageController::class;
		}

		return $controller;
	}

	/**
	 * Get abstract from whole entity text.
	 * HTML tags are stripped out, except <p> <br> which are used to make it easier to read.
	 *
	 * @param $text
	 * @return string
	 */
	private function getAbstract( $text ) {
		$text = strip_tags( $text, '<p><br>' );
		$text = mb_substr( $text, 0, self::MAX_ABSTRACT_LENGTH, 'UTF-8' )
			. ( mb_strlen( $text, 'UTF-8' ) > self::MAX_ABSTRACT_LENGTH ? '...' : '' );

		return $text;
	}

	protected function getWatchlist( $name, $titleDbkey, $ns = NS_USER_WALL ) {
		// TODO: add some caching
		$userTitle = Title::newFromText( $name, MWNamespace::getSubject( $ns ) );
		if ( empty( $userTitle ) ) {
			WikiaLogger::instance()->error( 'User page is non-existent', [
				'issue' => 'SOC-1070',
				'name' => $name,
				'ns' => $ns,
			] );
			return [];
		}

		$dbw = $this->getLocalDB( true );
		$res = $dbw->select(
			['watchlist' ],
			[ 'wl_user' ],
			[
				'wl_title' => [ $titleDbkey, $userTitle->getDBkey() ],
				'wl_namespace' => [ MWNamespace::getSubject( $ns ), MWNamespace::getTalk( $ns ) ],
				// THIS hack will be removed after running script with will clear all notification copy
				// FYI diff for this 3 year old hack: https://github.com/Wikia/app/commit/affdeb1557b2479b9819da1a5f8daacb4dab0bf9
                "((wl_wikia_addedtimestamp > '2012-01-31' and wl_namespace = " . MWNamespace::getSubject( $ns ) . ") or ( wl_namespace = " . MWNamespace::getTalk( $ns ) . " ))"
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
		$notifData = $notification->data;

		$this->addNotificationLinkInternal(
			$userId,
			$notifData->wiki,
			[
				'unique_id' => $notification->getUniqueId(),
				'entity_key' => $notification->id,
				'author_id' => $notifData->msg_author_id,
				'is_reply' => $notification->isReply(),
				'notifyeveryone' => $notifData->notifyeveryone
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

				if ( $id == 0 && !empty( $data['relation'] ) ) {
					$ids = array_keys( $data['relation'] );
				} else {
					$ids = [ $id ];
				}

				foreach ( $ids as $value ) {
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
		$this->purgeCountsCache( $userId );

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

			if ( $this->isCachedData( $uId, $wikiId ) ) {
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

		$this->purgeCountsCache( $userId );
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
		// id use to prevent having of extra entry after memc fail.

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

		$this->purgeCountsCache( $userId );

		$this->cleanEntitiesFromDB();
	}

	protected function random_msleep( $max = 20 ) {
		usleep( rand( 1, $max * 1000 ) );
	}

	protected function remNotificationFromData( &$data, $uniqueId ) {
		if ( isset( $data['relation'][ $uniqueId ]['last'] ) && $data['relation'][ $uniqueId ]['last'] > -1 ) {
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
		if ( !empty( $seen[$entityKey][$userId] ) ) {
			return;
		}
		$seen[$entityKey][$userId] = true;

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

		if ( empty( $data['relation'][ $uniqueId ]['list'] ) || $data['relation'][ $uniqueId ]['read'] ) {
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
						'unique_id' => $uniqueId,
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

				// Check the $entityKey here to make sure we're not removing an entry we just added
				if ( $rel['entityKey'] != $entityKey ) {
					continue;
				}

				$found = true;

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
		if ( $found == false && count( $data['relation'][ $uniqueId ]['list'] ) > 2 ) {
			$first = array_shift( $data['relation'][ $uniqueId ]['list'] );
			if ( $first ) {
				// keep track of removed elements - we will remove them from db
				// table after we are done updating in-memory structures
				$this->removedEntities[] = [
					'user_id' => $userId,
					'wiki_id' => $wikiId,
					'unique_id' => $uniqueId,
					'entity_key' => $first['entityKey']
				];
			}
		}

		// if this was new author increase author count
		if ( $found == false ) {
			// add new element
			$data['relation'][ $uniqueId ]['list'][] = [
				'entityKey' => $entityKey,
				'authorId' => $authorId,
				'isReply' => $isReply
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
	 * @param $useMaster
	 *
	 * @return array|Mixed
	 */
	protected function getData( MemcacheSync $cache, $userId, $wiki, $useMaster = true ) {
		$val = $cache->get();

		if ( empty( $val ) && !is_array( $val ) ) {
			$val = $this->rebuildData( $userId, $wiki, $useMaster );

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


	public function rebuildData( $userId, $wikiId, $useMaster = true ) {
		$data = [
			'notification' => [],
			'relation' => []
		];

		$dbData = $this->getBackupData( $userId, $wikiId, $useMaster );

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
	 * @param bool $useMaster
	 *
	 * @return array
	 */
	protected function getBackupData( $userId, $wikiId, $useMaster = true ) {
		$uniqueIds = [];
		// select distinct Unique_id from wall_notification where user_id = 1 and wiki_id = 1 order by id
		// unique_id field contains page id (like page_id in page table)
		// for many notifications we want to make sure we 50 notifications from different pages hance distinct
		$db = $this->getDB( $useMaster );
		$res = $db->select(
			'wall_notification',
			'unique_id' ,
			[
				'user_id' => $userId,
				'wiki_id' => $wikiId,
				'is_hidden' => 0,
			],
			__METHOD__,
			[
				'DISTINCT',
				'LIMIT' => '50',
				'ORDER BY' => 'unique_id DESC'
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

	public function storeInDB( $userId, $wikiId, $notification ) {
		$notification['is_read'] = 0;
		$notification['is_hidden'] = 0;
		$notification['user_id'] = $userId;
		$notification['wiki_id'] = $wikiId;

		WikiaLogger::instance()->info( 'New Wall Notification created', [
			'wikiId' => $wikiId,
			'userId' => $userId
		] );

		$this->getDB( true )->insert( 'wall_notification', $notification, __METHOD__ );
		$this->getDB( true )->commit();
	}

	protected function getCache( $userId, $wikiId ) {
		global $wgMemc;
		return new MemcacheSync( $wgMemc, $this->getKey( $userId, $wikiId ) );
	}

	public function getDB( $master = false ) {
		global $wgExternalDatawareDB;
		return wfGetDB( $master ? DB_MASTER: DB_SLAVE, [], $wgExternalDatawareDB );
	}

	public function getLocalDB( $master = false ) {
		return wfGetDB( $master ? DB_MASTER: DB_SLAVE, [] );
	}

	public function getKey( $userId, $wikiId ) {
		return wfSharedMemcKey( __CLASS__, $userId, $wikiId . 'v32' );
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
		if ( !array_key_exists( $userId, $this->cachedUsers ) ) {
			$this->cachedUsers[$userId] = User::newFromId( $userId );
		}
		return $this->cachedUsers[$userId];
	}
}
