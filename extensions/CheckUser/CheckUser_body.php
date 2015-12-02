<?php

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "CheckUser extension\n";
	exit( 1 );
}

class CheckUser extends SpecialPage {

	const LIMIT = 1000;

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		global $wgUser;
		parent::__construct( 'CheckUser', 'checkuser' );

		$this->sk = $wgUser->getSkin();
	}

	public function execute( $subpage ) {
		global $wgRequest, $wgOut;

		$this->checkPermissions();
		$this->setHeaders();

		$user = $wgRequest->getText( 'user' ) ?
			$wgRequest->getText( 'user' ) : $wgRequest->getText( 'ip' );
		$user = trim( $user );
		$reason = $wgRequest->getText( 'reason' );
		$blockreason = $wgRequest->getText( 'blockreason' );
		$checktype = $wgRequest->getVal( 'checktype' );
		$period = $wgRequest->getInt( 'period' );
		$users = $wgRequest->getArray( 'users' );
		$tag = $wgRequest->getBool( 'usetag' ) ?
			trim( $wgRequest->getVal( 'tag' ) ) : '';
		$talkTag = $wgRequest->getBool( 'usettag' ) ?
			trim( $wgRequest->getVal( 'talktag' ) ) : '';

		$m = array();
		# An IPv4? An IPv6? CIDR included?
		if ( IP::isIPAddress( $user ) ) {
			$ip = IP::sanitizeIP( $user );
			$name = '';
			$xff = '';
		# An IPv4/IPv6 XFF string? CIDR included?
		} elseif ( preg_match( '/^(.+)\/xff$/', $user, $m ) && IP::isIPAddress( $m[1] ) ) {
			$ip = '';
			$name = '';
			$xff = IP::sanitizeIP( $m[1] );
		# A user?
		} else {
			$ip = '';
			$name = $user;
			$xff = '';
		}

		$this->showForm( $user, $reason, $checktype, $ip, $xff, $name, $period );

		# Perform one of the various submit operations...
		if ( $wgRequest->wasPosted() ) {
			if ( !$this->getUser()->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
				$wgOut->wrapWikiMsg( '<div class="error">$1</div>', 'checkuser-token-fail' );
			} elseif ( $wgRequest->getVal( 'action' ) === 'block' ) {
				$this->doMassUserBlock( $users, $blockreason, $tag, $talkTag );
			} elseif ( !$this->checkReason( $reason ) ) {
				$wgOut->addWikiMsg( 'checkuser-noreason' );
			} elseif ( $checktype == 'subuserips' ) {
				$this->doUserIPsRequest( $name, $reason, $period );
			} elseif ( $xff && $checktype == 'subedits' ) {
				$this->doIPEditsRequest( $xff, true, $reason, $period );
			} elseif ( $ip && $checktype == 'subedits' ) {
				$this->doIPEditsRequest( $ip, false, $reason, $period );
			} elseif ( $name && $checktype == 'subedits' ) {
				$this->doUserEditsRequest( $user, $reason, $period );
			} elseif ( $xff && $checktype == 'subipusers' ) {
				$this->doIPUsersRequest( $xff, true, $reason, $period, $tag, $talkTag );
			} elseif ( $checktype == 'subipusers' ) {
				$this->doIPUsersRequest( $ip, false, $reason, $period, $tag, $talkTag );
			}
		}
		# Add CIDR calculation convenience form
		$this->addJsCIDRForm();
		$wgOut->addModules( 'ext.checkUser' ); // JS
	}

	/**
	 * As we use the same small set of messages in various methods and that
	 * they are called often, we call them once and save them in $this->message
	 */
	protected function preCacheMessages() {
		// Precache various messages
		if ( !isset( $this->message ) ) {
			foreach ( array( 'diff', 'hist', 'minoreditletter', 'newpageletter', 'blocklink', 'log' ) as $msg ) {
				$this->message[$msg] = wfMsgExt( $msg, array( 'escape' ) );
			}
		}
	}

	/**
	 * @return Title
	 */
	public function getCheckUserLogTitle() {
		if ( !isset( $this->checkUserLogTitle ) ) {
			$this->checkUserLogTitle = SpecialPage::getTitleFor( 'CheckUserLog' );
		}
		return $this->checkUserLogTitle;
	}

	protected function showGuide() {
		global $wgOut;
		$wgOut->addWikiText( wfMsg( 'checkuser-summary' ) .
			"\n\n[[" . $this->getCheckUserLogTitle()->getPrefixedText() .
				'|' . wfMsg( 'checkuser-showlog' ) . ']]'
		);
	}

	protected function showForm( $user, $reason, $checktype, $ip, $xff, $name, $period ) {
		global $wgOut, $wgUser;
		$action = $this->getTitle()->escapeLocalUrl();
		# Fill in requested type if it makes sense
		$encipusers = $encedits = $encuserips = 0;
		if ( $checktype == 'subipusers' && ( $ip || $xff ) ) {
			$encipusers = 1;
		} elseif ( $checktype == 'subuserips' && $name ) {
			$encuserips = 1;
		} elseif ( $checktype == 'subedits' ) {
			$encedits = 1;
		# Defaults otherwise
		} elseif ( $ip || $xff ) {
			$encedits = 1;
		} else {
			$encuserips = 1;
		}
		# Compile our nice form...
		# Username field should fit things like "2001:0db8:85a3:08d3:1319:8a2e:0370:7344/100/xff"
		$this->showGuide(); // explanation text

		$form = Xml::openElement( 'form', array( 'action' => $action,
			'name' => 'checkuserform', 'id' => 'checkuserform', 'method' => 'post' ) );
		$form .= '<fieldset><legend>' . wfMsgHtml( 'checkuser-query' ) . '</legend>';
		$form .= Xml::openElement( 'table', array( 'style' => 'border:0' ) );
		$form .= '<tr>';
		$form .= '<td>' . wfMsgHtml( 'checkuser-target' ) . '</td>';
		$form .= '<td>' . Xml::input( 'user', 46, $user, array( 'id' => 'checktarget' ) );
		$form .= '&#160;' . $this->getPeriodMenu( $period ) . '</td>';
		$form .= '</tr><tr>';
		$form .= '<td></td>';
		$form .= Xml::openElement( 'td', array( 'class' => 'checkuserradios' ) );
		$form .= Xml::openElement( 'table', array( 'style' => 'border:0' ) );
		$form .= '<tr>';
		$form .= '<td>' .
			Xml::radio( 'checktype', 'subuserips', $encuserips, array( 'id' => 'subuserips' ) );
		$form .= ' ' . Xml::label( wfMsg( 'checkuser-ips' ), 'subuserips' ) . '</td>';
		$form .= '<td>' .
			Xml::radio( 'checktype', 'subedits', $encedits, array( 'id' => 'subedits' ) );
		$form .= ' ' . Xml::label( wfMsg( 'checkuser-edits' ), 'subedits' ) . '</td>';
		$form .= '<td>' .
			Xml::radio( 'checktype', 'subipusers', $encipusers, array( 'id' => 'subipusers' ) );
		$form .= ' ' . Xml::label( wfMsg( 'checkuser-users' ), 'subipusers' ) . '</td>';
		$form .= '</tr>';
		$form .= Xml::closeElement( 'table' );
		$form .= Xml::closeElement( 'td' );
		$form .= '</tr><tr>';
		$form .= '<td>' . wfMsgHtml( 'checkuser-reason' ) . '</td>';
		$form .= '<td>' . Xml::input( 'reason', 46, $reason,
			array( 'maxlength' => '150', 'id' => 'checkreason' ) );
		$form .= '&#160; &#160;' . Xml::submitButton( wfMsg( 'checkuser-check' ),
			array( 'id' => 'checkusersubmit', 'name' => 'checkusersubmit' ) ) . '</td>';
		$form .= '</tr>';
		$form .= Xml::closeElement( 'table' );
		$form .= '</fieldset>';
		$form .= Html::hidden( 'wpEditToken', $wgUser->getEditToken() );
		$form .= Xml::closeElement( 'form' );
		# Output form
		$wgOut->addHTML( $form );
	}

	/**
	 * Get a selector of time period options
	 * @param int $selected, selected level
	 */
	protected function getPeriodMenu( $selected = null ) {
		$s = '<label for="period">' . wfMsgHtml( 'checkuser-period' ) . '</label>&#160;';
		$s .= Xml::openElement( 'select', array( 'name' => 'period', 'id' => 'period', 'style' => 'margin-top:.2em;' ) );
		$s .= Xml::option( wfMsg( 'checkuser-week-1' ), 7, $selected === 7 );
		$s .= Xml::option( wfMsg( 'checkuser-week-2' ), 14, $selected === 14 );
		$s .= Xml::option( wfMsg( 'checkuser-month' ), 31, $selected === 31 );
		$s .= Xml::option( wfMsg( 'checkuser-all' ), 0, $selected === 0 );
		$s .= Xml::closeElement( 'select' ) . "\n";
		return $s;
	}

	/**
	 * Make a quick JS form for admins to calculate block ranges
	 */
	protected function addJsCIDRForm() {
		global $wgOut;
		$s = '<fieldset id="mw-checkuser-cidrform" style="display:none; clear:both;">' .
			'<legend>' . wfMsgHtml( 'checkuser-cidr-label' ) . '</legend>';
		$s .= '<textarea id="mw-checkuser-iplist" rows="5" cols="50"></textarea><br />';
		$s .= wfMsgHtml( 'checkuser-cidr-res' ) . '&#160;' .
			Xml::input( 'mw-checkuser-cidr-res', 35, '', array( 'id' => 'mw-checkuser-cidr-res' ) ) .
			'&#160;<strong id="mw-checkuser-ipnote"></strong>';
		$s .= '</fieldset>';
		$wgOut->addHTML( $s );
	}

	/**
	 * FIXME: documentation incomplete
	 * Block a list of selected users
	 * @param array $users
	 * @param string $reason
	 * @param string $tag
	 */
	protected function doMassUserBlock( $users, $reason = '', $tag = '', $talkTag = '' ) {
		global $wgOut, $wgUser, $wgCheckUserMaxBlocks, $wgLang;
		if ( empty( $users ) || $wgUser->isBlocked( false ) ) {
			$wgOut->addWikiMsg( 'checkuser-block-failure' );
			return;
		} elseif ( count( $users ) > $wgCheckUserMaxBlocks ) {
			$wgOut->addWikiMsg( 'checkuser-block-limit' );
			return;
		} elseif ( !$reason ) {
			$wgOut->addWikiMsg( 'checkuser-block-noreason' );
			return;
		}
		$safeUsers = self::doMassUserBlockInternal( $users, $reason, $tag, $talkTag );
		if ( !empty( $safeUsers ) ) {
			$n = count( $safeUsers );
			$ulist = $wgLang->listToText( $safeUsers );
			$wgOut->addWikiMsg( 'checkuser-block-success', $ulist, $wgLang->formatNum( $n ) );
		} else {
			$wgOut->addWikiMsg( 'checkuser-block-failure' );
		}
	}

	/**
	 * Block a list of selected users
	 *
	 * @param $users Array
	 * @param $reason String
	 * @param $tag String: replaces user pages
	 * @param $talkTag String: replaces user talk pages
	 * @return Array: list of html-safe usernames
	 */
	public static function doMassUserBlockInternal( $users, $reason = '', $tag = '', $talkTag = '' ) {
		global $wgUser;
		$counter = $blockSize = 0;
		$safeUsers = array();
		$log = new LogPage( 'block' );
		foreach ( $users as $name ) {
			# Enforce limits
			$counter++;
			$blockSize++;
			# Lets not go *too* fast
			if ( $blockSize >= 20 ) {
				$blockSize = 0;
				wfWaitForSlaves();
			}
			$u = User::newFromName( $name, false );
			// If user doesn't exist, it ought to be an IP then
			if ( is_null( $u ) || ( !$u->getId() && !IP::isIPAddress( $u->getName() ) ) ) {
				continue;
			}
			$userTitle = $u->getUserPage();
			$userTalkTitle = $u->getTalkPage();
			$userpage = new Article( $userTitle );
			$usertalk = new Article( $userTalkTitle );
			$safeUsers[] = '[[' . $userTitle->getPrefixedText() . '|' . $userTitle->getText() . ']]';
			$expirestr = $u->getId() ? 'indefinite' : '1 week';
			$expiry = SpecialBlock::parseExpiryInput( $expirestr );
			$anonOnly = IP::isIPAddress( $u->getName() ) ? 1 : 0;

			// Create the block
			$block = new Block();
			$block->setTarget( $u );
			$block->setBlocker( $wgUser );
			$block->mReason = $reason;
			$block->mExpiry = $expiry;
			$block->isHardblock( !IP::isIPAddress( $u->getName() ) );
			$block->isAutoblocking( true );
			$block->prevents( 'createaccount', true );
			$block->prevents( 'sendemail', false );
			$block->prevents( 'editownusertalk', false );

			$oldblock = Block::newFromTarget( $u->getName() );
			if ( !$oldblock ) {
				$block->insert();
				# Prepare log parameters
				$logParams = array();
				$logParams[] = $expirestr;
				if ( $anonOnly ) {
					$logParams[] = 'anononly';
				}
				$logParams[] = 'nocreate';
				# Add log entry
				$log->addEntry( 'block', $userTitle, $reason, $logParams );
			}
			# Tag userpage! (check length to avoid mistakes)
			if ( strlen( $tag ) > 2 ) {
				$userpage->doEdit( $tag, $reason, EDIT_MINOR );
			}
			if ( strlen( $talkTag ) > 2 ) {
				$usertalk->doEdit( $talkTag, $reason, EDIT_MINOR );
			}
		}
		return $safeUsers;
	}

	// Give a "no matches found for X" message.
	// If $checkLast, then mention the last edit by this user or IP.
	protected function noMatchesMessage( $userName, $checkLast = true ) {
		global $wgLang;
		if ( $checkLast ) {
			$dbr = wfGetDB( DB_SLAVE );
			$user_id = User::idFromName( $userName );
			if ( $user_id ) {
				$revEdit = $dbr->selectField( 'revision',
					'rev_timestamp',
					array( 'rev_user' => $user_id ),
					__METHOD__,
					array( 'ORDER BY' => 'rev_timestamp DESC' )
				);
				$logEdit = $dbr->selectField( 'logging',
					'log_timestamp',
					array( 'log_user' => $user_id ),
					__METHOD__,
					array( 'ORDER BY' => 'log_timestamp DESC' )
				);
			} else {
				$revEdit = $dbr->selectField( 'revision',
					'rev_timestamp',
					array( 'rev_user_text' => $userName ),
					__METHOD__,
					array( 'ORDER BY' => 'rev_timestamp DESC' )
				);
				$logEdit = false; // no log_user_text index
			}
			$lastEdit = max( $revEdit, $logEdit );
			if ( $lastEdit ) {
				$lastEditDate = $wgLang->date( wfTimestamp( TS_MW, $lastEdit ), true );
				$lastEditTime = $wgLang->time( wfTimestamp( TS_MW, $lastEdit ), true );
				// FIXME: don't pass around parsed messages
				return wfMsgExt( 'checkuser-nomatch-edits', 'parse', $lastEditDate, $lastEditTime );
			}
		}
		return wfMsgExt( 'checkuser-nomatch', 'parse' );
	}

	protected function checkReason( $reason ) {
		global $wgCheckUserForceSummary;
		return ( !$wgCheckUserForceSummary || strlen( $reason ) );
	}

	/**
	 * FIXME: documentation out of date
	 * @param string $ip <???
	 * @param bool $xfor <???
	 * @param string $reason
	 * Get all IPs used by a user
	 * Shows first and last date and number of edits
	 */
	protected function doUserIPsRequest( $user , $reason = '', $period = 0 ) {
		global $wgOut, $wgLang;

		$userTitle = Title::newFromText( $user, NS_USER );
		if ( !is_null( $userTitle ) ) {
			// normalize the username
			$user = $userTitle->getText();
		}
		# IPs are passed in as a blank string
		if ( !$user ) {
			$wgOut->addWikiMsg( 'nouserspecified' );
			return;
		}
		# Get ID, works better than text as user may have been renamed
		$user_id = User::idFromName( $user );

		# If user is not IP or nonexistent
		if ( !$user_id ) {
			// FIXME: addWikiMsg
			$s = wfMsgExt( 'nosuchusershort', array( 'parse' ), $user );
			$wgOut->addHTML( $s );
			return;
		}

		# Record check...
		if ( !self::addLogEntry( 'userips', 'user', $user, $reason, $user_id ) ) {
			// FIXME: addWikiMsg
			$wgOut->addHTML( '<p>' . wfMsgHtml( 'checkuser-log-fail' ) . '</p>' );
		}

		$dbr = wfGetDB( DB_SLAVE );
		$time_conds = $this->getTimeConds( $period );
		# Ordering by the latest timestamp makes a small filesort on the IP list

		$ret = $dbr->select(
			'cu_changes',
			array(
				'cuc_ip',
				'cuc_ip_hex',
				'COUNT(*) AS count',
				'MIN(cuc_timestamp) AS first',
				'MAX(cuc_timestamp) AS last',
			),
			array( 'cuc_user' => $user_id, $time_conds ),
			__METHOD__,
			array(
				'ORDER BY' => 'last DESC',
				'GROUP BY' => 'cuc_ip,cuc_ip_hex',
				'LIMIT' => self::LIMIT + 1,
				'USE INDEX' => 'cuc_user_ip_time',
			)
		);

		if ( !$dbr->numRows( $ret ) ) {
			$s = $this->noMatchesMessage( $user ) . "\n";
		} else {
			$blockip = SpecialPage::getTitleFor( 'Block' );
			$ips_edits = array();
			$counter = 0;
			foreach ( $ret as $row ) {
				if ( $counter >= self::LIMIT ) {
					// FIXME: addWikiMSG
					$wgOut->addHTML( wfMsgExt( 'checkuser-limited', array( 'parse' ) ) );
					break;
				}
				$ips_edits[$row->cuc_ip] = $row->count;
				$ips_first[$row->cuc_ip] = $row->first;
				$ips_last[$row->cuc_ip] = $row->last;
				$ips_hex[$row->cuc_ip] = $row->cuc_ip_hex;
				++$counter;
			}
			// Count pinging might take some time...make sure it is there
			wfSuppressWarnings();
			set_time_limit( 60 );
			wfRestoreWarnings();

			$logs = SpecialPage::getTitleFor( 'Log' );
			$s = '<div id="checkuserresults"><ul>';
			foreach ( $ips_edits as $ip => $edits ) {
				$s .= '<li>';
				$s .= '<a href="' .
					$this->getTitle()->escapeLocalURL( 'user=' . urlencode( $ip ) . '&reason=' . urlencode( $reason ) ) . '">' .
					htmlspecialchars( $ip ) . '</a>';
				$s .= ' (<a href="' . $blockip->escapeLocalURL( 'ip=' . urlencode( $ip ) ) . '">' .
					wfMsgHtml( 'blocklink' ) . '</a>)';
				if ( $ips_first[$ip] == $ips_last[$ip] ) {
					$s .= ' (' . $wgLang->timeanddate( wfTimestamp( TS_MW, $ips_first[$ip] ), true ) . ') ';
				} else {
					$s .= ' (' . $wgLang->timeanddate( wfTimestamp( TS_MW, $ips_first[$ip] ), true ) .
						' -- ' . $wgLang->timeanddate( wfTimestamp( TS_MW, $ips_last[$ip] ), true ) . ') ';
				}
				$s .= ' <strong>[' . $edits . ']</strong>';

				# If we get some results, it helps to know if the IP in general
				# has a lot more edits, e.g. "tip of the iceberg"...
				$ipedits = $dbr->estimateRowCount( 'cu_changes', '*',
					array( 'cuc_ip_hex' => $ips_hex[$ip], $time_conds ),
					__METHOD__ );
				# If small enough, get a more accurate count
				if ( $ipedits <= 1000 ) {
					$ipedits = $dbr->selectField( 'cu_changes', 'COUNT(*)',
						array( 'cuc_ip_hex' => $ips_hex[$ip], $time_conds ),
						__METHOD__ );
				}
				if ( $ipedits > $ips_edits[$ip] ) {
					$s .= ' <i>(' . wfMsgHtml( 'checkuser-ipeditcount', $ipedits ) . ')</i>';
				}

				# If this IP is blocked, give a link to the block log
				$s .= $this->getIPBlockInfo( $ip );
				$s .= '<div style="margin-left:5%">';
				$s .= '<small>' . wfMsgExt( 'checkuser-toollinks', array( 'parseinline' ), urlencode( $ip ) ) . '</small>';
				$s .= '</div>';
				$s .= "</li>\n";
			}
			$s .= '</ul></div>';
		}
		$wgOut->addHTML( $s );
	}

	protected function getIPBlockInfo( $ip ) {
		$block = Block::newFromTarget( null, $ip, false );
		if ( $block instanceof Block ) {
			if ( $block->getType() == Block::TYPE_RANGE ) {
				$userpage = Title::makeTitle( NS_USER, $block->getTarget() );
				$blocklog = $this->sk->makeKnownLinkObj(
					SpecialPage::getTitleFor( 'Log' ),
					wfMsgHtml( 'checkuser-blocked' ),
					'type=block&page=' . urlencode( $userpage->getPrefixedText() )
				);
				return ' <strong>(' . $blocklog . ' - ' . $block->getTarget() . ')</strong>';
			} elseif ( $block->getType() == Block::TYPE_AUTO ) {
				$blocklog = $this->sk->makeKnownLinkObj(
					SpecialPage::getTitleFor( 'BlockList' ),
					wfMsgHtml( 'checkuser-blocked' ),
					'ip=' . urlencode( "#{$block->getId()}" )
				);
				return ' <strong>(' . $blocklog . ')</strong>';
			} else {
				$userpage = Title::makeTitle( NS_USER, $block->getTarget() );
				$blocklog = $this->sk->makeKnownLinkObj(
					SpecialPage::getTitleFor( 'Log' ),
					wfMsgHtml( 'checkuser-blocked' ),
					'type=block&page=' . urlencode( $userpage->getPrefixedText() )
				);
				return ' <strong>(' . $blocklog . ')</strong>';
			}
		}
		return '';
	}

	/**
	 * @param string $ip
	 * @param bool $xfor
	 * @param string $reason
	 * FIXME: $period ???
	 * Shows all edits in Recent Changes by this IP (or range) and who made them
	 */
	protected function doIPEditsRequest( $ip, $xfor = false, $reason = '', $period = 0 ) {
		global $wgOut, $wgLang;
		$dbr = wfGetDB( DB_SLAVE );
		# Invalid IPs are passed in as a blank string
		$ip_conds = self::getIpConds( $dbr, $ip, $xfor );
		if ( !$ip || $ip_conds === false ) {
			$wgOut->addWikiMsg( 'badipaddress' );
			return;
		}

		$logType = 'ipedits';
		if ( $xfor ) {
			$logType .= '-xff';
		}
		# Record check...
		if ( !self::addLogEntry( $logType, 'ip', $ip, $reason ) ) {
			$wgOut->addWikiMsg( 'checkuser-log-fail' );
		}

		$ip_conds = $dbr->makeList( $ip_conds, LIST_AND );
		$time_conds = $this->getTimeConds( $period );
		# Ordered in descent by timestamp. Can cause large filesorts on range scans.
		# Check how many rows will need sorting ahead of time to see if this is too big.
		# Also, if we only show self::LIMIT, too many will be ignored as well.
		$index = $xfor ? 'cuc_xff_hex_time' : 'cuc_ip_hex_time';
		if ( strpos( $ip, '/' ) !== false ) {
			# Quick index check only OK if no time constraint
			if ( $period ) {
				$rangecount = $dbr->selectField( 'cu_changes', 'COUNT(*)',
					array( $ip_conds, $time_conds ),
					__METHOD__,
					array( 'USE INDEX' => $index ) );
			} else {
				$rangecount = $dbr->estimateRowCount( 'cu_changes', '*',
					array( $ip_conds ),
					__METHOD__,
					array( 'USE INDEX' => $index ) );
			}
			// Sorting might take some time...make sure it is there
			wfSuppressWarnings();
			set_time_limit( 60 );
			wfRestoreWarnings();
		}
		$counter = 0;
		# See what is best to do after testing the waters...
		if ( isset( $rangecount ) && $rangecount > self::LIMIT ) {
			$ret = $dbr->select( 'cu_changes',
				array( 'cuc_ip_hex', 'COUNT(*) AS count', 'MIN(cuc_timestamp) AS first', 'MAX(cuc_timestamp) AS last' ),
				array( $ip_conds, $time_conds ),
				__METHOD__,
				array(
					'GROUP BY' => 'cuc_ip_hex',
					'ORDER BY' => 'cuc_ip_hex',
					'LIMIT' => self::LIMIT + 1,
					'USE INDEX' => $index,
				)
			);
			# List out each IP that has edits
			$s = wfMsgExt( 'checkuser-too-many', array( 'parse' ) );
			$s .= '<ol>';
			foreach ( $ret as $row ) {
				if ( $counter >= self::LIMIT ) {
					// FIXME: addWikiMsg
					$wgOut->addHTML( wfMsgExt( 'checkuser-limited', array( 'parse' ) ) );
					break;
				}
				# Convert the IP hexes into normal form
				if ( strpos( $row->cuc_ip_hex, 'v6-' ) !== false ) {
					$ip = substr( $row->cuc_ip_hex, 3 );
					$ip = IP::HextoOctet( $ip );
				} else {
					$ip = long2ip( wfBaseConvert( $row->cuc_ip_hex, 16, 10, 8 ) );
				}
				$s .= '<li><a href="' .
					$this->getTitle()->escapeLocalURL( 'user=' . urlencode( $ip ) . '&reason=' . urlencode( $reason ) . '&checktype=subipusers' ) .
					'">' . $ip . '</a>';
				if ( $row->first == $row->last ) {
					$s .= ' (' . $wgLang->timeanddate( wfTimestamp( TS_MW, $row->first ), true ) . ') ';
				} else {
					$s .= ' (' . $wgLang->timeanddate( wfTimestamp( TS_MW, $row->first ), true ) .
					' -- ' . $wgLang->timeanddate( wfTimestamp( TS_MW, $row->last ), true ) . ') ';
				}
				$s .= ' [<strong>' . $row->count . "</strong>]</li>\n";
				++$counter;
			}
			$s .= '</ol>';

			$wgOut->addHTML( $s );
			return;
		} elseif ( isset( $rangecount ) && !$rangecount ) {
			$s = $this->noMatchesMessage( $ip, !$xfor ) . "\n";
			$wgOut->addHTML( $s );
			return;
		}

		# OK, do the real query...

		$ret = $dbr->select(
			'cu_changes',
			array(
				'cuc_namespace', 'cuc_title', 'cuc_user', 'cuc_user_text', 'cuc_comment', 'cuc_actiontext',
				'cuc_timestamp', 'cuc_minor', 'cuc_page_id', 'cuc_type', 'cuc_this_oldid',
				'cuc_last_oldid', 'cuc_ip', 'cuc_xff', 'cuc_agent'
			),
			array( $ip_conds, $time_conds ),
			__METHOD__,
			array(
				'ORDER BY' => 'cuc_timestamp DESC',
				'LIMIT' => self::LIMIT + 1,
				'USE INDEX' => $index,
			)
		);

		if ( !$dbr->numRows( $ret ) ) {
			$s = $this->noMatchesMessage( $ip, !$xfor ) . "\n";
		} else {
			# Cache common messages
			$this->preCacheMessages();
			# Try to optimize this query
			$lb = new LinkBatch;
			foreach ( $ret as $row ) {
				$userText = str_replace( ' ', '_', $row->cuc_user_text );
				$lb->add( $row->cuc_namespace, $row->cuc_title );
				$lb->add( NS_USER, $userText );
				$lb->add( NS_USER_TALK, $userText );
			}
			$lb->execute();
			$ret->seek( 0 );
			# List out the edits
			$s = '<div id="checkuserresults">';
			foreach ( $ret as $row ) {
				if ( $counter >= self::LIMIT ) {
					// FIXME: addWikiMsg
					$wgOut->addHTML( wfMsgExt( 'checkuser-limited', array( 'parse' ) ) );
					break;
				}
				$s .= $this->CUChangesLine( $row, $reason );
				++$counter;
			}
			$s .= '</ul></div>';
		}

		$wgOut->addHTML( $s );
	}

	/**
	 * @param string $user
	 * @param string $reason
	 * Shows all edits in Recent Changes by this user
	 */
	protected function doUserEditsRequest( $user, $reason = '', $period = 0 ) {
		global $wgOut;

		$userTitle = Title::newFromText( $user, NS_USER );
		if ( !is_null( $userTitle ) ) {
			// normalize the username
			$user = $userTitle->getText();
		}
		# IPs are passed in as a blank string
		if ( !$user ) {
			$wgOut->addWikiMsg( 'nouserspecified' );
			return;
		}
		# Get ID, works better than text as user may have been renamed
		$user_id = User::idFromName( $user );

		# If user is not IP or nonexistent
		if ( !$user_id ) {
			$s = wfMsgExt( 'nosuchusershort', array( 'parse' ), $user );
			$wgOut->addHTML( $s );
			return;
		}

		# Record check...
		if ( !self::addLogEntry( 'useredits', 'user', $user, $reason, $user_id ) ) {
			$wgOut->addHTML( '<p>' . wfMsgHtml( 'checkuser-log-fail' ) . '</p>' );
		}

		$dbr = wfGetDB( DB_SLAVE );
		$user_cond = "cuc_user = '$user_id'";
		$time_conds = $this->getTimeConds( $period );
		# Ordered in descent by timestamp. Causes large filesorts if there are many edits.
		# Check how many rows will need sorting ahead of time to see if this is too big.
		# If it is, sort by IP,time to avoid the filesort.
		if ( $period ) {
			$count = $dbr->selectField( 'cu_changes', 'COUNT(*)',
				array( $user_cond, $time_conds ),
				__METHOD__,
				array( 'USE INDEX' => 'cuc_user_ip_time' ) );
		} else {
			$count = $dbr->estimateRowCount( 'cu_changes', '*',
				array( $user_cond, $time_conds ),
				__METHOD__,
				array( 'USE INDEX' => 'cuc_user_ip_time' ) );
		}
		# Cache common messages
		$this->preCacheMessages();
		# See what is best to do after testing the waters...
		if ( $count > self::LIMIT ) {
			$wgOut->addHTML( wfMsgExt( 'checkuser-limited', array( 'parse' ) ) );

			$ret = $dbr->select(
				'cu_changes',
				'*',
				array( $user_cond, $time_conds ),
				__METHOD__,
				array(
					'ORDER BY' => 'cuc_ip ASC, cuc_timestamp DESC',
					'LIMIT' => self::LIMIT,
					'USE INDEX' => 'cuc_user_ip_time'
				)
			);
			# Try to optimize this query
			$lb = new LinkBatch;
			foreach ( $ret as $row ) {
				$lb->add( $row->cuc_namespace, $row->cuc_title );
			}
			$lb->execute();
			$ret->seek( 0 );
			$s = '';
			foreach ( $ret as $row ) {
				if ( !$ip = htmlspecialchars( $row->cuc_ip ) ) {
					continue;
				}
				if ( !isset( $lastIP ) ) {
					$lastIP = $row->cuc_ip;
					$s .= "\n<h2>$ip</h2>\n<div class=\"special\">";
				} elseif ( $lastIP != $row->cuc_ip ) {
					$s .= "</ul></div>\n<h2>$ip</h2>\n<div class=\"special\">";
					$lastIP = $row->cuc_ip;
					unset( $this->lastdate ); // start over
				}
				$s .= $this->CUChangesLine( $row, $reason );
			}
			$s .= '</ul></div>';

			$wgOut->addHTML( $s );
			return;
		}
		// Sorting might take some time...make sure it is there
		wfSuppressWarnings();
		set_time_limit( 60 );
		wfRestoreWarnings();

		# OK, do the real query...

		$ret = $dbr->select(
			'cu_changes',
			'*',
			array( $user_cond, $time_conds ),
			__METHOD__,
			array(
				'ORDER BY' => 'cuc_timestamp DESC',
				'LIMIT' => self::LIMIT,
				'USE INDEX' => 'cuc_user_ip_time'
			)
		);
		if ( !$dbr->numRows( $ret ) ) {
			$s = $this->noMatchesMessage( $user ) . "\n";
		} else {
			# Try to optimize this query
			$lb = new LinkBatch;
			foreach ( $ret as $row ) {
				$lb->add( $row->cuc_namespace, $row->cuc_title );
			}
			$lb->execute();
			$ret->seek( 0 );
			# List out the edits
			$s = '<div id="checkuserresults">';
			foreach ( $ret as $row ) {
				$s .= $this->CUChangesLine( $row, $reason );
			}
			$s .= '</ul></div>';
		}

		$wgOut->addHTML( $s );
	}

	/**
	 * @param string $ip
	 * @param bool $xfor
	 * @param string $reason
	 * @param int $period
	 * @param string $tag
	 * @param string $talkTag
	 * Lists all users in recent changes who used an IP, newest to oldest down
	 * Outputs usernames, latest and earliest found edit date, and count
	 * List unique IPs used for each user in time order, list corresponding user agent
	 */
	protected function doIPUsersRequest( $ip, $xfor = false, $reason = '', $period = 0, $tag = '', $talkTag = '' ) {
		global $wgUser, $wgOut, $wgLang;
		$dbr = wfGetDB( DB_SLAVE );
		# Invalid IPs are passed in as a blank string
		$ip_conds = self::getIpConds( $dbr, $ip, $xfor );
		if ( !$ip || $ip_conds === false ) {
			$wgOut->addWikiMsg( 'badipaddress' );
			return;
		}

		$logType = 'ipusers';
		if ( $xfor ) {
			$logType .= '-xff';
		}
		# Log the check...
		if ( !self::addLogEntry( $logType, 'ip', $ip, $reason ) ) {
			$wgOut->addHTML( '<p>' . wfMsgHtml( 'checkuser-log-fail' ) . '</p>' );
		}

		$ip_conds = $dbr->makeList( $ip_conds, LIST_AND );
		$time_conds = $this->getTimeConds( $period );
		$index = $xfor ? 'cuc_xff_hex_time' : 'cuc_ip_hex_time';
		# Ordered in descent by timestamp. Can cause large filesorts on range scans.
		# Check how many rows will need sorting ahead of time to see if this is too big.
		if ( strpos( $ip, '/' ) !== false ) {
			# Quick index check only OK if no time constraint
			if ( $period ) {
				$rangecount = $dbr->selectField( 'cu_changes', 'COUNT(*)',
					array( $ip_conds, $time_conds ),
					__METHOD__,
					array( 'USE INDEX' => $index ) );
			} else {
				$rangecount = $dbr->estimateRowCount( 'cu_changes', '*',
					array( $ip_conds ),
					__METHOD__,
					array( 'USE INDEX' => $index ) );
			}
			// Sorting might take some time...make sure it is there
			wfSuppressWarnings();
			set_time_limit( 120 );
			wfRestoreWarnings();
		}
		// Are there too many edits?
		if ( isset( $rangecount ) && $rangecount > 10000 ) {
			$ret = $dbr->select(
				'cu_changes',
				array(
					'cuc_ip_hex', 'COUNT(*) AS count',
					'MIN(cuc_timestamp) AS first', 'MAX(cuc_timestamp) AS last'
				),
				array( $ip_conds, $time_conds ),
				__METHOD__,
				array(
					'GROUP BY' => 'cuc_ip_hex',
					'ORDER BY' => 'cuc_ip_hex',
					'LIMIT' => self::LIMIT + 1,
					'USE INDEX' => $index,
				)
			);
			# List out each IP that has edits
			$s = '<h5>' . wfMsg( 'checkuser-too-many' ) . '</h5>';
			$s .= '<ol>';
			$counter = 0;
			foreach ( $ret as $row ) {
				if ( $counter >= self::LIMIT ) {
					$wgOut->addHTML( wfMsgExt( 'checkuser-limited', array( 'parse' ) ) );
					break;
				}
				# Convert the IP hexes into normal form
				if ( strpos( $row->cuc_ip_hex, 'v6-' ) !== false ) {
					$ip = substr( $row->cuc_ip_hex, 3 );
					$ip = IP::HextoOctet( $ip );
				} else {
					$ip = long2ip( wfBaseConvert( $row->cuc_ip_hex, 16, 10, 8 ) );
				}
				$s .= '<li><a href="' .
					$this->getTitle()->escapeLocalURL( 'user=' . urlencode( $ip ) . '&reason=' . urlencode( $reason ) . '&checktype=subipusers' ) .
					'">' . $ip . '</a>';
				if ( $row->first == $row->last ) {
					$s .= ' (' . $wgLang->timeanddate( wfTimestamp( TS_MW, $row->first ), true ) . ') ';
				} else {
					$s .= ' (' . $wgLang->timeanddate( wfTimestamp( TS_MW, $row->first ), true ) .
					' -- ' . $wgLang->timeanddate( wfTimestamp( TS_MW, $row->last ), true ) . ') ';
				}
				$s .= ' [<strong>' . $row->count . "</strong>]</li>\n";
				++$counter;
			}
			$s .= '</ol>';

			$wgOut->addHTML( $s );
			return;
		} elseif ( isset( $rangecount ) && !$rangecount ) {
			$s = $this->noMatchesMessage( $ip, !$xfor ) . "\n";
			$wgOut->addHTML( $s );
			return;
		}

		global $wgMemc;
		# OK, do the real query...

		$ret = $dbr->select(
			'cu_changes',
			array(
				'cuc_user_text', 'cuc_timestamp', 'cuc_user', 'cuc_ip', 'cuc_agent', 'cuc_xff'
			),
			array( $ip_conds, $time_conds ),
			__METHOD__,
			array(
				'ORDER BY' => 'cuc_timestamp DESC',
				'LIMIT' => 10000,
				'USE INDEX' => $index,
			)
		);

		$users_first = $users_last = $users_edits = $users_ids = array();
		if ( !$dbr->numRows( $ret ) ) {
			$s = $this->noMatchesMessage( $ip, !$xfor ) . "\n";
		} else {
			global $wgAuth;
			foreach ( $ret as $row ) {
				if ( !array_key_exists( $row->cuc_user_text, $users_edits ) ) {
					$users_last[$row->cuc_user_text] = $row->cuc_timestamp;
					$users_edits[$row->cuc_user_text] = 0;
					$users_ids[$row->cuc_user_text] = $row->cuc_user;
					$users_infosets[$row->cuc_user_text] = array();
					$users_agentsets[$row->cuc_user_text] = array();
				}
				$users_edits[$row->cuc_user_text] += 1;
				$users_first[$row->cuc_user_text] = $row->cuc_timestamp;
				# Treat blank or NULL xffs as empty strings
				$xff = empty( $row->cuc_xff ) ? null : $row->cuc_xff;
				$xff_ip_combo = array( $row->cuc_ip, $xff );
				# Add this IP/XFF combo for this username if it's not already there
				if ( !in_array( $xff_ip_combo, $users_infosets[$row->cuc_user_text] ) ) {
					$users_infosets[$row->cuc_user_text][] = $xff_ip_combo;
				}
				# Add this agent string if it's not already there; 10 max.
				if ( count( $users_agentsets[$row->cuc_user_text] ) < 10 ) {
					if ( !in_array( $row->cuc_agent, $users_agentsets[$row->cuc_user_text] ) ) {
						$users_agentsets[$row->cuc_user_text][] = $row->cuc_agent;
					}
				}
			}

			$action = $this->getTitle()->escapeLocalURL( 'action=block' );
			$s = "<form name='checkuserblock' id='checkuserblock' action=\"$action\" method='post'>";
			$s .= '<div id="checkuserresults"><ul>';
			foreach ( $users_edits as $name => $count ) {
				$s .= '<li>';
				$s .= Xml::check( 'users[]', false, array( 'value' => $name ) ) . '&#160;';
				# Load user object
				$user = User::newFromName( $name, false );
				# Add user tool links
				$s .= $this->sk->userLink( - 1 , $name ) . $this->sk->userToolLinks( - 1 , $name );
				# Add CheckUser link
				$s .= ' (<a href="' . $this->getTitle()->escapeLocalURL( 'user=' . urlencode( $name ) .
					'&reason=' . urlencode( $reason ) ) . '">' . wfMsgHtml( 'checkuser-check' ) . '</a>)';
				# Show edit time range
				if ( $users_first[$name] == $users_last[$name] ) {
					$s .= ' (' . $wgLang->timeanddate( wfTimestamp( TS_MW, $users_first[$name] ), true ) . ') ';
				} else {
					$s .= ' (' . $wgLang->timeanddate( wfTimestamp( TS_MW, $users_first[$name] ), true ) .
					' -- ' . $wgLang->timeanddate( wfTimestamp( TS_MW, $users_last[$name] ), true ) . ') ';
				}
				# Total edit count
				$s .= ' [<strong>' . $count . '</strong>]<br />';
				# Check if this user or IP is blocked. If so, give a link to the block log...
				$ip = IP::isIPAddress( $name ) ? $name : '';
				$flags = $this->userBlockFlags( $ip, $users_ids[$name], $user );
				# Show if account is local only
				$authUser = $wgAuth->getUserInstance( $user );
				if ( $user->getId() && $authUser->getId() === 0 ) {
					$flags[] = '<strong>(' . wfMsgHtml( 'checkuser-localonly' ) . ')</strong>';
				}
				# Check for extra user rights...
				if ( $users_ids[$name] ) {
					if ( $user->isLocked() ) {
						$flags[] = '<b>(' . wfMsgHtml( 'checkuser-locked' ) . ')</b>';
					}
					$list = array();
					foreach ( $user->getGroups() as $group ) {
						$list[] = self::buildGroupLink( $group, $user->getName() );
					}
					$groups = $wgLang->commaList( $list );
					if ( $groups ) {
						$flags[] = '<i>(' . $groups . ')</i>';
					}
				}
				# Check how many accounts the user made recently?
				if ( $ip ) {
					$key = wfMemcKey( 'acctcreate', 'ip', $ip );
					$count = intval( $wgMemc->get( $key ) );
					if ( $count ) {
						$flags[] = '<strong>[' . wfMsgExt( 'checkuser-accounts', 'parsemag', $wgLang->formatNum( $count ) ) . ']</strong>';
					}
				}
				$s .= implode( ' ', $flags );
				$s .= '<ol>';
				# List out each IP/XFF combo for this username
				for ( $i = ( count( $users_infosets[$name] ) - 1 ); $i >= 0; $i-- ) {
					$set = $users_infosets[$name][$i];
					# IP link
					$s .= '<li>';
					$s .= '<a href="' . $this->getTitle()->escapeLocalURL( 'user=' . urlencode( $set[0] ) ) . '">' . htmlspecialchars( $set[0] ) . '</a>';
					# XFF string, link to /xff search
					if ( $set[1] ) {
						# Flag our trusted proxies
						list( $client, $trusted ) = IP::getClientIPfromXFF( $set[1], $set[0] );
						$c = $trusted ? '#F0FFF0' : '#FFFFCC';
						$s .= '&#160;&#160;&#160;<span style="background-color: ' . $c . '"><strong>XFF</strong>: ';
						$s .= $this->sk->makeKnownLinkObj( $this->getTitle(),
							htmlspecialchars( $set[1] ),
							'user=' . urlencode( $client ) . '/xff' ) . '</span>';
					}
					$s .= "</li>\n";
				}
				$s .= '</ol><br /><ol>';
				# List out each agent for this username
				for ( $i = ( count( $users_agentsets[$name] ) - 1 ); $i >= 0; $i-- ) {
					$agent = $users_agentsets[$name][$i];
					$s .= '<li><i>' . htmlspecialchars( $agent ) . "</i></li>\n";
				}
				$s .= '</ol>';
				$s .= '</li>';
			}
			$s .= "</ul></div>\n";
			if ( $wgUser->isAllowed( 'block' ) && !$wgUser->isBlocked() ) {
				$s .= "<fieldset>\n";
				$s .= '<legend>' . wfMsgHtml( 'checkuser-massblock' ) . "</legend>\n";
				$s .= '<p>' . wfMsgExt( 'checkuser-massblock-text', array( 'parseinline' ) ) . "</p>\n";
				$s .= '<table><tr>' .
					'<td>' . Xml::check( 'usetag', false, array( 'id' => 'usetag' ) ) . '</td>' .
					'<td>' . Xml::label( wfMsgHtml( 'checkuser-blocktag' ), 'usetag' ) . '</td>' .
					'<td>' . Xml::input( 'tag', 46, $tag, array( 'id' => 'blocktag' ) ) . '</td>' .
					'</tr><tr>' .
					'<td>' . Xml::check( 'usettag', false, array( 'id' => 'usettag' ) ) . '</td>' .
					'<td>' . Xml::label( wfMsgHtml( 'checkuser-blocktag-talk' ), 'usettag' ) . '</td>' .
					'<td>' . Xml::input( 'talktag', 46, $talkTag, array( 'id' => 'talktag' ) ) . '</td>' .
					'</tr></table>';
				$s .= '<p>' . wfMsgHtml( 'checkuser-reason' ) . '&#160;';
				$s .= Xml::input( 'blockreason', 46, '', array( 'maxlength' => '150', 'id' => 'blockreason' ) );
				$s .= '&#160;' . Xml::submitButton( wfMsgHtml( 'checkuser-massblock-commit' ),
					array( 'id' => 'checkuserblocksubmit', 'name' => 'checkuserblock' ) ) . "</p>\n";
				$s .= "</fieldset>\n";
			}
			$s .= Html::hidden( 'wpEditToken', $wgUser->getEditToken() );
			$s .= '</form>';
		}

		$wgOut->addHTML( $s );
	}

	protected function userBlockFlags( $ip, $userId, $user ) {
		static $logs, $blocklist;
		$logs = SpecialPage::getTitleFor( 'Log' );
		$blocklist = SpecialPage::getTitleFor( 'BlockList' );
		$block = Block::newFromTarget( $user, $ip, false );
		$flags = array();
		if ( $block instanceof Block ) {
			// Range blocked?
			if ( $block->getType() == Block::TYPE_RANGE ) {
				$userpage = Title::makeTitle( NS_USER, $block->getTarget() );
				$blocklog = $this->sk->makeKnownLinkObj(
					$logs,
					wfMsgHtml( 'checkuser-blocked' ),
					'type=block&page=' . urlencode( $userpage->getPrefixedText() )
				);
				$flags[] = '<strong>(' . $blocklog . ' - ' . $block->getTarget() . ')</strong>';
			// Auto blocked?
			} elseif ( $block->getType() == Block::TYPE_AUTO ) {
				$blocklog = $this->sk->makeKnownLinkObj(
					$blocklist,
					wfMsgHtml( 'checkuser-blocked' ),
					'ip=' . urlencode( "#{$block->getId()}" )
				);
				$flags[] = '<strong>(' . $blocklog . ')</strong>';
			} else {
				$userpage = $user->getUserPage();
				$blocklog = $this->sk->makeKnownLinkObj(
					$logs,
					wfMsgHtml( 'checkuser-blocked' ),
					'type=block&page=' . urlencode( $userpage->getPrefixedText() )
				);
				$flags[] = '<strong>(' . $blocklog . ')</strong>';
			}
		// IP that is blocked on all wikis?
		} elseif ( $ip == $user->getName() && $user->isBlockedGlobally( $ip ) ) {
			$flags[] = '<strong>(' . wfMsgHtml( 'checkuser-gblocked' ) . ')</strong>';
		} elseif ( self::userWasBlocked( $user->getName() ) ) {
			$userpage = $user->getUserPage();
			$blocklog = $this->sk->makeKnownLinkObj( $logs, wfMsgHtml( 'checkuser-wasblocked' ),
				'type=block&page=' . urlencode( $userpage->getPrefixedText() ) );
			$flags[] = '<strong>(' . $blocklog . ')</strong>';
		}
		return $flags;
	}

	/**
	 * @param Row $row
	 * @param string $reason
	 * @return a streamlined recent changes line with IP data
	 */
	protected function CUChangesLine( $row, $reason ) {
		global $wgLang;
		static $cuTitle, $flagCache;
		$cuTitle = SpecialPage::getTitleFor( 'CheckUser' );
		# Add date headers as needed
		$date = $wgLang->date( wfTimestamp( TS_MW, $row->cuc_timestamp ), true, true );
		if ( !isset( $this->lastdate ) ) {
			$this->lastdate = $date;
			$line = "\n<h4>$date</h4>\n<ul class=\"special\">";
		} elseif ( $date != $this->lastdate ) {
			$line = "</ul>\n<h4>$date</h4>\n<ul class=\"special\">";
			$this->lastdate = $date;
		} else {
			$line = '';
		}
		$line .= '<li>';
		# Create diff/hist/page links
		$line .= $this->getLinksFromRow( $row );
		# Show date
		$line .= ' . . ' . $wgLang->time( wfTimestamp( TS_MW, $row->cuc_timestamp ), true, true ) . ' . . ';
		# Userlinks
		$line .= $this->sk->userLink( $row->cuc_user, $row->cuc_user_text );
		$line .= $this->sk->userToolLinks( $row->cuc_user, $row->cuc_user_text );
		# Get block info
		if ( isset( $flagCache[$row->cuc_user_text] ) ) {
			$flags = $flagCache[$row->cuc_user_text];
		} else {
			$user = User::newFromName( $row->cuc_user_text, false );
			$ip = IP::isIPAddress( $row->cuc_user_text ) ? $row->cuc_user_text : '';
			$flags = $this->userBlockFlags( $ip, $row->cuc_user, $user );
			$flagCache[$row->cuc_user_text] = $flags;
		}
		# Add any block information
		if ( count( $flags ) ) {
			$line .= ' ' . implode( ' ', $flags );
		}
		# Action text, hackish ...
		if ( $row->cuc_actiontext ) {
			$line .= ' ' . $this->sk->formatComment( $row->cuc_actiontext ) . ' ';
		}
		# Comment
		$line .= $this->sk->commentBlock( $row->cuc_comment );
		$line .= '<br />&#160; &#160; &#160; &#160; <small>';
		# IP
		$line .= ' <strong>IP</strong>: ' . $this->sk->makeKnownLinkObj( $cuTitle,
			htmlspecialchars( $row->cuc_ip ), 'user=' . urlencode( $row->cuc_ip ) . '&reason=' . urlencode( $reason ) );
		# XFF
		if ( $row->cuc_xff != null ) {
			# Flag our trusted proxies
			list( $client, $trusted ) = IP::getClientIPfromXFF( $row->cuc_xff, $row->cuc_ip );
			$c = $trusted ? '#F0FFF0' : '#FFFFCC';
			$line .= '&#160;&#160;&#160;<span class="mw-checkuser-xff" style="background-color: ' . $c . '">' .
				'<strong>XFF</strong>: ';
			$line .= $this->sk->makeKnownLinkObj( $cuTitle,
				htmlspecialchars( $row->cuc_xff ),
				'user=' . urlencode( $client ) . '/xff&reason=' . urlencode( $reason ) ) . '</span>';
		}
		# User agent
		$line .= '&#160;&#160;&#160;<span class="mw-checkuser-agent" style="color:#888;">' .
			htmlspecialchars( $row->cuc_agent ) . '</span>';

		$line .= "</small></li>\n";

		return $line;
	}

	/**
	 * @param $row
	 * @create diff/hist/page link
	 */
	protected function getLinksFromRow( $row ) {
		// Log items (old format) and events to logs
		if ( $row->cuc_type == RC_LOG && $row->cuc_namespace == NS_SPECIAL ) {
			list( $specialName, $logtype ) = SpecialPageFactory::resolveAlias( $row->cuc_title );
			$logname = LogPage::logName( $logtype );
			$title = Title::makeTitle( $row->cuc_namespace, $row->cuc_title );
			$links = '(' . $this->sk->makeKnownLinkObj( $title, $logname ) . ')';
		// Log items (newer format)
		} elseif ( $row->cuc_type == RC_LOG ) {
			$title = Title::makeTitle( $row->cuc_namespace, $row->cuc_title );
			$links = '(' . $this->sk->makeKnownLinkObj( SpecialPage::getTitleFor( 'Log' ), $this->message['log'],
				wfArrayToCGI( array( 'page' => $title->getPrefixedText() ) ) ) . ')';
		} else {
			$title = Title::makeTitle( $row->cuc_namespace, $row->cuc_title );
			# New pages
			if ( $row->cuc_type == RC_NEW ) {
				$links = '(' . $this->message['diff'] . ') ';
			} else {
				# Diff link
				$links = ' (' . $this->sk->makeKnownLinkObj( $title, $this->message['diff'],
					wfArrayToCGI( array(
						'curid' => $row->cuc_page_id,
						'diff' => $row->cuc_this_oldid,
						'oldid' => $row->cuc_last_oldid ) ) ) . ') ';
			}
			# History link
			$links .= ' (' . $this->sk->makeKnownLinkObj( $title, $this->message['hist'],
				wfArrayToCGI( array(
					'curid' => $row->cuc_page_id,
					'action' => 'history' ) ) ) . ') . . ';
			# Some basic flags
			if ( $row->cuc_type == RC_NEW ) {
				$links .= '<span class="newpage">' . $this->message['newpageletter'] . '</span>';
			}
			if ( $row->cuc_minor ) {
				$links .= '<span class="minor">' . $this->message['minoreditletter'] . '</span>';
			}
			# Page link
			$links .= ' ' . $this->sk->makeLinkObj( $title );
		}
		return $links;
	}

	protected static function userWasBlocked( $name ) {
		$userpage = Title::makeTitle( NS_USER, $name );
		return wfGetDB( DB_SLAVE )->selectField( 'logging', '1',
			array( 'log_type' => array( 'block', 'suppress' ),
				'log_action' => 'block',
				'log_namespace' => $userpage->getNamespace(),
				'log_title' => $userpage->getDBkey() ),
			__METHOD__,
			array( 'USE INDEX' => 'page_time' ) );
	}

	/**
	 * Format a link to a group description page
	 *
	 * @param string $group
	 * @param string $username
	 * @return string
	 */
	protected static function buildGroupLink( $group, $username = '#' ) {
		static $cache = array();
		if ( !isset( $cache[$group] ) ) {
			$cache[$group] = User::makeGroupLinkHtml( $group, User::getGroupMember( $group, $username ) );
		}
		return $cache[$group];
	}

	/**
	 * @param DatabaseBase $db
	 * @param string $ip
	 * @param string|bool $xfor
	 * @return mixed array/false conditions
	 */
	public static function getIpConds( $db, $ip, $xfor = false ) {
		$type = ( $xfor ) ? 'xff' : 'ip';
		// IPv4 CIDR, 16-32 bits
		$matches = array();
		if ( preg_match( '#^(\d+\.\d+\.\d+\.\d+)/(\d+)$#', $ip, $matches ) ) {
			if ( $matches[2] < 16 || $matches[2] > 32 ) {
				return false; // invalid
			}
			list( $start, $end ) = IP::parseRange( $ip );
			return array( 'cuc_' . $type . '_hex BETWEEN ' . $db->addQuotes( $start ) . ' AND ' . $db->addQuotes( $end ) );
		} elseif ( preg_match( '#^\w{1,4}:\w{1,4}:\w{1,4}:\w{1,4}:\w{1,4}:\w{1,4}:\w{1,4}:\w{1,4}/(\d+)$#', $ip, $matches ) ) {
			// IPv6 CIDR, 64-128 bits
			if ( $matches[1] < 64 || $matches[1] > 128 ) {
				return false; // invalid
			}
			list( $start, $end ) = IP::parseRange( $ip );
			return array( 'cuc_' . $type . '_hex BETWEEN ' . $db->addQuotes( $start ) . ' AND ' . $db->addQuotes( $end ) );
		} elseif ( preg_match( '#^(\d+)\.(\d+)\.(\d+)\.(\d+)$#', $ip ) ) {
			// 32 bit IPv4
			$ip_hex = IP::toHex( $ip );
			return array( 'cuc_' . $type . '_hex' => $ip_hex );
		} elseif ( preg_match( '#^\w{1,4}:\w{1,4}:\w{1,4}:\w{1,4}:\w{1,4}:\w{1,4}:\w{1,4}:\w{1,4}$#', $ip ) ) {
			// 128 bit IPv6
			$ip_hex = IP::toHex( $ip );
			return array( 'cuc_' . $type . '_hex' => $ip_hex );
		}
		// throw away this query, incomplete IP, these don't get through the entry point anyway
		return false; // invalid
	}

	protected function getTimeConds( $period ) {
		if ( !$period ) {
			return '1 = 1';
		}
		$dbr = wfGetDB( DB_SLAVE );
		$cutoff_unixtime = time() - ( $period * 24 * 3600 );
		$cutoff_unixtime = $cutoff_unixtime - ( $cutoff_unixtime % 86400 );
		$cutoff = $dbr->addQuotes( $dbr->timestamp( $cutoff_unixtime ) );
		return "cuc_timestamp > $cutoff";
	}

	public static function addLogEntry( $logType, $targetType, $target, $reason, $targetID = 0 ) {
		global $wgUser;

		if ( $targetType == 'ip' ) {
			list( $rangeStart, $rangeEnd ) = IP::parseRange( $target );
			$targetHex = $rangeStart;
			if ( $rangeStart == $rangeEnd ) {
				$rangeStart = $rangeEnd = '';
			}
		} else {
			$targetHex = $rangeStart = $rangeEnd = '';
		}

		$dbw = wfGetDB( DB_MASTER );
		$cul_id = $dbw->nextSequenceValue( 'cu_log_cul_id_seq' );
		$dbw->insert( 'cu_log',
			array(
				'cul_id' => $cul_id,
				'cul_timestamp' => $dbw->timestamp(),
				'cul_user' => $wgUser->getID(),
				'cul_user_text' => $wgUser->getName(),
				'cul_reason' => $reason,
				'cul_type' => $logType,
				'cul_target_id' => $targetID,
				'cul_target_text' => $target,
				'cul_target_hex' => $targetHex,
				'cul_range_start' => $rangeStart,
				'cul_range_end' => $rangeEnd,
			), __METHOD__ );
		return true;
	}
}

