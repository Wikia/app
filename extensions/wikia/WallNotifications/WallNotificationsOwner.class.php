<?php

class WallNotificationsOwner {

	public function __construct() {
		$this->app = F::App();
	}

	/*
	 * Public Interface
	 */
	public function getOwnerNotifications( $wikiId, $userId ) {
		$key = $this->getKey( $wikiId, $userId );
		$val = $this->getCache()->get( $key );
		if ( empty( $val ) ) {
			$val = [];
		}

		return array_reverse( $val );

	}

	public function addOwnerNotificationFromEntity( $notif ) {
		$wikiId = $notif->data->wiki_id;
		$userId = $notif->data->user_wallowner_id;
		$removingUserId = $notif->data->user_removing_id;

		if ( $userId == $removingUserId ) {
			// don't notify yourself if you are deleting stuff on your wall
			return;
		}

		$key = $this->getKey( $wikiId, $userId );
		$val = $this->getCache()->get( $key );
		if ( empty( $val ) ) {
			$val = [];
		}

		$val[] = [ 'grouped' => [ $notif ], 'count' => '1' ];

		$this->getCache()->set( $key, $val );

	}

	public function removeForThread( $wikiId, $userId, $messageId ) {
		$key = $this->getKey( $wikiId, $userId );
		$val = $this->getCache()->get( $key );
		if ( empty( $val ) ) {
			$val = [];
		}
		foreach ( $val as $ref => $notif ) {
			if ( !empty( $notif['grouped'] ) ) {
				$id = 	$notif['grouped'][0]->data->parent_id == 0
						? $notif['grouped'][0]->data->message_id
						: $notif['grouped'][0]->data->parent_id;

				if ( $id ==  $messageId ) {
					unset( $val[$ref] );
				}
			}
		}

		$this->getCache()->set( $key, $val );
	}

	public function removeForReply( $wikiId, $userId, $messageId ) {
		$key = $this->getKey( $wikiId, $userId );
		$val = $this->getCache()->get( $key );
		if ( empty( $val ) ) {
			$val = [];
		}
		foreach ( $val as $ref => $notif ) {
			if ( !empty( $notif['grouped'] ) ) {
				$id = $notif['grouped'][0]->data->message_id;

				if ( $id ==  $messageId ) {
					unset( $val[$ref] );
				}
			}
		}

		$this->getCache()->set( $key, $val );
	}

	public function removeAll( $wikiId, $userId ) {
		$key = $this->getKey( $wikiId, $userId );
		$val = $this->getCache()->get( $key );
		if ( empty( $val ) ) {
			return false;
		}
		$wasUnread = false;
		foreach ( $val as $ref => $notif ) {
			if ( !empty( $notif['grouped'] ) ) {
				unset( $val[$ref] );
				$wasUnread = true;
			}
		}

		$this->getCache()->set( $key, $val );
		return $wasUnread;
	}

	/*
	 * Private
	 */
	protected function getCache() {
		global $wgMemc;
		return $wgMemc;
	}

	public function getKey( $wikiId, $userId ) {
		return wfSharedMemcKey( __CLASS__, $wikiId . '_' . $userId . 'v11' );
	}


}