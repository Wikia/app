<?php

/**
 * Utility class for creating new RC entries
 * mAttribs:
 *  integration_rc_id           id of the row in the integration_recentchanges table
 *  integration_rc_db           id/name of the database
 *  integration_rc_timestamp    time the entry was made
 *  integration_rc_cur_time     timestamp on the cur row
 *  integration_rc_namespace    namespace #
 *  integration_rc_title        non-prefixed db key
 *  integration_rc_type         is new entry, used to determine whether updating is necessary
 *  integration_rc_minor        is minor
 *  integration_rc_cur_id       integration_page_id of associated page entry
 *  integration_rc_user         user id who made the entry
 *  integration_rc_user_text    user name who made the entry
 *  integration_rc_comment      edit summary
 *  integration_rc_this_oldid   rev_id associated with this entry (or zero)
 *  integration_rc_last_oldid   rev_id associated with the entry before this one (or zero)
 *  integration_rc_bot          is bot, hidden
 *  integration_rc_ip           IP address of the user in dotted quad notation
 *  integration_rc_new          obsolete, use integration_rc_type==RC_NEW
 *  integration_rc_patrolled    boolean whether or not someone has marked this edit as patrolled
 *  integration_rc_old_len      integer byte length of the text before the edit
 *  integration_rc_new_len      the same after the edit
 *  integration_rc_deleted      partial deletion
 *  integration_rc_logid        the log_id value for this log entry (or zero)
 *  integration_rc_log_type     the log type (or null)
 *  integration_rc_log_action   the log action (or null)
 *  integration_rc_params       log params
 *
 * mExtra:
 *  prefixedDBkey   prefixed db key, used by external app via msg queue
 *  lastTimestamp   timestamp of previous entry, used in WHERE clause during update
 *  lang            the interwiki prefix, automatically set in save()
 *  oldSize         text size before the change
 *  newSize         text size after the change
 *
 * temporary:       not stored in the database
 *      notificationtimestamp
 *      numberofWatchingusers
 *
 * @todo document functions and variables
 */
class InterwikiIntegrationRecentChange {
	var $mAttribs = array(), $mExtra = array();
	var $mTitle = false, $mMovedToTitle = false;
	var $numberofWatchingusers = 0 ; # Dummy to prevent error message in SpecialRecentchangeslinked

	# Factory methods

	public static function newFromRow( $row ) {
		$rc = new InterwikiIntegrationRecentChange;
		$rc->loadFromRow( $row );
		return $rc;
	}

	public static function newFromCurRow( $row ) {
		$rc = new InterwikiIntegrationRecentChange;
		$rc->loadFromCurRow( $row );
		$rc->notificationtimestamp = false;
		$rc->numberofWatchingusers = false;
		return $rc;
	}

	/**
	 * Obtain the recent change with a given integration_rc_id value
	 *
	 * @param $rcid integration_rc_id value to retrieve
	 * @return InterwikiIntegrationRecentChange
	 */
	public static function newFromId( $rcid ) {
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'integration_recentchanges', '*', array( 'integration_rc_id' => $rcid ), __METHOD__ );
		if( $res && $dbr->numRows( $res ) > 0 ) {
			$row = $dbr->fetchObject( $res );
			$dbr->freeResult( $res );
			return self::newFromRow( $row );
		} else {
			return null;
		}
	}

	/**
	 * Find the first recent change matching some specific conditions
	 *
	 * @param $conds Array of conditions
	 * @param $fname Mixed: override the method name in profiling/logs
	 * @return InterwikiIntegrationRecentChange
	 */
	public static function newFromConds( $conds, $fname = false ) {
		if( $fname === false )
			$fname = __METHOD__;
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select(
			'integration_recentchanges',
			'*',
			$conds,
			$fname
		);
		if( $res instanceof ResultWrapper && $res->numRows() > 0 ) {
			$row = $res->fetchObject();
			$res->free();
			return self::newFromRow( $row );
		}
		return null;
	}

	# Accessors

	public function setAttribs( $attribs ) {
		$this->mAttribs = $attribs;
	}

	public function setExtra( $extra ) {
		$this->mExtra = $extra;
	}

	public function &getTitle() {
		if( $this->mTitle === false ) {
			$this->mTitle = IntegrationInterwikiTitle::makeTitle( $this->mAttribs['integration_rc_namespace'], $this->mAttribs['integration_rc_title'], '', $this->mAttribs['integration_rc_db'] );
			# Make sure the correct page ID is process cached
			$this->mTitle->resetArticleID( $this->mAttribs['integration_rc_cur_id'] );
		}
		return $this->mTitle;
	}

	public function getMovedToTitle() {
		if( $this->mMovedToTitle === false ) {
			$this->mMovedToTitle = Title::makeTitle( $this->mAttribs['integration_rc_moved_to_ns'],
				$this->mAttribs['integration_rc_moved_to_title'] );
		}
		return $this->mMovedToTitle;
	}

	# Writes the data in this object to the database
	public function save() {
		global $wgLocalInterwiki, $wgPutIPinRC, $wgRC2UDPAddress, $wgRC2UDPOmitBots;
		$fname = 'RecentChange::save';

		$dbw = wfGetDB( DB_MASTER );
		if( !is_array($this->mExtra) ) {
			$this->mExtra = array();
		}
		$this->mExtra['lang'] = $wgLocalInterwiki;

		if( !$wgPutIPinRC ) {
			$this->mAttribs['integration_rc_ip'] = '';
		}

		# If our database is strict about IP addresses, use NULL instead of an empty string
		if( $dbw->strictIPs() and $this->mAttribs['integration_rc_ip'] == '' ) {
			unset( $this->mAttribs['integration_rc_ip'] );
		}

		# Fixup database timestamps
		$this->mAttribs['integration_rc_timestamp'] = $dbw->timestamp($this->mAttribs['integration_rc_timestamp']);
		$this->mAttribs['integration_rc_cur_time'] = $dbw->timestamp($this->mAttribs['integration_rc_cur_time']);
		$this->mAttribs['integration_rc_id'] = $dbw->nextSequenceValue( 'integration_recentchanges_integration_rc_id_seq' );

		## If we are using foreign keys, an entry of 0 for the integration_page_id will fail, so use NULL
		if( $dbw->cascadingDeletes() and $this->mAttribs['integration_rc_cur_id']==0 ) {
			unset( $this->mAttribs['integration_rc_cur_id'] );
		}

		# Insert new row
		$dbw->insert( 'integration_recentchanges', $this->mAttribs, $fname );

		# Set the ID
		$this->mAttribs['integration_rc_id'] = $dbw->insertId();
		
		# Notify extensions
		wfRunHooks( 'RecentChange_save', array( &$this ) );

		# Notify external application via UDP
		if( $wgRC2UDPAddress && ( !$this->mAttribs['integration_rc_bot'] || !$wgRC2UDPOmitBots ) ) {
			self::sendToUDP( $this->getIRCLine() );
		}

		# E-mail notifications
		global $wgUseEnotif, $wgShowUpdatedMarker, $wgUser;
		if( $wgUseEnotif || $wgShowUpdatedMarker ) {
			// Users
			if( $this->mAttribs['integration_rc_user'] ) {
				$editor = ($wgUser->getId() == $this->mAttribs['integration_rc_user']) ? 
					$wgUser : User::newFromID( $this->mAttribs['integration_rc_user'] );
			// Anons
			} else {
				$editor = ($wgUser->getName() == $this->mAttribs['integration_rc_user_text']) ? 
					$wgUser : User::newFromName( $this->mAttribs['integration_rc_user_text'], false );
			}
			# FIXME: this would be better as an extension hook
			$enotif = new EmailNotification();
			$title = Title::makeTitle( $this->mAttribs['integration_rc_namespace'], $this->mAttribs['integration_rc_title'] );
			$enotif->notifyOnPageChange( $editor, $title,
				$this->mAttribs['integration_rc_timestamp'],
				$this->mAttribs['integration_rc_comment'],
				$this->mAttribs['integration_rc_minor'],
				$this->mAttribs['integration_rc_last_oldid'] );
		}
	}
	
	public function notifyRC2UDP() {
		global $wgRC2UDPAddress, $wgRC2UDPOmitBots;
		# Notify external application via UDP
		if( $wgRC2UDPAddress && ( !$this->mAttribs['integration_rc_bot'] || !$wgRC2UDPOmitBots ) ) {
			self::sendToUDP( $this->getIRCLine() );
		}
	}

	/**
	 * Send some text to UDP
	 * @param $line String: text to send
	 * @param $prefix String
	 * @param $address String: address
	 * @return Boolean: success
	 */
	public static function sendToUDP( $line, $address = '', $prefix = '' ) {
		global $wgRC2UDPAddress, $wgRC2UDPPrefix, $wgRC2UDPPort;
		# Assume default for standard RC case
		$address = $address ? $address : $wgRC2UDPAddress;
		$prefix = $prefix ? $prefix : $wgRC2UDPPrefix;
		# Notify external application via UDP
		if( $address ) {
			$conn = socket_create( AF_INET, SOCK_DGRAM, SOL_UDP );
			if( $conn ) {
				$line = $prefix . $line;
				wfDebug( __METHOD__ . ": sending UDP line: $line\n" );
				socket_sendto( $conn, $line, strlen($line), 0, $address, $wgRC2UDPPort );
				socket_close( $conn );
				return true;
			} else {
				wfDebug( __METHOD__ . ": failed to create UDP socket\n" );
			}
		}
		return false;
	}
	
	/**
	 * Remove newlines, carriage returns and decode html entites
	 * @param $text String
	 * @return String
	 */
	public static function cleanupForIRC( $text ) {
		return Sanitizer::decodeCharReferences( str_replace( array( "\n", "\r" ), array( "", "" ), $text ) );
	}

	/**
	 * Mark a given change as patrolled
	 *
	 * @param $change Mixed: InterwikiIntegrationRecentChange or corresponding integration_rc_id
	 * @param $auto Boolean: for automatic patrol
	 * @return See doMarkPatrolled(), or null if $change is not an existing integration_rc_id
	 */
	public static function markPatrolled( $change, $auto = false ) {
		$change = $change instanceof InterwikiIntegrationRecentChange
			? $change
			: InterwikiIntegrationRecentChange::newFromId($change);
		if( !$change instanceof InterwikiIntegrationRecentChange ) {
			return null;
		}
		return $change->doMarkPatrolled( $auto );
	}
	
	/**
	 * Mark this InterwikiIntegrationRecentChange as patrolled
	 *
	 * NOTE: Can also return 'rcpatroldisabled', 'hookaborted' and 'markedaspatrollederror-noautopatrol' as errors
	 * @param $auto Boolean: for automatic patrol
	 * @return array of permissions errors, see Title::getUserPermissionsErrors()
	 */
	public function doMarkPatrolled( $auto = false ) {
		global $wgUser, $wgUseRCPatrol, $wgUseNPPatrol;
		$errors = array();
		// If recentchanges patrol is disabled, only new pages
		// can be patrolled
		if( !$wgUseRCPatrol && ( !$wgUseNPPatrol || $this->getAttribute('integration_rc_type') != RC_NEW ) ) {
			$errors[] = array('rcpatroldisabled');
		}
		// Automatic patrol needs "autopatrol", ordinary patrol needs "patrol"
		$right = $auto ? 'autopatrol' : 'patrol';
		$errors = array_merge( $errors, $this->getTitle()->getUserPermissionsErrors( $right, $wgUser ) );
		if( !wfRunHooks('MarkPatrolled', array($this->getAttribute('integration_rc_id'), &$wgUser, false)) ) {
			$errors[] = array('hookaborted');
		}
		// Users without the 'autopatrol' right can't patrol their
		// own revisions
		if( $wgUser->getName() == $this->getAttribute('integration_rc_user_text') && !$wgUser->isAllowed('autopatrol') ) {
			$errors[] = array('markedaspatrollederror-noautopatrol');
		}
		if( $errors ) {
			return $errors;
		}
		// If the change was patrolled already, do nothing
		if( $this->getAttribute('integration_rc_patrolled') ) {
			return array();
		}
		// Actually set the 'patrolled' flag in RC
		$this->reallyMarkPatrolled();
		// Log this patrol event
		PatrolLog::record( $this, $auto );
		wfRunHooks( 'MarkPatrolledComplete', array($this->getAttribute('integration_rc_id'), &$wgUser, false) );
		return array();
	}
	
	/**
	 * Mark this InterwikiIntegrationRecentChange patrolled, without error checking
	 * @return Integer: number of affected rows
	 */
	public function reallyMarkPatrolled() {
		$dbw = wfGetDB( DB_MASTER );
		$dbw->update(
			'integration_recentchanges',
			array(
				'integration_rc_patrolled' => 1
			),
			array(
				'integration_rc_id' => $this->getAttribute('integration_rc_id')
			),
			__METHOD__
		);
		return $dbw->affectedRows();
	}

	# Makes an entry in the database corresponding to an edit
	public static function notifyEdit( $timestamp, &$title, $minor, &$user, $comment, $oldId,
		$lastTimestamp, $bot, $ip='', $oldSize=0, $newSize=0, $newId=0, $patrol=0 )
	{
		if( !$ip ) {
			$ip = wfGetIP();
			if( !$ip ) $ip = '';
		}

		$rc = new InterwikiIntegrationRecentChange;
		$rc->mAttribs = array(
			'integration_rc_timestamp'  => $timestamp,
			'integration_rc_cur_time'   => $timestamp,
			'integration_rc_namespace'  => $title->getNamespace(),
			'integration_rc_title'      => $title->getDBkey(),
			'integration_rc_type'       => RC_EDIT,
			'integration_rc_minor'      => $minor ? 1 : 0,
			'integration_rc_cur_id'     => $title->getArticleID(),
			'integration_rc_user'       => $user->getId(),
			'integration_rc_user_text'  => $user->getName(),
			'integration_rc_comment'    => $comment,
			'integration_rc_this_oldid' => $newId,
			'integration_rc_last_oldid' => $oldId,
			'integration_rc_bot'        => $bot ? 1 : 0,
			'integration_rc_moved_to_ns' => 0,
			'integration_rc_moved_to_title' => '',
			'integration_rc_ip'         => $ip,
			'integration_rc_patrolled'  => intval($patrol),
			'integration_rc_new'        => 0,  # obsolete
			'integration_rc_old_len'    => $oldSize,
			'integration_rc_new_len'    => $newSize,
			'integration_rc_deleted'    => 0,
			'integration_rc_logid'      => 0,
			'integration_rc_log_type'   => null,
			'integration_rc_log_action' => '',
			'integration_rc_params'     => ''
		);

		$rc->mExtra =  array(
			'prefixedDBkey' => $title->getPrefixedDBkey(),
			'lastTimestamp' => $lastTimestamp,
			'oldSize'       => $oldSize,
			'newSize'       => $newSize,
		);
		$rc->save();
		return $rc;
	}

	/**
	 * Makes an entry in the database corresponding to page creation
	 * Note: the title object must be loaded with the new id using resetArticleID()
	 * @todo Document parameters and return
	 */
	public static function notifyNew( $timestamp, &$title, $minor, &$user, $comment, $bot,
		$ip='', $size=0, $newId=0, $patrol=0 )
	{
		if( !$ip ) {
			$ip = wfGetIP();
			if( !$ip ) $ip = '';
		}

		$rc = new InterwikiIntegrationRecentChange;
		$rc->mAttribs = array(
			'integration_rc_timestamp'      => $timestamp,
			'integration_rc_cur_time'       => $timestamp,
			'integration_rc_namespace'      => $title->getNamespace(),
			'integration_rc_title'          => $title->getDBkey(),
			'integration_rc_type'           => RC_NEW,
			'integration_rc_minor'          => $minor ? 1 : 0,
			'integration_rc_cur_id'         => $title->getArticleID(),
			'integration_rc_user'           => $user->getId(),
			'integration_rc_user_text'      => $user->getName(),
			'integration_rc_comment'        => $comment,
			'integration_rc_this_oldid'     => $newId,
			'integration_rc_last_oldid'     => 0,
			'integration_rc_bot'            => $bot ? 1 : 0,
			'integration_rc_moved_to_ns'    => 0,
			'integration_rc_moved_to_title' => '',
			'integration_rc_ip'             => $ip,
			'integration_rc_patrolled'      => intval($patrol),
			'integration_rc_new'            => 1, # obsolete
			'integration_rc_old_len'        => 0,
			'integration_rc_new_len'        => $size,
			'integration_rc_deleted'        => 0,
			'integration_rc_logid'          => 0,
			'integration_rc_log_type'       => null,
			'integration_rc_log_action'     => '',
			'integration_rc_params'         => ''
		);

		$rc->mExtra =  array(
			'prefixedDBkey' => $title->getPrefixedDBkey(),
			'lastTimestamp' => 0,
			'oldSize' => 0,
			'newSize' => $size
		);
		$rc->save();
		return $rc;	
	}

	# Makes an entry in the database corresponding to a rename
	public static function notifyMove( $timestamp, &$oldTitle, &$newTitle, &$user, $comment, $ip='', $overRedir = false )
	{
		global $wgRequest;
		if( !$ip ) {
			$ip = wfGetIP();
			if( !$ip ) $ip = '';
		}

		$rc = new InterwikiIntegrationRecentChange;
		$rc->mAttribs = array(
			'integration_rc_timestamp'  => $timestamp,
			'integration_rc_cur_time'   => $timestamp,
			'integration_rc_namespace'  => $oldTitle->getNamespace(),
			'integration_rc_title'      => $oldTitle->getDBkey(),
			'integration_rc_type'       => $overRedir ? RC_MOVE_OVER_REDIRECT : RC_MOVE,
			'integration_rc_minor'      => 0,
			'integration_rc_cur_id'     => $oldTitle->getArticleID(),
			'integration_rc_user'       => $user->getId(),
			'integration_rc_user_text'  => $user->getName(),
			'integration_rc_comment'    => $comment,
			'integration_rc_this_oldid' => 0,
			'integration_rc_last_oldid' => 0,
			'integration_rc_bot'        => $user->isAllowed( 'bot' ) ? $wgRequest->getBool( 'bot' , true ) : 0,
			'integration_rc_moved_to_ns' => $newTitle->getNamespace(),
			'integration_rc_moved_to_title' => $newTitle->getDBkey(),
			'integration_rc_ip'         => $ip,
			'integration_rc_new'        => 0, # obsolete
			'integration_rc_patrolled'  => 1,
			'integration_rc_old_len'    => null,
			'integration_rc_new_len'    => null,
			'integration_rc_deleted'    => 0,
			'integration_rc_logid'      => 0, # notifyMove not used anymore
			'integration_rc_log_type'   => null,
			'integration_rc_log_action' => '',
			'integration_rc_params'     => ''
		);

		$rc->mExtra = array(
			'prefixedDBkey' => $oldTitle->getPrefixedDBkey(),
			'lastTimestamp' => 0,
			'prefixedMoveTo' => $newTitle->getPrefixedDBkey()
		);
		$rc->save();
	}

	public static function notifyMoveToNew( $timestamp, &$oldTitle, &$newTitle, &$user, $comment, $ip='' ) {
		InterwikiIntegrationRecentChange::notifyMove( $timestamp, $oldTitle, $newTitle, $user, $comment, $ip, false );
	}

	public static function notifyMoveOverRedirect( $timestamp, &$oldTitle, &$newTitle, &$user, $comment, $ip='' ) {
		InterwikiIntegrationRecentChange::notifyMove( $timestamp, $oldTitle, $newTitle, $user, $comment, $ip, true );
	}

	public static function notifyLog( $timestamp, &$title, &$user, $actionComment, $ip='', $type, 
		$action, $target, $logComment, $params, $newId=0 )
	{
		global $wgLogRestrictions;
		# Don't add private logs to RC!
		if( isset($wgLogRestrictions[$type]) && $wgLogRestrictions[$type] != '*' ) {
			return false;
		}
		$rc = self::newLogEntry( $timestamp, $title, $user, $actionComment, $ip, $type, $action,
			$target, $logComment, $params, $newId );
		$rc->save();
		return true;
	}

	public static function newLogEntry( $timestamp, &$title, &$user, $actionComment, $ip='',
		$type, $action, $target, $logComment, $params, $newId=0 )
	{
		global $wgRequest;
		if( !$ip ) {
			$ip = wfGetIP();
			if( !$ip ) $ip = '';
		}

		$rc = new InterwikiIntegrationRecentChange;
		$rc->mAttribs = array(
			'integration_rc_timestamp'  => $timestamp,
			'integration_rc_cur_time'   => $timestamp,
			'integration_rc_namespace'  => $target->getNamespace(),
			'integration_rc_title'      => $target->getDBkey(),
			'integration_rc_type'       => RC_LOG,
			'integration_rc_minor'      => 0,
			'integration_rc_cur_id'     => $target->getArticleID(),
			'integration_rc_user'       => $user->getId(),
			'integration_rc_user_text'  => $user->getName(),
			'integration_rc_comment'    => $logComment,
			'integration_rc_this_oldid' => 0,
			'integration_rc_last_oldid' => 0,
			'integration_rc_bot'        => $user->isAllowed( 'bot' ) ? $wgRequest->getBool( 'bot', true ) : 0,
			'integration_rc_moved_to_ns' => 0,
			'integration_rc_moved_to_title' => '',
			'integration_rc_ip'         => $ip,
			'integration_rc_patrolled'  => 1,
			'integration_rc_new'        => 0, # obsolete
			'integration_rc_old_len'    => null,
			'integration_rc_new_len'    => null,
			'integration_rc_deleted'    => 0,
			'integration_rc_logid'      => $newId,
			'integration_rc_log_type'   => $type,
			'integration_rc_log_action' => $action,
			'integration_rc_params'     => $params
		);
		$rc->mExtra =  array(
			'prefixedDBkey' => $title->getPrefixedDBkey(),
			'lastTimestamp' => 0,
			'actionComment' => $actionComment, // the comment appended to the action, passed from LogPage
		);
		return $rc;
	}

	# Initialises the members of this object from a mysql row object
	public function loadFromRow( $row ) {
		$this->mAttribs = get_object_vars( $row );
		$this->mAttribs['integration_rc_timestamp'] = wfTimestamp(TS_MW, $this->mAttribs['integration_rc_timestamp']);
		$this->mAttribs['integration_rc_deleted'] = $row->integration_rc_deleted; // MUST be set
	}

	# Makes a pseudo-RC entry from a cur row
	public function loadFromCurRow( $row ) {
		$this->mAttribs = array(
			'integration_rc_timestamp' => wfTimestamp(TS_MW, $row->rev_timestamp),
			'integration_rc_cur_time' => $row->rev_timestamp,
			'integration_rc_user' => $row->rev_user,
			'integration_rc_user_text' => $row->rev_user_text,
			'integration_rc_namespace' => $row->integration_page_namespace,
			'integration_rc_title' => $row->integration_page_title,
			'integration_rc_comment' => $row->rev_comment,
			'integration_rc_minor' => $row->rev_minor_edit ? 1 : 0,
			'integration_rc_type' => $row->integration_page_is_new ? RC_NEW : RC_EDIT,
			'integration_rc_cur_id' => $row->integration_page_id,
			'integration_rc_this_oldid'	=> $row->rev_id,
			'integration_rc_last_oldid'	=> isset($row->integration_rc_last_oldid) ? $row->integration_rc_last_oldid : 0,
			'integration_rc_bot'	=> 0,
			'integration_rc_moved_to_ns'	=> 0,
			'integration_rc_moved_to_title'	=> '',
			'integration_rc_ip' => '',
			'integration_rc_id' => $row->integration_rc_id,
                        'integration_rc_db' => $row->integration_rc_db,
			'integration_rc_patrolled' => $row->integration_rc_patrolled,
			'integration_rc_new' => $row->integration_page_is_new, # obsolete
			'integration_rc_old_len' => $row->integration_rc_old_len,
			'integration_rc_new_len' => $row->integration_rc_new_len,
			'integration_rc_params' => isset($row->integration_rc_params) ? $row->integration_rc_params : '',
			'integration_rc_log_type' => isset($row->integration_rc_log_type) ? $row->integration_rc_log_type : null,
			'integration_rc_log_action' => isset($row->integration_rc_log_action) ? $row->integration_rc_log_action : null,
			'integration_rc_log_id' => isset($row->integration_rc_log_id) ? $row->integration_rc_log_id: 0,
			'integration_rc_deleted' => $row->integration_rc_deleted // MUST be set
		);
	}

	/**
	 * Get an attribute value
	 *
	 * @param $name Attribute name
	 * @return mixed
	 */
	public function getAttribute( $name ) {
		return isset( $this->mAttribs[$name] ) ? $this->mAttribs[$name] : null;
	}

	public function getAttributes() {
		return $this->mAttribs;
	}

	/**
	 * Gets the end part of the diff URL associated with this object
	 * Blank if no diff link should be displayed
	 */
	public function diffLinkTrail( $forceCur ) {
		if( $this->mAttribs['integration_rc_type'] == RC_EDIT ) {
			$trail = "curid=" . (int)($this->mAttribs['integration_rc_cur_id']) .
				"&oldid=" . (int)($this->mAttribs['integration_rc_last_oldid']);
			if( $forceCur ) {
				$trail .= '&diff=0' ;
			} else {
				$trail .= '&diff=' . (int)($this->mAttribs['integration_rc_this_oldid']);
			}
		} else {
			$trail = '';
		}
		return $trail;
	}

	public function getIRCLine() {
		global $wgUseRCPatrol, $wgUseNPPatrol, $wgRC2UDPInterwikiPrefix, $wgLocalInterwiki;

		// FIXME: Would be good to replace these 2 extract() calls with something more explicit
		// e.g. list ($integration_rc_type, $integration_rc_id) = array_values ($this->mAttribs); [or something like that]
		extract($this->mAttribs);
		extract($this->mExtra);

		if( $integration_rc_type == RC_LOG ) {
			$titleObj = Title::newFromText( "Log/$integration_rc_log_type", NS_SPECIAL );
		} else {
			$titleObj =& $this->getTitle();
		}
		$title = $titleObj->getPrefixedText();
		$title = self::cleanupForIRC( $title );

		if( $integration_rc_type == RC_LOG ) {
			$url = '';
		} else {
			if( $integration_rc_type == RC_NEW ) {
				$url = "oldid=$integration_rc_this_oldid";
			} else {
				$url = "diff=$integration_rc_this_oldid&oldid=$integration_rc_last_oldid";
			}
			if( $wgUseRCPatrol || ($integration_rc_type == RC_NEW && $wgUseNPPatrol) ) {
				$url .= "&rcid=$integration_rc_id";
			}
			// XXX: *HACK* this should use getFullURL(), hacked for SSL madness --brion 2005-12-26
			// XXX: *HACK^2* the preg_replace() undoes much of what getInternalURL() does, but we 
			// XXX: need to call it so that URL paths on the Wikimedia secure server can be fixed
			// XXX: by a custom GetInternalURL hook --vyznev 2008-12-10
			$url = preg_replace( '/title=[^&]*&/', '', $titleObj->getInternalURL( $url ) );
		}

		if( isset( $oldSize ) && isset( $newSize ) ) {
			$szdiff = $newSize - $oldSize;
			if($szdiff < -500) {
				$szdiff = "\002$szdiff\002";
			} elseif($szdiff >= 0) {
				$szdiff = '+' . $szdiff ;
			}
			$szdiff = '(' . $szdiff . ')' ;
		} else {
			$szdiff = '';
		}

		$user = self::cleanupForIRC( $integration_rc_user_text );

		if( $integration_rc_type == RC_LOG ) {
			$targetText = $this->getTitle()->getPrefixedText();
			$comment = self::cleanupForIRC( str_replace("[[$targetText]]","[[\00302$targetText\00310]]",$actionComment) );
			$flag = $integration_rc_log_action;
		} else {
			$comment = self::cleanupForIRC( $integration_rc_comment );
			$flag = '';
			if( !$integration_rc_patrolled && ($wgUseRCPatrol || $integration_rc_new && $wgUseNPPatrol) ) {
				$flag .= '!';
			}
			$flag .= ($integration_rc_new ? "N" : "") . ($integration_rc_minor ? "M" : "") . ($integration_rc_bot ? "B" : "");
		}

		if ( $wgRC2UDPInterwikiPrefix === true ) {
			$prefix = $wgLocalInterwiki;
		} elseif ( $wgRC2UDPInterwikiPrefix ) {
			$prefix = $wgRC2UDPInterwikiPrefix;
		} else {
			$prefix = false;
		}
		if ( $prefix !== false ) {
			$titleString = "\00314[[\00303$prefix:\00307$title\00314]]";
		} else {
			$titleString = "\00314[[\00307$title\00314]]";
		}
		
		# see http://www.irssi.org/documentation/formats for some colour codes. prefix is \003,
		# no colour (\003) switches back to the term default
		$fullString = "$titleString\0034 $flag\00310 " .
		              "\00302$url\003 \0035*\003 \00303$user\003 \0035*\003 $szdiff \00310$comment\003\n";
			
		return $fullString;
	}

	/**
	 * Returns the change size (HTML).
	 * The lengths can be given optionally.
	 */
	public function getCharacterDifference( $old = 0, $new = 0 ) {
		if( $old === 0 ) {
			$old = $this->mAttribs['integration_rc_old_len'];
		}
		if( $new === 0 ) {
			$new = $this->mAttribs['integration_rc_new_len'];
		}
		if( $old === null || $new === null ) {
			return '';
		}
		return InterwikiIntegrationChangesList::showCharacterDifference( $old, $new );
	}
}