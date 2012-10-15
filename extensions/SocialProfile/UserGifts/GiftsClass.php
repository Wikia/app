<?php
/**
 * Gifts class
 * Functions for managing individual social gifts
 * (add to/fetch/remove from database etc.)
 */
class Gifts {

	/**
	 * Constructor
	 */
	public function __construct() {}

	/**
	 * Adds a gift to the database
	 * @param $gift_name Mixed: name of the gift, as supplied by the user
	 * @param $gift_description Mixed: a short description about the gift, as supplied by the user
	 * @param $gift_access Integer: 0 by default
	 */
	static function addGift( $gift_name, $gift_description, $gift_access = 0 ) {
		global $wgUser;

		$dbw = wfGetDB( DB_MASTER );

		$dbw->insert(
			'gift',
			array(
				'gift_name' => $gift_name,
				'gift_description' => $gift_description,
				'gift_createdate' => date( 'Y-m-d H:i:s' ),
				'gift_creator_user_id' => $wgUser->getID(),
				'gift_creator_user_name' => $wgUser->getName(),
				'gift_access' => $gift_access,
			), __METHOD__
		);
		return $dbw->insertId();
	}

	/**
	 * Updates a gift's info in the database
	 * @param $id Integer: internal ID number of the gift that we want to update
	 * @param $gift_name Mixed: name of the gift, as supplied by the user
	 * @param $gift_description Mixed: a short description about the gift, as supplied by the user
	 * @param $gift_access Integer: 0 by default
	 */
	public function updateGift( $id, $gift_name, $gift_description, $access = 0 ) {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update( 'gift',
			/* SET */array(
				'gift_name' => $gift_name,
				'gift_description' => $gift_description,
				'gift_access' => $access
			),
			/* WHERE */array( 'gift_id' => $id ),
			__METHOD__
		);
	}

	/**
	 * Gets information, such as name and description, about a given gift from the database
	 * @param $id Integer: internal ID number of the gift
	 * @return Gift information, including ID number, name, description, creator's user name and ID and gift access
	 */
	static function getGift( $id ) {
		if ( !is_numeric( $id ) ) {
			return '';
		}
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'gift',
			array(
				'gift_id', 'gift_name', 'gift_description',
				'gift_creator_user_id', 'gift_creator_user_name', 'gift_access'
			),
			array( "gift_id = {$id}" ),
			__METHOD__,
			array( 'LIMIT' => 1, 'OFFSET' => 0 )
		);
		$row = $dbr->fetchObject( $res );
		$gift = array();
		if ( $row ) {
			$gift['gift_id'] = $row->gift_id;
			$gift['gift_name'] = $row->gift_name;
			$gift['gift_description'] = $row->gift_description;
			$gift['creator_user_id'] = $row->gift_creator_user_id;
			$gift['creator_user_name'] = $row->gift_creator_user_name;
			$gift['access'] = $row->gift_access;
		}
		return $gift;
	}

	static function getGiftImage( $id, $size ) {
		global $wgUploadDirectory;
		$files = glob( $wgUploadDirectory . '/awards/' . $id .  '_' . $size . "*" );

		if ( !empty( $files[0] ) ) {
			$img = basename( $files[0] );
		} else {
			$img = 'default_' . $size . '.gif';
		}
		return $img . '?r=' . rand();
	}

	static function getGiftList( $limit = 0, $page = 0, $order = 'gift_createdate DESC' ) {
		global $wgUser;

		$dbr = wfGetDB( DB_SLAVE );
		$params = array();

		if ( $limit > 0 ) {
			$limitvalue = 0;
			if ( $page ) {
				$limitvalue = $page * $limit - ( $limit );
			}
			$params['LIMIT'] = $limit;
			$params['OFFSET'] = $limitvalue;
		}

		$params['ORDER BY'] = $order;
		$res = $dbr->select(
			'gift',
			array(
				'gift_id', 'gift_createdate', 'gift_name', 'gift_description',
				'gift_given_count'
			),
			array( "gift_access = 0 OR gift_creator_user_id = {$wgUser->getID()}" ),
			__METHOD__,
			$params
		);

		$gifts = array();
		foreach ( $res as $row ) {
			$gifts[] = array(
				'id' => $row->gift_id,
				'timestamp' => ( $row->gift_createdate ),
				'gift_name' => $row->gift_name,
				'gift_description' => $row->gift_description,
				'gift_given_count' => $row->gift_given_count
			);
		}
		return $gifts;
	}

	static function getManagedGiftList( $limit = 0, $page = 0 ) {
		global $wgUser;
		$dbr = wfGetDB( DB_SLAVE );

		$where = ''; // Prevent E_NOTICE
		$params['ORDER BY'] = 'gift_createdate';
		if ( $limit ) {
			$params['LIMIT'] = $limit;
		}

		// If the user isn't allowed to perform administrative tasks to gifts
		// and isn't allowed to delete pages, only show them the gifts they've
		// created
		if ( !$wgUser->isAllowed( 'giftadmin' ) && !$wgUser->isAllowed( 'delete' ) ) {
			$where = array( 'gift_creator_user_id' => $wgUser->getID() );
		}

		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'gift',
			array(
				'gift_id', 'gift_createdate', 'gift_name', 'gift_description',
				'gift_given_count', 'gift_access', 'gift_creator_user_id',
				'gift_creator_user_name'
			),
			$where,
			__METHOD__,
			$params
		);

		$gifts = array();
		foreach ( $res as $row ) {
			$gifts[] = array(
				'id' => $row->gift_id,
				'timestamp' => ( $row->gift_createdate ),
				'gift_name' => $row->gift_name,
				'gift_description' => $row->gift_description,
				'gift_given_count' => $row->gift_given_count
			);
		}
		return $gifts;
	}

	static function getCustomCreatedGiftCount( $user_id ) {
		$dbr = wfGetDB( DB_SLAVE );
		$gift_count = 0;
		$s = $dbr->selectRow(
			'gift',
			array( 'COUNT(gift_id) AS count' ),
			array( 'gift_creator_user_id' => $user_id ),
			__METHOD__
		);
		if ( $s !== false ) {
			$gift_count = $s->count;
		}
		return $gift_count;
	}

	static function getGiftCount() {
		$dbr = wfGetDB( DB_SLAVE );
		$gift_count = 0;
		$s = $dbr->selectRow(
			'gift',
			array( 'COUNT(gift_id) AS count' ),
			array( 'gift_given_count' => $gift_count ),
			__METHOD__
		);
		if ( $s !== false ) {
			$gift_count = $s->count;
		}
		return $gift_count;
	}
}
