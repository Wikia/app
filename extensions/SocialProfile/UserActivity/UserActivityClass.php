<?php
/**
 * UserActivity class
 * @todo FIXME: database queries should use Database class
 */
class UserActivity {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */

	/**#@+
	 * @private
	 */
	var $user_id;       # Text form (spaces not underscores) of the main part
	var $user_name;		# Text form (spaces not underscores) of the main part
	var $items;         # Text form (spaces not underscores) of the main part
	var $rel_type;
	var $show_edits = 1;
	var $show_votes = 0;
	var $show_comments = 1;
	var $show_relationships = 1;
	var $show_gifts_sent = 0;
	var $show_gifts_rec = 1;
	var $show_system_gifts = 1;
	var $show_system_messages = 1;
	var $show_messages_sent = 1;

	/**
	 * Constructor
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

	public function setActivityToggle( $name, $value ) {
		$this->$name = $value;
	}

	private function setEdits() {
		$dbr = wfGetDB( DB_SLAVE );
		$rel_sql = '';
		$user_sql = '';

		if ( !empty( $this->rel_type ) ) {
			$rel_sql = " WHERE rc_user IN (SELECT r_user_id_relation FROM {$dbr->tableName( 'user_relationship' )} WHERE r_user_id={$this->user_id} AND r_type={$this->rel_type}) ";
		}

		if ( !empty( $this->show_current_user ) ) {
			$user_sql = " WHERE rc_user = {$this->user_id}";
		}

		$sql = "SELECT UNIX_TIMESTAMP(rc_timestamp) AS item_date, rc_title,
				rc_user, rc_user_text, rc_comment, rc_id, rc_minor, rc_new,
				rc_namespace, rc_cur_id, rc_this_oldid, rc_last_oldid
			FROM {$dbr->tableName( 'recentchanges' )}
			{$rel_sql} {$user_sql}
			ORDER BY rc_id DESC LIMIT 0," . $this->item_max;
		$res = $dbr->query( $sql, __METHOD__ );

		foreach ( $res as $row ) {
			// Special pages aren't editable, so ignore them
			if ( $row->rc_namespace == NS_SPECIAL ) {
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

	private function setVotes() {
		$dbr = wfGetDB( DB_SLAVE );

		# Bail out if Vote table doesn't exist
		if ( !$dbr->tableExists( 'Vote' ) ) {
			return false;
		}

		$rel_sql = '';
		$user_sql = '';
		if ( $this->rel_type ) {
			$rel_sql = " AND vote_user_id IN (SELECT r_user_id_relation FROM {$dbr->tableName( 'user_relationship' )} WHERE r_user_id={$this->user_id} AND r_type={$this->rel_type}) ";
		}
		if ( $this->show_current_user ) {
			$user_sql = " AND vote_user_id = {$this->user_id}";
		}

		$sql = "SELECT UNIX_TIMESTAMP(vote_date) AS item_date, username,
					page_title, vote_count, comment_count, vote_ip,
					vote_user_id
			FROM {$dbr->tableName( 'Vote' )} v, {$dbr->tableName( 'page' )} p
			WHERE v.vote_page_id=p.page_id
			{$rel_sql} {$user_sql}
			ORDER BY vote_date DESC LIMIT 0," . $this->item_max;
		$res = $dbr->query( $sql, __METHOD__ );
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

	private function setComments() {
		$dbr = wfGetDB( DB_SLAVE );

		# Bail out if Comments table doesn't exist
		if ( !$dbr->tableExists( 'Comments' ) ) {
			return false;
		}

		$rel_sql = '';
		$user_sql = '';

		if ( !empty( $this->rel_type ) ) {
			$rel_sql = "AND Comment_user_id IN (SELECT r_user_id_relation FROM {$dbr->tableName( 'user_relationship' )} WHERE r_user_id={$this->user_id} AND r_type={$this->rel_type})";
		}

		if ( !empty( $this->show_current_user ) ) {
			$user_sql = "AND Comment_user_id = {$this->user_id}";
		}

		$sql = "SELECT UNIX_TIMESTAMP(comment_date) AS item_date,
					Comment_Username, Comment_IP, page_title, Comment_Text,
					Comment_user_id, page_namespace, CommentID
			FROM {$dbr->tableName( 'Comments' )} c, {$dbr->tableName( 'page' )} p
			WHERE c.comment_page_id=p.page_id
			{$rel_sql} {$user_sql}
			ORDER BY comment_date DESC LIMIT 0," . $this->item_max;

		$res = $dbr->query( $sql, __METHOD__ );
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

	private function setGiftsSent() {
		$dbr = wfGetDB( DB_SLAVE );
		$rel_sql = '';
		$user_sql = '';

		if( $this->rel_type ) {
			$rel_sql = "WHERE ug_user_id_to IN (SELECT r_user_id_relation FROM {$dbr->tableName( 'user_relationship' )} WHERE r_user_id={$this->user_id} AND r_type={$this->rel_type})";
		}
		if( $this->show_current_user ) {
			$user_sql = "WHERE ug_user_id_from = {$this->user_id}";
		}

		$sql = "SELECT ug_id, ug_user_id_from, ug_user_name_from,
					ug_user_id_to, ug_user_name_to,
					UNIX_TIMESTAMP(ug_date) AS item_date, gift_name, gift_id
			FROM {$dbr->tableName( 'user_gift' )}
			INNER JOIN {$dbr->tableName( 'gift' )} ON gift_id = ug_gift_id
			{$rel_sql} {$user_sql}
			ORDER BY ug_id DESC LIMIT 0,{$this->item_max}";
		$res = $dbr->query( $sql, __METHOD__ );
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

	private function setGiftsRec() {
		$dbr = wfGetDB( DB_SLAVE );
		$rel_sql = '';
		$user_sql = '';

		if ( !empty( $this->rel_type ) ) {
			$rel_sql = "WHERE ug_user_id_to in (SELECT r_user_id_relation FROM {$dbr->tableName( 'user_relationship' )} WHERE r_user_id={$this->user_id} AND r_type={$this->rel_type} )";
		}

		if ( !empty( $this->show_current_user ) ) {
			$user_sql = "WHERE ug_user_id_to = {$this->user_id}";
		}

		$sql = "SELECT ug_id, ug_user_id_from, ug_user_name_from,
					ug_user_id_to, ug_user_name_to,
					UNIX_TIMESTAMP(ug_date) AS item_date, gift_name, gift_id
			FROM {$dbr->tableName( 'user_gift' )}
			INNER JOIN {$dbr->tableName( 'gift' )} ON gift_id = ug_gift_id
			{$rel_sql} {$user_sql}
			ORDER BY ug_id DESC LIMIT 0,{$this->item_max}";
		$res = $dbr->query( $sql, __METHOD__ );
		foreach ( $res as $row ) {
			global $wgUploadPath;
			$user_title = Title::makeTitle( NS_USER, $row->ug_user_name_to );
			$user_title_from = Title::makeTitle( NS_USER, $row->ug_user_name_from );

			$gift_image = '<img src="' . $wgUploadPath . '/awards/' . Gifts::getGiftImage( $row->gift_id, 'm' ) . '" border="0" alt="" />';
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

	private function setSystemGiftsRec() {
		$dbr = wfGetDB( DB_SLAVE );
		$rel_sql = '';
		$user_sql = '';

		if ( !empty( $this->rel_type ) ) {
			$rel_sql = "WHERE sg_user_id in (SELECT r_user_id_relation FROM {$dbr->tableName( 'user_relationship' )} WHERE r_user_id={$this->user_id} AND r_type={$this->rel_type} )";
		}

		if ( !empty( $this->show_current_user ) ) {
			$user_sql = "WHERE sg_user_id = {$this->user_id}";
		}

		$sql = "SELECT sg_id, sg_user_id, sg_user_name,
					UNIX_TIMESTAMP(sg_date) AS item_date, gift_name, gift_id
			FROM {$dbr->tableName( 'user_system_gift' )}
			INNER JOIN {$dbr->tableName( 'system_gift' )} ON gift_id = sg_gift_id
			{$rel_sql} {$user_sql}
			ORDER BY sg_id DESC LIMIT 0,{$this->item_max}";
		$res = $dbr->query( $sql, __METHOD__ );
		foreach ( $res as $row ) {
			global $wgUploadPath;
			$user_title = Title::makeTitle( NS_USER, $row->sg_user_name );
			$system_gift_image = '<img src="' . $wgUploadPath . '/awards/' . SystemGifts::getGiftImage( $row->gift_id, 'm' ) . '" border="0" alt="" />';
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

	private function setRelationships() {
		$dbr = wfGetDB( DB_SLAVE );
		if ( !empty( $this->rel_type ) ) {
			$rel_sql = "WHERE r_user_id in (SELECT r_user_id_relation FROM {$dbr->tableName( 'user_relationship' )} WHERE r_user_id={$this->user_id} AND r_type={$this->rel_type} )";
		} else {
			$rel_sql = '';
		}
		if ( !empty( $this->show_current_user ) ) {
			$user_sql = "WHERE r_user_id = {$this->user_id}";
		} else {
			$user_sql = '';
		}
		$sql = "SELECT r_id, r_user_id, r_user_name, r_user_id_relation, r_user_name_relation, r_type, UNIX_TIMESTAMP(r_date) AS item_date
			FROM {$dbr->tableName( 'user_relationship' )}
			{$rel_sql} {$user_sql}
			ORDER BY r_id DESC LIMIT 0,{$this->item_max}";
		$res = $dbr->query( $sql, __METHOD__ );

		foreach ( $res as $row ) {
			if ( $row->r_type == 1 ) {
				$r_type = 'friend';
			} else {
				$r_type = 'foe';
			}

			$user_name_short = substr( $row->r_user_name, 0, 25 );
			if ( $row->r_user_name != $user_name_short ) {
				$user_name_short .= '...';
			}

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

	private function setMessagesSent() {
		$dbr = wfGetDB( DB_SLAVE );
		$rel_sql = '';
		$user_sql = '';

		if ( !empty( $this->rel_type ) ) {
			$rel_sql = " ub_user_id_from IN (SELECT r_user_id_relation FROM {$dbr->tableName( 'user_relationship' )} WHERE r_user_id={$this->user_id} AND r_type={$this->rel_type} ) AND";
		}

		if ( !empty( $this->show_current_user ) ) {
			$user_sql = " ub_user_id_from = {$this->user_id} AND";
		}

		$sql = "SELECT ub_id, ub_user_id, ub_user_name, ub_user_id_from,
				ub_user_name_from, UNIX_TIMESTAMP(ub_date) AS item_date,
				ub_message
			FROM {$dbr->tableName( 'user_board' )} WHERE
			{$rel_sql} {$user_sql}  ub_type=0
			ORDER BY ub_id DESC LIMIT 0,{$this->item_max}";

		$res = $dbr->query( $sql, __METHOD__ );
		foreach ( $res as $row ) {
			// Ignore nonexistent (for example, renamed) users
			$uid = User::idFromName( $row->ub_user_name );
			if ( !$uid ) {
				continue;
			}

			$this->items_grouped['user_message'][stripslashes( $row->ub_user_name )]['users'][stripslashes( $row->ub_user_name_from )][] = array(
				'id' => $row->ub_id,
				'type' => 'user_message',
				'timestamp' => $row->item_date,
				'pagetitle' => '',
				'namespace' => '',
				'username' => stripslashes( $row->ub_user_name_from ),
				'userid' => $row->ub_user_id_from,
				'comment' => stripslashes( $row->ub_user_name ),
				'minor' => 0,
				'new' => 0
			);

			// set last timestamp
			$this->items_grouped['user_message'][stripslashes( $row->ub_user_name )]['timestamp'] = $row->item_date;

			$this->items[] = array(
				'id' => $row->ub_id,
				'type' => 'user_message',
				'timestamp' => $row->item_date,
				'pagetitle' => '',
				'namespace' => $this->fixItemComment( $row->ub_message ),
				'username' => stripslashes( $row->ub_user_name_from ),
				'userid' => $row->ub_user_id_from,
				'comment' => stripslashes( $row->ub_user_name ),
				'new' => '0',
				'minor' => 0
			);
		}
	}

	private function setSystemMessages() {
		$dbr = wfGetDB( DB_SLAVE );
		$rel_sql = '';
		$user_sql = '';

		if ( !empty( $this->rel_type ) ) {
			$rel_sql = " WHERE um_user_id in (SELECT r_user_id_relation FROM {$dbr->tableName( 'user_relationship' )} WHERE r_user_id={$this->user_id} AND r_type={$this->rel_type} )";
		}

		if ( !empty( $this->show_current_user ) ) {
			$user_sql = " WHERE um_user_id = {$this->user_id}";
		}

		$sql = "SELECT um_id, um_user_id, um_user_name, um_type, um_message, UNIX_TIMESTAMP(um_date) AS item_date
			FROM {$dbr->tableName( 'user_system_messages' )}
			{$rel_sql} {$user_sql}
			ORDER BY um_id DESC LIMIT 0,{$this->item_max}";
		$res = $dbr->query( $sql, __METHOD__ );
		foreach ( $res as $row ) {
			$user_title = Title::makeTitle( NS_USER, $row->um_user_name );
			$user_name_short = substr( $row->um_user_name, 0, 15 );
			if ( $row->um_user_name != $user_name_short ) {
				$user_name_short .= '...';
			}
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

	function simplifyPageActivity( $type, $has_page = true ) {
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
						$pages .= wfMsg( 'parentheses', wfMsgExt( "useractivity-group-{$type}", 'parsemag', $count_actions, $user_name ) );
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
										$pages .= ' (' . wfMsg( "useractivity-group-{$type}", $count_actions2 ) . ')';
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
				$user_name_short = substr( $user_name, 0, 15 );
				if ( $user_name != $user_name_short ) {
					$user_name_short .= wfMsg( 'ellipsis' );
				}

				$users .= " <b><a href=\"{$user_title->escapeFullURL()}\">{$user_name_short}</a></b>";
			}
			if ( $pages || $has_page == false ) {
				$this->activityLines[] = array(
					'type' => $type,
					'timestamp' => $page_data['timestamp'],
					'data' => wfMsgExt(
						"useractivity-{$type}",
						'parsemag',
						$users, $count_users, $pages, $pages_count, $userNameForGender
					)
				);
			}
		}
	}

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

	function fixItemComment( $comment ) {
		if ( !$comment ) {
			return '';
		} else {
			$comment = str_replace( '<', '&lt;', $comment );
			$comment = str_replace( '>', '&gt;', $comment );
			$comment = str_replace( '&', '%26', $comment );
			$comment = str_replace( '%26quot;', "\"", $comment );
		}
		$preview = substr( $comment, 0, 75 );
		if ( $preview != $comment ) {
			$preview .= '...';
		}
		return stripslashes( $preview );
	}

	private static function sortItems( $x, $y ) {
		if( $x['timestamp'] == $y['timestamp'] ) {
			return 0;
		} elseif ( $x['timestamp'] > $y['timestamp'] ) {
			return - 1;
		} else {
			return 1;
		}
	}
}
