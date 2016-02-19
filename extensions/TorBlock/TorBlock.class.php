<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class TorBlock {
	public static $mExitNodes;

	/**
	 * @static
	 * @param $title Title
	 * @param $user User
	 * @param $action
	 * @param $result
	 * @return bool
	 */
	public static function onGetUserPermissionsErrorsExpensive( &$title, &$user, $action, &$result ) {
		global $wgTorAllowedActions;
		if (in_array( $action, $wgTorAllowedActions)) {
			return true;
		}

		wfDebug( "Checking Tor status\n" );

		if (self::isExitNode()) {
			wfDebug( "-User detected as editing through tor.\n" );

			global $wgTorBypassPermissions;
			foreach( $wgTorBypassPermissions as $perm) {
				if ($user->isAllowed( $perm )) {
					wfDebug( "-User has $perm permission. Exempting from Tor Blocks\n" );
					return true;
				}
			}

			if (Block::isWhitelistedFromAutoblocks( wfGetIp() )) {
				wfDebug( "-IP is in autoblock whitelist. Exempting from Tor blocks.\n" );
				return true;
			}

			$ip = wfGetIp();
			wfDebug( "-User detected as editing from Tor node. Adding Tor block to permissions errors\n" );

			$result[] = array('torblock-blocked', $ip);

			return false;
		}

		return true;
	}

	/**
	 * @static
	 * @param $user User
	 * @param $editToken
	 * @param $hookError
	 * @return bool
	 */
	public static function onEmailUserPermissionsErrors( $user, $editToken, &$hookError ) {
		wfDebug( "Checking Tor status\n" );

		// Just in case we're checking another user
		global $wgUser;
		if ( $user->getName() != $wgUser->getName() ) {
			return true;
		}

		if (self::isExitNode()) {
			wfDebug( "-User detected as editing through tor.\n" );

			global $wgTorBypassPermissions;
			foreach( $wgTorBypassPermissions as $perm) {
				if ($user->isAllowed( $perm )) {
					wfDebug( "-User has $perm permission. Exempting from Tor Blocks\n" );
					return true;
				}
			}

			if (Block::isWhitelistedFromAutoblocks( wfGetIp() )) {
				wfDebug( "-IP is in autoblock whitelist. Exempting from Tor blocks.\n" );
				return true;
			}

			$ip = wfGetIp();
			wfDebug( "-User detected as editing from Tor node. Denying email.\n" );

			$hookError = array( 'permissionserrors', 'torblock-blocked', array( $ip ) );
			return false;
		}

		return true;
	}

	public static function onAbuseFilterFilterAction( &$vars, $title ) {
		$vars->setVar( 'tor_exit_node', self::isExitNode() ? 1 : 0 );
		return true;
	}

	public static function onAbuseFilterBuilder( &$builder ) {
		$builder['vars']['tor_exit_node'] = 'tor-exit-node';
		return true;
	}

	public static function getExitNodes() {
		if (is_array(self::$mExitNodes)) {
			wfDebug( "Loading Tor exit node list from memory.\n" );
			return self::$mExitNodes;
		}

		global $wgMemc;

		$nodes = $wgMemc->get( 'mw-tor-exit-nodes' ); // No use of wfMemcKey because it should be multi-wiki.

		if (is_array($nodes)) {
			wfDebug( "Loading Tor exit node list from memcached.\n" );
			// Lucky.
			return self::$mExitNodes = $nodes;
		} else {
			$liststatus = $wgMemc->get( 'mw-tor-list-status' );
			if ( $liststatus == 'loading' ) {
				// Somebody else is loading it.
				wfDebug( "Old Tor list expired and we are still loading the new one.\n" );
				return array();
			} elseif ( $liststatus == 'loaded' ) {
				$nodes = $wgMemc->get( 'mw-tor-exit-nodes' );
				if (is_array($nodes)) {
					return self::$mExitNodes = $nodes;
				} else {
					wfDebug( "Tried very hard to get the Tor list since mw-tor-list-status says it is loaded, to no avail.\n" );
					return array();
				}
			}
		}

		// We have to actually load from the server.

		global $wgTorLoadNodes;
		if (!$wgTorLoadNodes) {
			// Disabled.
			wfDebug( "Unable to load Tor exit node list: cold load disabled on page-views.\n" );
			return array();
		}

		wfDebug( "Loading Tor exit node list cold.\n" );

		return self::loadExitNodes();
	}

	public static function loadExitNodes() {
		wfProfileIn( __METHOD__ );

		global $wgTorIPs, $wgMemc;

		// we want to trace when the memcache entry expires and we generate new
		if ( class_exists( 'Wikia\\Logger\\WikiaLogger' ) ) {
			\Wikia\Logger\WikiaLogger::instance()->debug( 'TorBlock::loadExitNodes' );
		}

		// Set loading key, to prevent DoS of server.

		$wgMemc->set( 'mw-tor-list-status', 'loading', 300 );

		$nodes = array();
		foreach( $wgTorIPs as $ip ) {
			$nodes = array_unique( array_merge( $nodes, self::loadNodesForIP( $ip ) ) );
		}

		// Save to cache.
		$wgMemc->set( 'mw-tor-exit-nodes', $nodes, 1800 ); // Store for half an hour.
		$wgMemc->set( 'mw-tor-list-status', 'loaded', 1800 );

		wfProfileOut( __METHOD__ );

		return self::$mExitNodes = $nodes;
	}

	public static function loadNodesForIP( $ip ) {
		$url = 'https://check.torproject.org/cgi-bin/TorBulkExitList.py?ip='.$ip;
		$data = ExternalHttp::get( $url, 'default', array( 'sslVerifyCert' => false ) );
		$lines = explode("\n", $data);

		$nodes = array();
		foreach( $lines as $line ) {
			if (strpos( $line, '#' )===false) {
				$nodes[] = trim($line);
			}
		}

		return $nodes;
	}

	public static function isExitNode($ip = null) {
		if ($ip == null) {
			$ip = wfGetIp();
		}

		$nodes = self::getExitNodes();

		return in_array( $ip, $nodes );
	}

	/**
	 * @static
	 * @param $user User
	 * @return bool
	 */
	public static function onGetBlockedStatus( &$user ) {
		global $wgTorDisableAdminBlocks;
		if ( $wgTorDisableAdminBlocks && self::isExitNode() && $user->mBlock && $user->mBlock->getType() != Block::TYPE_USER ) {
			wfDebug( "User using Tor node. Disabling IP block as it was probably targetted at the tor node." );

			// Node is probably blocked for being a Tor node. Remove block.
			$user->mBlockedby = 0;
		}

		return true;
	}

	public static function onAbortAutoblock( $autoblockip, &$block ) {
		return !self::isExitNode( $autoblockip );
	}

	/**
	 * @static
	 * @param $user User
	 * @param $promote
	 * @return bool
	 */
	public static function onGetAutoPromoteGroups( $user, &$promote ) {
		// Check against stricter requirements for tor nodes.
		// Counterintuitively, we do the requirement checks first.
		// This is so that we don't have to hit memcached to get the
		// exit list, unnecessarily.

		if (!count($promote)) {
			return true; // No groups to promote to anyway
		}

		$age = time() - wfTimestampOrNull( TS_UNIX, $user->getRegistration() );
		global $wgTorAutoConfirmAge, $wgTorAutoConfirmCount;

		if ($age >= $wgTorAutoConfirmAge && $user->getEditCount() >= $wgTorAutoConfirmCount) {
			return true; // Does match requirements. Don't bother checking if we're an exit node.
		}

		if (self::isExitNode()) { // Tor user, doesn't match the expanded requirements.
			$promote = array();
		}

		return true;
	}

	public static function onAutopromoteCondition( $type, $args, $user, &$result ) {
		if ($type == APCOND_TOR) {
			$result = self::isExitNode();
		}

		return true;
	}

	public static function onRecentChangeSave( $recentChange ) {
		global $wgTorTagChanges;

		if ( class_exists('ChangeTags') && $wgTorTagChanges && self::isExitNode() ) {
			ChangeTags::addTags( 'tor', $recentChange->mAttribs['rc_id'], $recentChange->mAttribs['rc_this_oldid'], $recentChange->mAttribs['rc_logid'] );
		}
		return true;
	}

	public static function onListDefinedTags( &$emptyTags ) {
		global $wgTorTagChanges;

		if ($wgTorTagChanges)
			$emptyTags[] = 'tor';
		return true;
	}

	/**
	 * Creates a message with the status
	 * @param array $msg Message with the status
	 * @param string $ip The IP address to be checked
	 * @return boolean true
	 */
	public static function getTorBlockStatus( &$msg, $ip ) {
		// IP addresses can be blocked only
		// Fast return if IP is not an exit node
		if ( !IP::isIPAddress( $ip ) || !self::isExitNode( $ip ) ) {
			return true;
		}

		$msg[] = Html::rawElement(
			'span',
			array( 'class' => 'mw-torblock-isexitnode' ),
			wfMsgExt( 'torblock-isexitnode', 'parseinline', $ip )
		);
		return true;
	}
}
