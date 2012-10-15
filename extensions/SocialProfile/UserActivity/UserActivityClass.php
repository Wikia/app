<?php
/**
 * UserActivity class
 */
class UserActivity {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */

	private $user_id;       # Text form (spaces not underscores) of the main part
	private $user_name;		# Text form (spaces not underscores) of the main part
	private $items;         # Text form (spaces not underscores) of the main part
	private $rel_type;
	private $show_edits = 1;
	private $show_votes = 0;
	private $show_comments = 1;
	private $show_relationships = 1;
	private $show_gifts_sent = 0;
	private $show_gifts_rec = 1;
	private $show_system_gifts = 1;
	private $show_system_messages = 1;
	private $show_messages_sent = 1;

	/**
	 * Constructor
	 *
	 * @param $username String: username (usually $wgUser's username)
	 * @param $filter String: passed to setFilter(); can be either 'user',
	 *                        'friends', 'foes' or 'all', depending on what
	 *                        kind of information is wanted
	 * @param $item_max Integer: maximum amount of items to display in the feed
	 */
	public function __construct( $username, $filter, $item_max ) {
		if ( $username ) {
			$title1 = Title::newFromDBkey( $username );
			$this->user_name = $title1->getText();
			$this->user_id = User::idFromName( $this->user_name );
		}
		$this->setFilter( $filter );
		$this->item_max = $item_max;
		$this->now = time();
		$this->three_days_ago = $this->now - ( 60 * 60 * 24 * 3 );
		$this->items_grouped = array();
	}

	private function setFilter( $filter ) {
		if ( strtoupper( $filter ) == 'USER' ) {
			$this->show_current_user = true;
		}
		if ( strtoupper( $filter ) == 'FRIENDS' ) {
			$this->rel_type = 1;
		}
		if ( strtoupper( $filter ) == 'FOES' ) {
			$this->rel_type = 2;
		}
		if ( strtoupper( $filter ) == 'ALL' ) {
			$this->show_all = true;
		}
	}

	/**
	 * Sets the value of class member variable $name to $value.
	 */
	public function setActivityToggle( $name, $value ) {
		$this->$name = $value;
	}

	/**
	 * Get recent edits from the recentchanges table and set them in the
	 * appropriate class member variables.
	 */
	private function setEdits() {
		$dbr = wfGetDB( DB_SLAVE );

		$where = array();

		if ( !empty( $this->rel_type ) ) {
			$users = $dbr->select(
				'user_relationship',
				'r_user_id_relation',
				array(
					'r_user_id' => $this->user_id,
					'r_type' => $this->rel_type
				),
				__METHOD__
			);
			$userArray = array();
			foreach ( $users as $user ) {
				$userArray[] = $user;
			}
			$userIDs = implode( ',', $userArray );
			if ( !empty( $userIDs ) ) {
				$where[] = "rc_user IN ($userIDs)";
			}
		}

		if ( !empty( $this->show_current_user ) ) {
			$where['rc_user'] = $this->user_id;
		}

		$res = $dbr->select(
			'recentchanges',
			array(
				'UNIX_TIMESTAMP(rc_timestamp) AS item_date', 'rc_title',
				'rc_user', 'rc_user_text', 'rc_comment', 'rc_id', 'rc_minor',
				'rc_new', 'rc_namespace', 'rc_cur_id', 'rc_this_oldid',
				'rc_last_oldid', 'rc_log_action'
			),
			$where,
			__METHOD__,
			array(
				'ORDER BY' => 'rc_id DESC',
				'LIMIT' => $this->item_max,
				'OFFSET' => 0
			)
		);

		foreach ( $res as $row ) {
			// Special pages aren't editable, so ignore them
			// And blocking a vandal should not be counted as editing said
			// vandal's user page...
			if ( $row->rc_namespace == NS_SPECIAL || $row->rc_log_action != null ) {
				continue;
			}
			$title = Title::makeTitle( $row->rc_namespace, $row->rc_title );
			$this->items_grouped['edit'][$title->getPrefixedText()]['users'][$row->rc_user_text][] = array(
				'id' => 0,
				'type' => 'edit',
				'timestamp' => $row->item_date,
				'pagetitle' => $row->rc_title,
				'namespace' => $row->rc_namespace,
				'username' => $row->rc_user_text,
				'userid' => $row->rc_user,
				'comment' => $this->fixItemComment( $row->rc_comment ),
				'minor' => $row->rc_minor,
				'new' => $row->rc_new
			);

			// set last timestamp
			$this->items_grouped['edit'][$title->getPrefixedText()]['timestamp'] = $row->item_date;

			$this->items[] = array(
				'id' => 0,
				'type' => 'edit',
				'timestamp' => ( $row->item_date ),
				'pagetitle' => $row->rc_title,
				'namespace' => $row->rc_namespace,
				'username' => $row->rc_user_text,
				'userid' => $row->rc_user,
				'comment' => $this->fixItemComment( $row->rc_comment ),
				'minor' => $row->rc_minor,
				'new' => $row->rc_new
			);
		}
	}

	/**
	 * Get recent votes from the Vote table (provided by VoteNY extension) and
	 * set them in the appropriate class member variables.
	 */
	private function setVotes() {
		$dbr = wfGetDB( DB_SLAVE );

		# Bail out if Vote table doesn't exist
		if ( !$dbr->tableExists( 'Vote' ) ) {
			return false;
		}

		$where = array();
		$where[] = 'vote_page_id = page_id';

		if ( $this->rel_type ) {
			$users = $dbr->select(
				'user_relationship',
				'r_user_id_relation',
				array(
					'r_user_id' => $this->user_id,
					'r_type' => $this->rel_type
				),
				__METHOD__
			);
			$userArray = array();
			foreach ( $users as $user ) {
				$userArray[] = $user;
			}
			$userIDs = implode( ',', $userArray );
			if ( !empty( $userIDs ) ) {
				$where[] = "vote_user_id IN ($userIDs)";
			}
		}
		if ( $this->show_current_user ) {
			$where['vote_user_id'] = $this->user_id;
		}

		$res = $dbr->select(
			array( 'Vote', 'page' ),
			array(
				'UNIX_TIMESTAMP(vote_date) AS item_date', 'username',
				'page_title', 'vote_count', 'comment_count', 'vote_ip',
				'vote_user_id'
			),
			$where,
			__METHOD__,
			array(
				'ORDER BY' => 'vote_date DESC',
				'LIMIT' => $this->item_max,
				'OFFSET' => 0
			)
		);

		foreach ( $res as $row ) {
			$username = $row->username;
			$this->items[] = array(
				'id' => 0,
				'type' => 'vote',
				'timestamp' => $row->item_date,
				'pagetitle' => $row->page_title,
				'namespace' => $row->page_namespace,
				'username' => $username,
				'userid' => $row->vote_user_id,
				'comment' => '-',
				'new' => '0',
				'minor' => 0
			);
		}
	}

	/**
	 * Get recent comments from the Comments table (provided by the Comments
	 * extension) and set them in the appropriate class member variables.
	 */
	private function setComments() {
		$dbr = wfGetDB( DB_SLAVE );

		# Bail out if Comments table doesn't exist
		if ( !$dbr->tableExists( 'Comments' ) ) {
			return false;
		}

		$where = array();
		$where[] = 'comment_page_id = page_id';

		if ( !empty( $this->rel_type ) ) {
			$users = $dbr->select(
				'user_relationship',
				'r_user_id_relation',
				array(
					'r_user_id' => $this->user_id,
					'r_type' => $this->rel_type
				),
				__METHOD__
			);
			$userArray = array();
			foreach ( $users as $user ) {
				$userArray[] = $user;
			}
			$userIDs = implode( ',', $userArray );
			if ( !empty( $userIDs ) ) {
				$where[] = "Comment_user_id IN ($userIDs)";
			}
		}

		if ( !empty( $this->show_current_user ) ) {
			$where['Comment_user_id'] = $this->user_id;
		}

		$res = $dbr->select(
			array( 'Comments', 'page' ),
			array(
				'UNIX_TIMESTAMP(comment_date) AS item_date',
				'Comment_Username', 'Comment_IP', 'page_title', 'Comment_Text',
				'Comment_user_id', 'page_namespace', 'CommentID'
			),
			$where,
			__METHOD__,
			array(
				'ORDER BY' => 'comment_date DESC',
				'LIMIT' => $this->item_max,
				'OFFSET' => 0
			)
		);

		foreach ( $res as $row ) {
			$show_comment = true;

			global $wgFilterComments;
			if ( $wgFilterComments ) {
				if ( $row->vote_count <= 4 ) {
					$show_comment = false;
				}
			}

			if ( $show_comment ) {
				$title = Title::makeTitle( $row->page_namespace, $row->page_title );
				$this->items_grouped['comment'][$title->getPrefixedText()]['users'][$row->Comment_Username][] = array(
					'id' => $row->CommentID,
					'type' => 'comment',
					'timestamp' => $row->item_date,
					'pagetitle' => $row->page_title,
					'namespace' => $row->page_namespace,
					'username' => $row->Comment_Username,
					'userid' => $row->Comment_user_id,
					'comment' => $this->fixItemComment( $row->Comment_Text ),
					'minor' => 0,
					'new' => 0
				);

				// set last timestamp
				$this->items_grouped['comment'][$title->getPrefixedText()]['timestamp'] = $row->item_date;

				$username = $row->Comment_Username;
				$this->items[] = array(
					'id' => $row->CommentID,
					'type' => 'comment',
					'timestamp' => $row->item_date,
					'pagetitle' => $row->page_title,
					'namespace' => $row->page_namespace,
					'username' => $username,
					'userid' => $row->Comment_user_id,
					'comment' => $this->fixItemComment( $row->Comment_Text ),
					'new' => '0',
					'minor' => 0
				);
			}
		}
	}

	/**
	 * Get recently sent user-to-user gifts from the user_gift and gift tables
	 * and set them in the appropriate class member variables.
	 */
	private function setGiftsSent() {
		$dbr = wfGetDB( DB_SLAVE );

		$where = array();

		if( $this->rel_type ) {
			$users = $dbr->select(
				'user_relationship',
				'r_user_id_relation',
				array(
					'r_user_id' => $this->user_id,
					'r_type' => $this->rel_type
				),
				__METHOD__
			);
			$userArray = array();
			foreach ( $users as $user ) {
				$userArray[] = $user;
			}
			$userIDs = implode( ',', $userArray );
			if ( !empty( $userIDs ) ) {
				$where[] = "ug_user_id_to IN ($userIDs)";
			}
		}

		if( $this->show_current_user ) {
			$where['ug_user_id_from'] = $this->user_id;
		}

		$res = $dbr->select(
			array( 'user_gift', 'gift' ),
			array(
				'ug_id', 'ug_user_id_from', 'ug_user_name_from',
				'ug_user_id_to', 'ug_user_name_to',
				'UNIX_TIMESTAMP(ug_date) AS item_date', 'gift_name', 'gift_id'
			),
			$where,
			__METHOD__,
			array(
				'ORDER BY' => 'ug_id DESC',
				'LIMIT' => $this->item_max,
				'OFFSET' => 0
			),
			array( 'gift' => array( 'INNER JOIN', 'gift_id = ug_gift_id' ) )
		);

		foreach ( $res as $row ) {
			$this->items[] = array(
				'id' => $row->ug_id,
				'type' => 'gift-sent',
				'timestamp' => $row->item_date,
				'pagetitle' => $row->gift_name,
				'namespace' => $row->gift_id,
				'username' => $row->ug_user_name_from,
				'userid' => $row->ug_user_id_from,
				'comment' => $row->ug_user_name_to,
				'new' => '0',
				'minor' => 0
			);
		}
	}

	/**
	 * Get recently received user-to-user gifts from the user_gift and gift
	 * tables and set them in the appropriate class member variables.
	 */
	private function setGiftsRec() {
		$dbr = wfGetDB( DB_SLAVE );

		$where = array();

		if ( !empty( $this->rel_type ) ) {
			$users = $dbr->select(
				'user_relationship',
				'r_user_id_relation',
				array(
					'r_user_id' => $this->user_id,
					'r_type' => $this->rel_type
				),
				__METHOD__
			);
			$userArray = array();
			foreach ( $users as $user ) {
				$userArray[] = $user;
			}
			$userIDs = implode( ',', $userArray );
			if ( !empty( $userIDs ) ) {
				$where[] = "ug_user_id_to IN ($userIDs)";
			}
		}

		if ( !empty( $this->show_current_user ) ) {
			$where['ug_user_id_to'] = $this->user_id;
		}

		$res = $dbr->select(
			array( 'user_gift', 'gift' ),
			array(
				'ug_id', 'ug_user_id_from', 'ug_user_name_from',
				'ug_user_id_to', 'ug_user_name_to',
				'UNIX_TIMESTAMP(ug_date) AS item_date', 'gift_name', 'gift_id'
			),
			$where,
			__METHOD__,
			array(
				'ORDER BY' => 'ug_id DESC',
				'LIMIT' => $this->item_max,
				'OFFSET' => 0
			),
			array( 'gift' => array( 'INNER JOIN', 'gift_id = ug_gift_id' ) )
		);

		foreach ( $res as $row ) {
			global $wgUploadPath;
			$user_title = Title::makeTitle( NS_USER, $row->ug_user_name_to );
			$user_title_from = Title::makeTitle( NS_USER, $row->ug_user_name_from );

			$gift_image = '<img src="' . $wgUploadPath . '/awards/' .
				Gifts::getGiftImage( $row->gift_id, 'm' ) .
				'" border="0" alt="" />';
			$view_gift_link = SpecialPage::getTitleFor( 'ViewGift' );

			$html = wfMsg( 'useractivity-gift',
				"<b><a href=\"{$user_title->escapeFullURL()}\">{$row->ug_user_name_to}</a></b>",
				"<a href=\"{$user_title_from->escapeFullURL()}\">{$user_title_from->getText()}</a>"
			) .
			"<div class=\"item\">
				<a href=\"" . $view_gift_link->escapeFullURL( 'gift_id=' . $row->ug_id ) . "\" rel=\"nofollow\">
					{$gift_image}
					{$row->gift_name}
				</a>
			</div>";

			$this->activityLines[] = array(
				'type' => 'gift-rec',
				'timestamp' => $row->item_date,
				'data' => ' ' . $html
			);

			$this->items[] = array(
				'id' => $row->ug_id,
				'type' => 'gift-rec',
				'timestamp' => $row->item_date,
				'pagetitle' => $row->gift_name,
				'namespace' => $row->gift_id,
				'username' => $row->ug_user_name_to,
				'userid' => $row->ug_user_id_to,
				'comment' => $row->ug_user_name_from,
				'new' => '0',
				'minor' => 0
			);
		}
	}

	/**
	 * Get recently received system gifts (awards) from the user_system_gift
	 * and system_gift tables and set them in the appropriate class member
	 * variables.
	 */
	private function setSystemGiftsRec() {
		global $wgUploadPath;

		$dbr = wfGetDB( DB_SLAVE );

		$where = array();

		if ( !empty( $this->rel_type ) ) {
			$users = $dbr->select(
				'user_relationship',
				'r_user_id_relation',
				array(
					'r_user_id' => $this->user_id,
					'r_type' => $this->rel_type
				),
				__METHOD__
			);
			$userArray = array();
			foreach ( $users as $user ) {
				$userArray[] = $user;
			}
			$userIDs = implode( ',', $userArray );
			if ( !empty( $userIDs ) ) {
				$where[] = "sg_user_id IN ($userIDs)";
			}
		}

		if ( !empty( $this->show_current_user ) ) {
			$where['sg_user_id'] = $this->user_id;
		}

		$res = $dbr->select(
			array( 'user_system_gift', 'system_gift' ),
			array(
				'sg_id', 'sg_user_id', 'sg_user_name',
				'UNIX_TIMESTAMP(sg_date) AS item_date', 'gift_name', 'gift_id'
			),
			$where,
			__METHOD__,
			array(
				'ORDER BY' => 'sg_id DESC',
				'LIMIT' => $this->item_max,
				'OFFSET' => 0
			),
			array( 'system_gift' => array( 'INNER JOIN', 'gift_id = sg_gift_id' ) )
		);

		foreach ( $res as $row ) {
			$user_title = Title::makeTitle( NS_USER, $row->sg_user_name );
			$system_gift_image = '<img src="' . $wgUploadPath . '/awards/' .
				SystemGifts::getGiftImage( $row->gift_id, 'm' ) .
				'" border="0" alt="" />';
			$system_gift_link = SpecialPage::getTitleFor( 'ViewSystemGift' );

			$html = wfMsg( 'useractivity-award', "<b><a href=\"{$user_title->escapeFullURL()}\">{$row->sg_user_name}</a></b>" ) .
			'<div class="item">
				<a href="' . $system_gift_link->escapeFullURL( 'gift_id=' . $row->sg_id ) . "\" rel=\"nofollow\">
					{$system_gift_image}
					{$row->gift_name}
				</a>
			</div>";

			$this->activityLines[] = array(
				'type' => 'system_gift',
				'timestamp' => $row->item_date,
				'data' => ' ' . $html
			);

			$this->items[] = array(
				'id' => $row->sg_id,
				'type' => 'system_gift',
				'timestamp' => $row->item_date,
				'pagetitle' => $row->gift_name,
				'namespace' => $row->gift_id,
				'username' => $row->sg_user_name,
				'userid' => $row->sg_user_id,
				'comment' => '-',
				'new' => '0',
				'minor' => 0
			);
		}
	}

	/**
	 * Get recent changes in user relationships from the user_relationship
	 * table and set them in the appropriate class member variables.
	 */
	private function setRelationships() {
		global $wgLang;

		$dbr = wfGetDB( DB_SLAVE );

		$where = array();

		if ( !empty( $this->rel_type ) ) {
			$users = $dbr->select(
				'user_relationship',
				'r_user_id_relation',
				array(
					'r_user_id' => $this->user_id,
					'r_type' => $this->rel_type
				),
				__METHOD__
			);
			$userArray = array();
			foreach ( $users as $user ) {
				$userArray[] = $user;
			}
			$userIDs = implode( ',', $userArray );
			if ( !empty( $userIDs ) ) {
				$where[] = "r_user_id IN ($userIDs)";
			}
		}

		if ( !empty( $this->show_current_user ) ) {
			$where['r_user_id'] = $this->user_id;
		}

		$res = $dbr->select(
			'user_relationship',
			array(
				'r_id', 'r_user_id', 'r_user_name', 'r_user_id_relation',
				'r_user_name_relation', 'r_type',
				'UNIX_TIMESTAMP(r_date) AS item_date'
			),
			$where,
			__METHOD__,
			array(
				'ORDER BY' => 'r_id DESC',
				'LIMIT' => $this->item_max,
				'OFFSET' => 0
			)
		);

		foreach ( $res as $row ) {
			if ( $row->r_type == 1 ) {
				$r_type = 'friend';
			} else {
				$r_type = 'foe';
			}

			$user_name_short = $wgLang->truncate( $row->r_user_name, 25 );

			$this->items_grouped[$r_type][$row->r_user_name_relation]['users'][$row->r_user_name][] = array(
				'id' => $row->r_id,
				'type' => $r_type,
				'timestamp' => $row->item_date,
				'pagetitle' => '',
				'namespace' => '',
				'username' => $user_name_short,
				'userid' => $row->r_user_id,
				'comment' => $row->r_user_name_relation,
				'minor' => 0,
				'new' => 0
			);

			// set last timestamp
			$this->items_grouped[$r_type][$row->r_user_name_relation]['timestamp'] = $row->item_date;

			$this->items[] = array(
				'id' => $row->r_id,
				'type' => $r_type,
				'timestamp' => $row->item_date,
				'pagetitle' => '',
				'namespace' => '',
				'username' => $row->r_user_name,
				'userid' => $row->r_user_id,
				'comment' => $row->r_user_name_relation,
				'new' => '0',
				'minor' => 0
			);
		}
	}

	/**
	 * Get recently sent public user board messages from the user_board table
	 * and set them in the appropriate class member variables.
	 */
	private function setMessagesSent() {
		$dbr = wfGetDB( DB_SLAVE );

		$where = array();
		// We do *not* want to display private messages...
		$where['ub_type'] = 0;

		if ( !empty( $this->rel_type ) ) {
			$users = $dbr->select(
				'user_relationship',
				'r_user_id_relation',
				array(
					'r_user_id' => $this->user_id,
					'r_type' => $this->rel_type
				),
				__METHOD__
			);
			$userArray = array();
			foreach ( $users as $user ) {
				$userArray[] = $user;
			}
			$userIDs = implode( ',', $userArray );
			if ( !empty( $userIDs ) ) {
				$where[] = "ub_user_id_from IN ($userIDs)";
			}
		}

		if ( !empty( $this->show_current_user ) ) {
			$where['ub_user_id_from'] = $this->user_id;
		}

		$res = $dbr->select(
			'user_board',
			array(
				'ub_id', 'ub_user_id', 'ub_user_name', 'ub_user_id_from',
				'ub_user_name_from', 'UNIX_TIMESTAMP(ub_date) AS item_date',
				'ub_message'
			),
			$where,
			__METHOD__,
			array(
				'ORDER BY' => 'ub_id DESC',
				'LIMIT' => $this->item_max,
				'OFFSET' => 0
			)
		);

		foreach ( $res as $row ) {
			// Ignore nonexistent (for example, renamed) users
			$uid = User::idFromName( $row->ub_user_name );
			if ( !$uid ) {
				continue;
			}

			$to = stripslashes( $row->ub_user_name );
			$from = stripslashes( $row->ub_user_name_from );
			$this->items_grouped['user_message'][$to]['users'][$from][] = array(
				'id' => $row->ub_id,
				'type' => 'user_message',
				'timestamp' => $row->item_date,
				'pagetitle' => '',
				'namespace' => '',
				'username' => $from,
				'userid' => $row->ub_user_id_from,
				'comment' => $to,
				'minor' => 0,
				'new' => 0
			);

			// set last timestamp
			$this->items_grouped['user_message'][$to]['timestamp'] = $row->item_date;

			$this->items[] = array(
				'id' => $row->ub_id,
				'type' => 'user_message',
				'timestamp' => $row->item_date,
				'pagetitle' => '',
				'namespace' => $this->fixItemComment( $row->ub_message ),
				'username' => $from,
				'userid' => $row->ub_user_id_from,
				'comment' => $to,
				'new' => '0',
				'minor' => 0
			);
		}
	}

	/**
	 * Get recent system messages (i.e. "User Foo advanced to level Bar") from
	 * the user_system_messages table and set them in the appropriate class
	 * member variables.
	 */
	private function setSystemMessages() {
		global $wgLang;

		$dbr = wfGetDB( DB_SLAVE );

		$where = array();

		if ( !empty( $this->rel_type ) ) {
			$users = $dbr->select(
				'user_relationship',
				'r_user_id_relation',
				array(
					'r_user_id' => $this->user_id,
					'r_type' => $this->rel_type
				),
				__METHOD__
			);
			$userArray = array();
			foreach ( $users as $user ) {
				$userArray[] = $user;
			}
			$userIDs = implode( ',', $userArray );
			if ( !empty( $userIDs ) ) {
				$where[] = "um_user_id IN ($userIDs)";
			}
		}

		if ( !empty( $this->show_current_user ) ) {
			$where['um_user_id'] = $this->user_id;
		}

		$res = $dbr->select(
			'user_system_messages',
			array(
				'um_id', 'um_user_id', 'um_user_name', 'um_type', 'um_message',
				'UNIX_TIMESTAMP(um_date) AS item_date'
			),
			$where,
			__METHOD__,
			array(
				'ORDER BY' => 'um_id DESC',
				'LIMIT' => $this->item_max,
				'OFFSET' => 0
			)
		);

		foreach ( $res as $row ) {
			$user_title = Title::makeTitle( NS_USER, $row->um_user_name );
			$user_name_short = $wgLang->truncate( $row->um_user_name, 15 );

			$this->activityLines[] = array(
				'type' => 'system_message',
				'timestamp' => $row->item_date,
				'data' => ' ' . "<b><a href=\"{$user_title->escapeFullURL()}\">{$user_name_short}</a></b> {$row->um_message}"
			);

			$this->items[] = array(
				'id' => $row->um_id,
				'type' => 'system_message',
				'timestamp' => $row->item_date,
				'pagetitle' => '',
				'namespace' => '',
				'username' => $row->um_user_name,
				'userid' => $row->um_user_id,
				'comment' => $row->um_message,
				'new' => '0',
				'minor' => 0
			);
		}
	}

	public function getEdits() {
		$this->setEdits();
		return $this->items;
	}

	public function getVotes() {
		$this->setVotes();
		return $this->items;
	}

	public function getComments() {
		$this->setComments();
		return $this->items;
	}

	public function getGiftsSent() {
		$this->setGiftsSent();
		return $this->items;
	}

	public function getGiftsRec() {
		$this->setGiftsRec();
		return $this->items;
	}

	public function getSystemGiftsRec() {
		$this->setSystemGiftsRec();
		return $this->items;
	}

	public function getRelationships() {
		$this->setRelationships();
		return $this->items;
	}

	public function getSystemMessages() {
		$this->setSystemMessages();
		return $this->items;
	}

	public function getMessagesSent() {
		$this->setMessagesSent();
		return $this->items;
	}

	public function getActivityList() {
		if ( $this->show_edits ) {
			$this->setEdits();
		}
		if ( $this->show_votes ) {
			$this->setVotes();
		}
		if ( $this->show_comments ) {
			$this->setComments();
		}
		if ( $this->show_gifts_sent ) {
			$this->setGiftsSent();
		}
		if ( $this->show_gifts_rec ) {
			$this->setGiftsRec();
		}
		if ( $this->show_relationships ) {
			$this->setRelationships();
		}
		if ( $this->show_system_messages ) {
			$this->getSystemMessages();
		}
		if ( $this->show_system_gifts ) {
			$this->getSystemGiftsRec();
		}
		if ( $this->show_messages_sent ) {
			$this->getMessagesSent();
		}

		if ( $this->items ) {
			usort( $this->items, array( 'UserActivity', 'sortItems' ) );
		}
		return $this->items;
	}

	public function getActivityListGrouped() {
		$this->getActivityList();

		if ( $this->show_edits ) {
			$this->simplifyPageActivity( 'edit' );
		}
		if ( $this->show_comments ) {
			$this->simplifyPageActivity( 'comment' );
		}
		if ( $this->show_relationships ) {
			$this->simplifyPageActivity( 'friend' );
		}
		if ( $this->show_relationships ) {
			$this->simplifyPageActivity( 'foe' );
		}
		if ( $this->show_messages_sent ) {
			$this->simplifyPageActivity( 'user_message' );
		}

		if ( !isset( $this->activityLines ) ) {
			$this->activityLines = array();
		}
		if ( isset( $this->activityLines ) && is_array( $this->activityLines ) ) {
			usort( $this->activityLines, array( 'UserActivity', 'sortItems' ) );
		}
		return $this->activityLines;
	}

	/**
	 * @param $type String: activity type, such as 'friend' or 'foe' or 'edit'
	 * @param $has_page Boolean: true by default
	 */
	function simplifyPageActivity( $type, $has_page = true ) {
		global $wgLang;

		if ( !isset( $this->items_grouped[$type] ) || !is_array( $this->items_grouped[$type] ) ) {
			return '';
		}

		foreach ( $this->items_grouped[$type] as $page_name => $page_data ) {
			$users = '';
			$pages = '';

			if ( $type == 'friend' || $type == 'foe' || $type == 'user_message' ) {
				$page_title = Title::newFromText( $page_name, NS_USER );
			} else {
				$page_title = Title::newFromText( $page_name );
			}

			$count_users = count( $page_data['users'] );
			$user_index = 0;
			$pages_count = 0;

			// Init empty variable to be used later on for GENDER processing
			// if the event is only for one user.
			$userNameForGender = '';

			foreach ( $page_data['users'] as $user_name => $action ) {
				if ( $page_data['timestamp'] < $this->three_days_ago ) {
					continue;
				}

				$count_actions = count( $action );

				if ( $has_page && !isset( $this->displayed[$type][$page_name] ) ) {
					$this->displayed[$type][$page_name] = 1;

					$pages .= " <a href=\"{$page_title->escapeFullURL()}\">{$page_name}</a>";
					if ( $count_users == 1 && $count_actions > 1 ) {
						$pages .= wfMsg( 'word-separator' );
						$pages .= wfMsg( 'parentheses', wfMsgExt(
							"useractivity-group-{$type}",
							'parsemag',
							$count_actions,
							$user_name
						) );
					}
					$pages_count++;
				}

				// Single user on this action,
				// see if we can stack any other singles
				if ( $count_users == 1 ) {
					$userNameForGender = $user_name;
					foreach ( $this->items_grouped[$type] as $page_name2 => $page_data2 ) {
						if ( !isset( $this->displayed[$type][$page_name2] ) &&
							count( $page_data2['users'] ) == 1
						) {
							foreach ( $page_data2['users'] as $user_name2 => $action2 ) {
								if ( $user_name2 == $user_name && $pages_count < 5 ) {
									$count_actions2 = count( $action2 );

									if (
										$type == 'friend' ||
										$type == 'foe' ||
										$type == 'user_message'
									) {
										$page_title2 = Title::newFromText( $page_name2, NS_USER );
									} else {
										$page_title2 = Title::newFromText( $page_name2 );
									}

									if ( $pages ) {
										$pages .= ', ';
									}
									if ( $page_title2 instanceof Title ) {
										$pages .= " <a href=\"{$page_title2->escapeFullURL()}\">{$page_name2}</a>";
									}
									if ( $count_actions2 > 1 ) {
										$pages .= ' (' . wfMsg(
											"useractivity-group-{$type}", $count_actions2
										) . ')';
									}
									$pages_count++;

									$this->displayed[$type][$page_name2] = 1;
								}
							}
						}
					}
				}

				$user_index++;

				if ( $users && $count_users > 2 ) {
					$users .= wfMsg( 'comma-separator' );
				}
				if ( $user_index ==  $count_users && $count_users > 1 ) {
					$users .= wfMsg( 'and' );
				}

				$user_title = Title::makeTitle( NS_USER, $user_name );
				$user_name_short = $wgLang->truncate( $user_name, 15 );

				$safeTitle = htmlspecialchars( $user_title->getText() );
				$users .= " <b><a href=\"{$user_title->escapeFullURL()}\" title=\"{$safeTitle}\">{$user_name_short}</a></b>";
			}
			if ( $pages || $has_page == false ) {
				$this->activityLines[] = array(
					'type' => $type,
					'timestamp' => $page_data['timestamp'],
					'data' => wfMsgExt(
						"useractivity-{$type}",
						'parsemag',
						$users, $count_users, $pages, $pages_count,
						$userNameForGender
					)
				);
			}
		}
	}

	/**
	 * Get the correct icon for the given activity type.
	 *
	 * @param $type String: activity type, such as 'edit' or 'friend' (etc.)
	 * @return String: image file name (images are located in SocialProfile's
	 *                 images/ directory)
	 */
	static function getTypeIcon( $type ) {
		switch( $type ) {
			case 'edit':
				return 'editIcon.gif';
			case 'vote':
				return 'voteIcon.gif';
			case 'comment':
				return 'comment.gif';
			case 'gift-sent':
				return 'icon_package.gif';
			case 'gift-rec':
				return 'icon_package_get.gif';
			case 'friend':
				return 'addedFriendIcon.png';
			case 'foe':
				return 'addedFoeIcon.png';
			case 'system_message':
				return 'challengeIcon.png';
			case 'system_gift':
				return 'awardIcon.png';
			case 'user_message':
				return 'emailIcon.gif';
		}
	}

	/**
	 * "Fixes" a comment (such as a recent changes edit summary) by converting
	 * certain characters (such as the ampersand) into their encoded
	 * equivalents and, if necessary, truncates the comment and finally applies
	 * stripslashes() to the comment.
	 *
	 * @param $comment String: comment to "fix"
	 * @return String: "fixed" comment
	 */
	function fixItemComment( $comment ) {
		global $wgLang;
		if ( !$comment ) {
			return '';
		} else {
			$comment = str_replace( '<', '&lt;', $comment );
			$comment = str_replace( '>', '&gt;', $comment );
			$comment = str_replace( '&', '%26', $comment );
			$comment = str_replace( '%26quot;', '"', $comment );
		}
		$preview = $wgLang->truncate( $comment, 75 );
		return stripslashes( $preview );
	}

	/**
	 * Compares the timestamps of two given objects to decide how to sort them.
	 * Called by getActivityList() and getActivityListGrouped().
	 *
	 * @param $x Object
	 * @param $y Object
	 * @return Integer: 0 if the timestamps are the same, -1 if $x's timestamp
	 *                  is greater than $y's, else 1
	 */
	private static function sortItems( $x, $y ) {
		if( $x['timestamp'] == $y['timestamp'] ) {
			return 0;
		} elseif ( $x['timestamp'] > $y['timestamp'] ) {
			return -1;
		} else {
			return 1;
		}
	}
}
