<?php

class WallNotificationsAdmin {
	var $cityId;

	public function __construct() {
		global $wgCityId;

		$this->app = F::App();
		$this->cityId = $wgCityId;
	}

	/*
	 * Public Interface
	 */
	public function getAdminNotifications( $wikiId, $currentUserId = null ) {
		// admin notifications are wiki specific, not user-specific
		// as soon as one person reads them no other admin will see them

		if ( $this->cityId != $wikiId ) {
			return [];
		}

		$key = $this->getKey( $wikiId );
		$val = $this->getCache()->get( $key );

		if ( empty( $val ) ) {
			$val = [];
		}

		foreach ( $val as $ref => $notif ) {
			if ( !empty( $notif['grouped'] ) && isset( $notif['grouped'][0]->data->hide_for_userid[$currentUserId] ) ) {
				unset( $val[$ref] );
			}
		}

		return array_reverse( $val );

	}

	public function addAdminNotificationFromEntity( $notif ) {
		$wikiId = $notif->data->wiki_id;

		$key = $this->getKey( $wikiId );
		$val = $this->getCache()->get( $key );
		if ( empty( $val ) ) {
			$val = [];
		}

		$val[] = [ 'grouped' => [ $notif ], 'count' => '1' ];

		$this->getCache()->set( $key, $val );

	}

	public function removeAll( $wikiId ) {
		$key = $this->getKey( $wikiId );
		$this->getCache()->set( $key, [] );

	}

	public function removeForThread( $wikiId, $messageId ) {
		$key = $this->getKey( $wikiId );
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

	public function removeForReply( $wikiId, $messageId ) {
		$key = $this->getKey( $wikiId );
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

	public function hideAdminNotifications( $wikiId, $userId ) {
		$key = $this->getKey( $wikiId );
		$val = $this->getCache()->get( $key );
		if ( empty( $val ) ) {
			$val = [];
		}

		$hidden = false;

		foreach ( $val as $notif ) {
			if ( !empty( $notif['grouped'] ) && !isset( $notif['grouped'][0]->data->hide_for_userid[$userId] ) ) {
				$notif['grouped'][0]->data->hide_for_userid[$userId] = true;
				$hidden = true;
			}
		}

		$this->getCache()->set( $key, $val );

		return $hidden;
	}

	/*
	 * Private
	 */
	protected function getCache() {
		global $wgMemc;
		return $wgMemc;
	}

	public function getKey( $wikiId ) {
		return wfSharedMemcKey( __CLASS__, $wikiId . 'v11' );
	}


}