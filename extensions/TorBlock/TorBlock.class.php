<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class TorBlock {
	public static $mExitNodes;

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
			wfLoadExtensionMessages( 'TorBlock' );

			// sanitize $result parameter
			$oldResult = $result; $result = array();
			if ($oldResult != array() && is_array($oldResult) && !is_array($oldResult[0]))
				$result[] = $oldResult; # A single array representing an error
			else if (is_array($oldResult) && is_array($oldResult[0]))
				$result = array_merge( $result, $oldResult ); # A nested array representing multiple result
			else if ($oldResult != '' && $oldResult != null && $oldResult !== true && $oldResult !== false)
				$result[] = array($oldResult); # A string representing a message-id
			else if ($oldResult === false )
				$result[] = array('badaccess-group0'); # a generic "We don't want them to do that"

			$result[] = array('torblock-blocked', $ip);

			return false;
		}

		return true;
	}

	public static function onAbuseFilterFilterAction( &$vars, $title ) {
		$vars->setVar( 'tor_exit_node', self::isExitNode() ? 1 : 0 );
		return true;
	}

	public static function onAbuseFilterBuilder( &$builder ) {
		wfLoadExtensionMessages( 'TorBlock' );
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
		} elseif ($nodes == 'loading') {
			// Somebody else is loading it.
			return array();
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

		// Set loading key, to prevent DoS of server.

		$wgMemc->set( 'mw-tor-exit-nodes', 'loading', 300 );

		$nodes = array();
		foreach( $wgTorIPs as $ip ) {
			$nodes = array_unique( array_merge( $nodes, self::loadNodesForIP( $ip ) ) );
		}

		// Save to cache.
		$wgMemc->set( 'mw-tor-exit-nodes', $nodes, 1800 ); // Store for half an hour.

		wfProfileOut( __METHOD__ );

		return self::$mExitNodes = $nodes;
	}

	public static function loadNodesForIP( $ip ) {
		$url = 'http://check.torproject.org/cgi-bin/TorBulkExitList.py?ip='.$ip;
		$data = Http::get( $url );
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
		#return true; ## FOR DEBUGGING
		if ($ip == null) {
			$ip = wfGetIp();
		}

		$nodes = self::getExitNodes();

		return in_array( $ip, $nodes );
	}

	public static function onGetBlockedStatus( &$user ) {
		global $wgTorDisableAdminBlocks;
		if ($wgTorDisableAdminBlocks && self::isExitNode() && $user->mBlock && !$user->mBlock->mUser) {
			wfDebug( "User using Tor node. Disabling IP block as it was probably targetted at the tor node." );
			// Node is probably blocked for being a Tor node. Remove block.
			$user->mBlockedby = 0;
		}

		return true;
	}

	public static function onAbortAutoblock( $autoblockip, &$block ) {
		return !self::isExitNode( $autoblockip );
	}

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
}
