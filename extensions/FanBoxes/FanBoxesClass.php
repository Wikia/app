<?php
/**
 * @file
 * @todo document
 */
class UserFanBoxes {

	var $user_id;	# Text form (spaces not underscores) of the main part
	var $user_name;	# Text form (spaces not underscores) of the main part

	/**
	 * Constructor
	 * @todo FIXME: we could, in theory, drop this function and the private
	 *              class member variables as they are unused in here, we'd
	 *              just need to fix all the callers
	 * @private
	 */
	/* private */ function __construct( $username ) {
		$title1 = Title::newFromDBkey( $username );
		$this->user_name = $title1->getText();
		$this->user_id = User::idFromName( $this->user_name );
	}

	/**
	 * Used on SpecialViewFanBoxes page to get all the user's fanboxes
	 *
	 * @param $type Integer: unused
	 * @param $limit Integer: LIMIT for the SQL query
	 * @param $page Integer: the current page; used to build pagination links
	 *                       and also used here to calculate the OFFSET for the
	 *                       SQL query
	 * @return Array
	 */
	public function getUserFanboxes( $type, $limit = 0, $page = 0 ) {
		$dbr = wfGetDB( DB_SLAVE );

		$params['ORDER BY'] = 'userft_date DESC';
		//$limit_sql = '';
		if( $limit > 0 ) {
			$limitvalue = 0;
			if( $page ) {
				$limitvalue = $page * $limit - ( $limit );
			}
			$params['LIMIT'] = $limit;
			$params['OFFSET'] = $limitvalue;
			//$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}

		$res = $dbr->select(
			array( 'fantag', 'user_fantag' ),
			array(
				'fantag_id',
				'fantag_title',
				'fantag_left_text',
				'fantag_left_textcolor',
				'fantag_left_bgcolor',
				'fantag_right_text',
				'fantag_right_textcolor',
				'fantag_right_bgcolor',
				'userft_date',
				'fantag_image_name',
				'fantag_left_textsize',
				'fantag_right_textsize'
			),
			array( 'userft_user_id' => $this->user_id ),
			__METHOD__,
			$params,
			array( 'user_fantag' => array( 'INNER JOIN', 'userft_fantag_id = fantag_id' ) )
		);

		$userFanboxes = array();
		foreach ( $res as $row ) {
			$userFanboxes[] = array(
				'fantag_id' => $row->fantag_id,
				'fantag_title' => $row->fantag_title,
				'fantag_left_text' => $row->fantag_left_text,
				'fantag_left_textcolor' => $row->fantag_left_textcolor,
				'fantag_left_bgcolor' => $row->fantag_left_bgcolor,
				'fantag_right_text' => $row->fantag_right_text,
				'fantag_right_textcolor' => $row->fantag_right_textcolor,
				'fantag_right_bgcolor' => $row->fantag_right_bgcolor,
				'fantag_image_name' => $row->fantag_image_name,
				'fantag_left_textsize' => $row->fantag_left_textsize,
				'fantag_right_textsize' => $row->fantag_right_textsize
			);
		}

		return $userFanboxes;
	}

	/**
	 * Used on Special:ViewFanBoxes page to get the count of a user's fanboxes
	 * so we can build the prev/next bar
	 *
	 * @param $user_name String: name of the user whose fanbox count we want to
	 *                           get
	 * @return Integer: amount of fanboxes the user has, or 0 if they have none
	 */
	static function getFanBoxCountByUsername( $user_name ) {
		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select(
			'user_fantag',
			array( 'COUNT(*) AS count' ),
			array( 'userft_user_name' => $user_name ),
			__METHOD__,
			array( 'LIMIT' => 1 )
		);
		$row = $dbw->fetchObject( $res );
		$user_fanbox_count = 0;
		if( $row ) {
			$user_fanbox_count = $row->count;
		}
		return $user_fanbox_count;
	}

	/**
	 * Used on Special:ViewFanBoxes to know whether popup box should be Add or
	 * Remove fanbox
	 *
	 * @param $userft_fantag_id Integer: user ID number
	 * @return Integer:
	 */
	public function checkIfUserHasFanbox( $userft_fantag_id ) {
		global $wgUser;
		$dbw = wfGetDB( DB_MASTER );
		$res = $dbw->select(
			'user_fantag',
			array( 'COUNT(*) AS count' ),
			array(
				'userft_user_name' => $wgUser->getName(),
				'userft_fantag_id' => intval( $userft_fantag_id )
			),
			__METHOD__
		);
		$row = $dbw->fetchObject( $res );
		$check_fanbox_count = 0;
		if( $row ) {
			$check_fanbox_count = $row->count;
		}
		return $check_fanbox_count;
	}

}
