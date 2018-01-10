<?php
class CheckUserHooks {
	const ACTION_TEXT_MAX_LENGTH = 255;

	/**
	 * Hook function for RecentChange_save
	 * Saves user data into the cu_changes table
	 *
	 * @param RecentChange $rc
	 * @return bool
	 */
	public static function updateCheckUserData( RecentChange $rc ) {
		global $wgRequest;

		// Extract params
		extract( $rc->mAttribs );
		// Get IP
		$ip = wfGetIP();
		// Get XFF header
		$xff = $wgRequest->getHeader( 'X-Forwarded-For' );
		list( $xff_ip, $isSquidOnly ) = IP::getClientIPfromXFF( $xff );
		// Get agent
		$agent = $wgRequest->getHeader( 'User-Agent' );
		// Store the log action text for log events
		// $rc_comment should just be the log_comment
		// BC: check if log_type and log_action exists
		// If not, then $rc_comment is the actiontext and comment
		if ( isset( $rc_log_type ) && $rc_type == RC_LOG ) {
			$target = Title::makeTitle( $rc_namespace, $rc_title );
			$context = RequestContext::newExtraneousContext( $target );

			$formatter = LogFormatter::newFromRow( $rc->mAttribs );
			$formatter->setContext( $context );
			$actionText = $formatter->getPlainActionText();
		} else {
			$actionText = '';
		}

		// SUS-3257 / SUS-3467: Make sure the text fits into the database
		$actionTextTrim = substr( $actionText, 0, static::ACTION_TEXT_MAX_LENGTH );

		$dbw = wfGetDB( DB_MASTER );
		$cuc_id = $dbw->nextSequenceValue( 'cu_changes_cu_id_seq' );
		$rcRow = array(
			'cuc_id'         => $cuc_id,
			'cuc_namespace'  => $rc_namespace,
			'cuc_title'      => $rc_title,
			'cuc_minor'      => $rc_minor,
			'cuc_user'       => $rc_user,
			// 'cuc_user_text'  => $user->isAnon() ? $rc_user_text : '', // SUS-3080 - this column is redundant
			'cuc_actiontext' => $actionTextTrim,
			'cuc_comment'    => $rc_comment,
			'cuc_this_oldid' => $rc_this_oldid,
			'cuc_last_oldid' => $rc_last_oldid,
			'cuc_type'       => $rc_type,
			'cuc_timestamp'  => $rc_timestamp,
			'cuc_ip'         => IP::sanitizeIP( $ip ),
			'cuc_ip_hex'     => $ip ? IP::toHex( $ip ) : null,
			'cuc_xff'        => !$isSquidOnly ? $xff : '',
			'cuc_xff_hex'    => ( $xff_ip && !$isSquidOnly ) ? IP::toHex( $xff_ip ) : null,
			'cuc_agent'      => $agent
		);
		# On PG, MW unsets cur_id due to schema incompatibilites. So it may not be set!
		if ( isset( $rc_cur_id ) ) {
			$rcRow['cuc_page_id'] = $rc_cur_id;
		}
		$dbw->insert( 'cu_changes', $rcRow, __METHOD__ );

		return true;
	}

	/**
	 * Hook function to store password reset
	 * Saves user data into the cu_changes table
	 */
	public static function updateCUPasswordResetData( User $user, $ip, $account ) {
		global $wgRequest;

		// Get XFF header
		$xff = $wgRequest->getHeader( 'X-Forwarded-For' );
		list( $xff_ip, $isSquidOnly ) = IP::getClientIPfromXFF( $xff );
		// Get agent
		$agent = $wgRequest->getHeader( 'User-Agent' );
		$dbw = wfGetDB( DB_MASTER );
		$cuc_id = $dbw->nextSequenceValue( 'cu_changes_cu_id_seq' );
		$rcRow = array(
			'cuc_id'         => $cuc_id,
			'cuc_namespace'  => NS_USER,
			'cuc_title'      => '',
			'cuc_minor'      => 0,
			'cuc_user'       => $user->getId(),
			// 'cuc_user_text'  => $user->getName(),// SUS-3080 - this column is redundant
			'cuc_actiontext' => wfMsgForContent( 'checkuser-reset-action', $account->getName() ),
			'cuc_comment'    => '',
			'cuc_this_oldid' => 0,
			'cuc_last_oldid' => 0,
			'cuc_type'       => RC_LOG,
			'cuc_timestamp'  => $dbw->timestamp( wfTimestampNow() ),
			'cuc_ip'         => IP::sanitizeIP( $ip ),
			'cuc_ip_hex'     => $ip ? IP::toHex( $ip ) : null,
			'cuc_xff'        => !$isSquidOnly ? $xff : '',
			'cuc_xff_hex'    => ( $xff_ip && !$isSquidOnly ) ? IP::toHex( $xff_ip ) : null,
			'cuc_agent'      => $agent
		);
		$dbw->insert( 'cu_changes', $rcRow, __METHOD__ );

		return true;
	}

	/**
	 * Hook function to store email data
	 * Saves user data into the cu_changes table
	 */
	public static function updateCUEmailData( $to, $from, $subject, $text ) {
		global $wgSecretKey, $wgRequest;
		if ( !$wgSecretKey || $from->name == $to->name ) {
			return true;
		}
		$userFrom = User::newFromName( $from->name );
		$userTo = User::newFromName( $to->name );
		$hash = md5( $userTo->getEmail() . $userTo->getId() . $wgSecretKey );
		// Get IP
		$ip = wfGetIP();
		// Get XFF header
		$xff = $wgRequest->getHeader( 'X-Forwarded-For' );
		list( $xff_ip, $isSquidOnly ) = IP::getClientIPfromXFF( $xff );
		// Get agent
		$agent = $wgRequest->getHeader( 'User-Agent' );
		$dbw = wfGetDB( DB_MASTER );
		$cuc_id = $dbw->nextSequenceValue( 'cu_changes_cu_id_seq' );
		$rcRow = array(
			'cuc_id'         => $cuc_id,
			'cuc_namespace'  => NS_USER,
			'cuc_title'      => '',
			'cuc_minor'      => 0,
			'cuc_user'       => $userFrom->getId(),
			// 'cuc_user_text'  => $userFrom->getName(), // SUS-3080 - this column is redundant
			'cuc_actiontext' => wfMsgForContent( 'checkuser-email-action', $hash ),
			'cuc_comment'    => '',
			'cuc_this_oldid' => 0,
			'cuc_last_oldid' => 0,
			'cuc_type'       => RC_LOG,
			'cuc_timestamp'  => $dbw->timestamp( wfTimestampNow() ),
			'cuc_ip'         => IP::sanitizeIP( $ip ),
			'cuc_ip_hex'     => $ip ? IP::toHex( $ip ) : null,
			'cuc_xff'        => !$isSquidOnly ? $xff : '',
			'cuc_xff_hex'    => ( $xff_ip && !$isSquidOnly ) ? IP::toHex( $xff_ip ) : null,
			'cuc_agent'      => $agent
		);
		$dbw->insert( 'cu_changes', $rcRow, __METHOD__ );

		return true;
	}

	/**
	 * Hook function to store autocreation data from the auth plugin
	 * Saves user data into the cu_changes table
	 *
	 * @param $user User
	 *
	 * @return true
	 */
	public static function onAuthPluginAutoCreate( User $user ) {
		return self::logUserAccountCreation( $user, 'checkuser-autocreate-action' );
	}

	/**
	 * Hook function to store registration data
	 * Saves user data into the cu_changes table
	 *
	 * @param $user User
	 * @param $byEmail bool
	 * @return bool
	 */
	public static function onAddNewAccount( User $user, $byEmail ) {
		return self::logUserAccountCreation( $user, 'checkuser-create-action' );
	}

	/**
	 * @param $user User
	 * @param $actiontext string
	 * @return bool
	 */
	protected static function logUserAccountCreation( User $user, $actiontext ) {
		/** @var WebRequest $wgRequest */
		global $wgRequest;

		// Get IP
		$ip = $wgRequest->getIP();

		$dbw = wfGetDB( DB_MASTER );
		$cuc_id = $dbw->nextSequenceValue( 'cu_changes_cu_id_seq' );
		$rcRow = array(
			'cuc_id'         => $cuc_id,
			'cuc_page_id'    => 0,
			'cuc_namespace'  => NS_USER,
			'cuc_title'      => '',
			'cuc_minor'      => 0,
			'cuc_user'       => $user->getId(),
			// 'cuc_user_text'  => $user->getName(), // SUS-3080 - this column is redundant
			'cuc_actiontext' => wfMsgForContent( $actiontext ),
			'cuc_comment'    => '',
			'cuc_this_oldid' => 0,
			'cuc_last_oldid' => 0,
			'cuc_type'       => RC_LOG,
			'cuc_timestamp'  => $dbw->timestamp( wfTimestampNow() ),
			'cuc_ip'         => IP::sanitizeIP( $ip ),
			'cuc_ip_hex'     => $ip ? IP::toHex( $ip ) : null,
			'cuc_xff'        => '',
			'cuc_xff_hex'    => null,
			'cuc_agent'      => ''
		);
		$dbw->insert( 'cu_changes', $rcRow, __METHOD__ );

		return true;
	}

	/**
	 * Handler for non-standard (edit/log) entries that need IP data
	 *
	 * @param $context IContextSource
	 * @param $data Array
	 * @return bool
	 */
	protected static function onLoggableUserIPData( IContextSource $context, array $data ) {
		$user = $context->getUser();
		$request = $context->getRequest();

		// Get IP address
		$ip = $request->getIP();
		// Get XFF header
		$xff = $request->getHeader( 'X-Forwarded-For' );
		list( $xff_ip, $isSquidOnly ) = IP::getClientIPfromXFF( $xff );
		// Get agent
		$agent = $request->getHeader( 'User-Agent' );

		$dbw = wfGetDB( DB_MASTER );
		$cuc_id = $dbw->nextSequenceValue( 'cu_changes_cu_id_seq' );
		$rcRow = array(
			'cuc_id'         => $cuc_id,
			'cuc_page_id'    => $data['pageid'], // may be 0
			'cuc_namespace'  => $data['namespace'],
			'cuc_title'      => $data['title'], // may be ''
			'cuc_minor'      => 0,
			'cuc_user'       => $user->getId(),
			// 'cuc_user_text'  => $user->getName(), // SUS-3080 - this column is redundant
			'cuc_actiontext' => $data['action'],
			'cuc_comment'    => $data['comment'],
			'cuc_this_oldid' => 0,
			'cuc_last_oldid' => 0,
			'cuc_type'       => RC_LOG,
			'cuc_timestamp'  => $dbw->timestamp( $data['timestamp'] ),
			'cuc_ip'         => IP::sanitizeIP( $ip ),
			'cuc_ip_hex'     => $ip ? IP::toHex( $ip ) : null,
			'cuc_xff'        => !$isSquidOnly ? $xff : '',
			'cuc_xff_hex'    => ( $xff_ip && !$isSquidOnly ) ? IP::toHex( $xff_ip ) : null,
			'cuc_agent'      => $agent
		);
		$dbw->insert( 'cu_changes', $rcRow, __METHOD__ );

		return true;
	}

	/**
	 * Hook function to prune data from the cu_changes table
	 */
	public static function maybePruneIPData() {
		global $wgCUDMaxAge;
		# Every 100th edit, prune the checkuser changes table.
		if ( 0 == mt_rand( 0, 99 ) ) {
			$dbw = wfGetDB( DB_MASTER );
			$encCutoff = $dbw->addQuotes( $dbw->timestamp( time() - $wgCUDMaxAge ) );
			$dbw->delete( 'cu_changes', array( "cuc_timestamp < $encCutoff" ), __METHOD__ );
		}
		return true;
	}

	/** Wikia change -- moved getClientIPfromXFF() method to IP class */

	public static function checkUserSchemaUpdates( DatabaseUpdater $updater ) {
		$base = dirname( __FILE__ );

		$updater->addExtensionUpdate( array( 'CheckUserHooks::checkUserCreateTables' ) );
		if ( $updater->getDB()->getType() == 'mysql' ) {
			$updater->addExtensionUpdate( array( 'addIndex', 'cu_changes',
				'cuc_ip_hex_time', "$base/archives/patch-cu_changes_indexes.sql", true ) );
			$updater->addExtensionUpdate( array( 'addIndex', 'cu_changes',
				'cuc_user_ip_time', "$base/archives/patch-cu_changes_indexes2.sql", true ) );
		}

		return true;
	}

	public static function checkUserCreateTables( $updater ) {
		$base = dirname( __FILE__ );

        $db = $updater->getDB();
		if ( $db->tableExists( 'cu_changes' ) ) {
			$updater->output( "...cu_changes table already exists.\n" );
		} else {
			require_once "$base/install.inc";
			create_cu_changes( $db );
		}

		if ( $db->tableExists( 'cu_log' ) ) {
			$updater->output( "...cu_log table already exists.\n" );
		} else {
			require_once "$base/install.inc";
			create_cu_log( $db );
		}
	}

	/**
	 * Tell the parser test engine to create a stub cu_changes table,
	 * or temporary pages won't save correctly during the test run.
	 */
	public static function checkUserParserTestTables( &$tables ) {
		$tables[] = 'cu_changes';
		return true;
	}

	/**
	 * Add a link to Special:CheckUser on Special:Contributions/<username> for
	 * privileged users.
	 * @param $id Integer: user ID
	 * @param $nt Title: user page title
	 * @param $links Array: tool links
	 * @return true
	 */
	public static function loadCheckUserLink( $id, $nt, &$links ) {
		global $wgUser;
		if ( $wgUser->isAllowed( 'checkuser' ) ) {
			$links[] = $wgUser->getSkin()->makeKnownLinkObj(
				SpecialPage::getTitleFor( 'CheckUser' ),
				wfMsgHtml( 'checkuser-contribs' ),
				'user=' . urlencode( $nt->getText() )
			);
		}
		return true;
	}

	/**
	 * Retroactively autoblocks the last IP used by the user (if it is a user)
	 * blocked by this Block.
	 *
	 * @param Block $block
	 * @param int[] &$blockIds
	 * @return array|bool
	 */
	public static function doRetroactiveAutoblock( Block $block, array &$blockIds ) {
		$dbr = wfGetDB( DB_SLAVE );

		$user = User::newFromName( (string)$block->getTarget(), false );
		if ( !$user->getId() ) {
			return array(); // user in an IP?
		}

		$options = array( 'ORDER BY' => 'cuc_timestamp DESC' );
		$options['LIMIT'] = 1; // just the last IP used

		$res = $dbr->select( 'cu_changes',
			array( 'cuc_ip' ),
			array( 'cuc_user' => $user->getId() ),
			__METHOD__ ,
			$options
		);

		# Iterate through IPs used (this is just one or zero for now)
		foreach ( $res as $row ) {
			if ( $row->cuc_ip ) {
				$id = $block->doAutoblock( $row->cuc_ip );
				if ( $id ) $blockIds[] = $id;
			}
		}

		return false; // autoblock handled
	}
}
