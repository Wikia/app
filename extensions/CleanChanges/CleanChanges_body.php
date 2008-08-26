<?php

/**
 * Generate a list of changes using an Enhanced system (use javascript).
 */
class NCL extends EnhancedChangesList {

	/**
	 * Determines which version of changes list to provide, or none.
	 */
	public static function hook( &$user, &$skin, &$list ) {
		$list = null;

		/* allow override */
		global $wgRequest;
		if ( $wgRequest->getBool('cleanrc') ) {
			$list = new NCL( $skin );
		}
		if ( $wgRequest->getBool('newrc') ) {
			$list = new EnhancedChangesList( $skin );
		}
		if ( $wgRequest->getBool('oldrc') ) {
			$list = new OldChangesList( $skin );
		}

		if ( !$list && $user->getOption( 'usenewrc' ) ) {
			$list = new NCL( $skin );
		}

		if ( $list instanceof NCL ) {
			global $wgOut, $wgScriptPath, $wgJsMimeType, $wgStyleVersion;
			$wgOut->addScript(
				Xml::openElement( 'script', array( 'type' => $wgJsMimeType, 'src' =>
				"$wgScriptPath/extensions/CleanChanges/cleanchanges.js?$wgStyleVersion" )
				) . '</script>'
			);
		}

		/* If some list was specified, stop processing */
		return $list === null;

	}


	/**
	 * String that comes between page details and the user details. By default
	 * only larger space.
	 */
	protected $userSeparator = "\xc2\xa0 \xc2\xa0";
	protected $userinfo = array();

	/**
	 * Text direction, true for ltr and false for rtl
	 */
	protected $direction = true;

	public function __construct( $skin ) {
		wfLoadExtensionMessages( 'CleanChanges' );
		global $wgLang;
		parent::__construct( $skin );
		$this->direction = !$wgLang->isRTL();
		$this->dir = $wgLang->getDirMark();
	}

	function beginRecentChangesList() {
		parent::beginRecentChangesList();
		$dir = $this->direction ? 'ltr' : 'rtl';
		return
			Xml::openElement(
				'div',
				array( 'style' => "direction: $dir" )
			);
	}

	function endRecentChangesList() {
	/*
	 * Have to output the accumulated javascript stuff before any output is send.
	 */
		global $wgOut;
		$wgOut->addScript( Skin::makeVariablesScript( $this->userinfo ) );
		return parent::endRecentChangesList() . '</div>';
	}

	function isLog( $rc ) {
		if ( $rc->getAttribute( 'rc_namespace ' ) == NS_SPECIAL ) {
			return 1;
		} elseif ( $rc->getAttribute( 'rc_type' ) == RC_LOG ) {
			return 2;
		} else {
			return 0;
		}
	}

	function getLogTitle( $type, $rc ) {
		if ( $type === 1 ) {
			$title = $rc->getAttribute( 'rc_title' );
			list( $specialName, $logtype ) = SpecialPage::resolveAliasWithSubpage( $title );

			if ( $specialName === 'Log' ) {
				$titleObj = $rc->getTitle();
				$logname = LogPage::logName( $logtype );
				return '(' . $this->skin->makeKnownLinkObj( $titleObj, $logname ) . ')';
			} else {
				throw new MWException( "Unknown special page name $specialName ($title). Log expected." );
			}
		} elseif ( $type === 2 ) {
			$logtype = $rc->getAttribute( 'rc_log_type' );
			$logname = LogPage::logName( $logtype );
			$titleObj = SpecialPage::getTitleFor( 'Log', $logtype );
			return '(' . $this->skin->makeKnownLinkObj( $titleObj, $logname ) . ')';
		} else {
			throw new MWException( 'Unknown type' );
		}
	}

	protected function getLogAction( $rc ) {
		if ( $this->isDeleted($rc, LogPage::DELETED_ACTION) ) {
			return $this->XMLwrapper( 'history-deleted', wfMsg('rev-deleted-event') );
		} else {
			return LogPage::actionText(
				$rc->getAttribute('rc_log_type'),
				$rc->getAttribute('rc_log_action'),
				$rc->getTitle(),
				$this->skin,
				LogPage::extractParams( $rc->getAttribute('rc_params') ),
				true,
				true
			);
		}
	}

	/**
	 * Format a line for enhanced recentchange (aka with javascript and block of lines).
	 */
	function recentChangesLine( &$baseRC, $watched = false ) {
		global $wgLang;

		# Create a specialised object
		$rc = RCCacheEntry::newFromParent( $baseRC );

		// Extract most used variables
		$timestamp = $rc->getAttribute( 'rc_timestamp' );
		$titleObj = $rc->getTitle();
		$rc_id = $rc->getAttribute( 'rc_id' );

		$date = $wgLang->date( $timestamp, /* adj */ true, /* format */ true );
		$time = $wgLang->time( $timestamp, /* adj */ true, /* format */ true );

		# Should patrol-related stuff be shown?
		$rc->unpatrolled = self::usePatrol() ? !$rc->getAttribute( 'rc_patrolled' ) : false;

		$logEntry = $this->isLog( $rc );
		if( $logEntry ) {
			$clink = $this->getLogTitle( $logEntry, $rc );
		} elseif( $rc->unpatrolled && $rc->getAttribute( 'rc_type' ) == RC_NEW ) {
			# Unpatrolled new page, give rc_id in query
			$clink = $this->skin->makeKnownLinkObj( $titleObj, '', "rcid={$rc_id}" );
		} else {
			$clink = $this->skin->makeKnownLinkObj( $titleObj );
		}

		$rc->watched   = $watched;
		$rc->link      = $this->maybeWatchedLink( $clink, $watched );
		$rc->timestamp = $time;
		$rc->numberofWatchingusers = $baseRC->numberofWatchingusers;

		$rc->_reqCurId = array( 'curid' => $rc->getAttribute( 'rc_cur_id' ) );
		$rc->_reqOldId = array( 'oldid' => $rc->getAttribute( 'rc_this_oldid' ) );
		$this->makeLinks( $rc );

		$stuff = $this->userToolLinks( $rc->getAttribute( 'rc_user' ),
			$rc->getAttribute( 'rc_user_text' ) );
		$this->userinfo += $stuff[1];

		$rc->_user = $this->skin->userLink( $rc->getAttribute( 'rc_user' ),
			$rc->getAttribute( 'rc_user_text' ) );
		$rc->_userInfo = $stuff[0];

		$rc->_comment = $this->skin->commentBlock(
			$rc->getAttribute( 'rc_comment' ), $titleObj );

		if ( $logEntry ) {
			$rc->_comment = $this->getLogAction( $rc ) . ' ' . $rc->_comment;
		}

		$rc->_watching = $this->numberofWatchingusers( $baseRC->numberofWatchingusers );


		# If it's a new day, add the headline and flush the cache
		$ret = '';
		if ( $date !== $this->lastdate ) {
			# Process current cache
			$ret = $this->recentChangesBlock();
			$this->rc_cache = array();
			$ret .= Xml::element('h4', null, $date) . "\n";
			$this->lastdate = $date;
		}

		# Put accumulated information into the cache, for later display
		# Page moves go on their own line
		if ( $logEntry ) {
			$secureName = $this->getLogTitle( $logEntry, $rc );
		} else {
			$secureName = $titleObj->getPrefixedDBkey();
		}
		$this->rc_cache[$secureName][] = $rc;

		return $ret;
	}

	protected function makeLinks( $rc ) {
		/* These will be overriden with actual links below, if applicable */
		$rc->_curLink  = $this->message['cur'];
		$rc->_diffLink = $this->message['diff'];
		$rc->_lastLink = $this->message['last'];
		$rc->_histLink = $this->message['hist'];

		if( !$this->isLog( $rc ) ) {
			# Make cur, diff and last links
			$querycur = wfArrayToCGI( array( 'diff' => 0 ) + $rc->_reqCurId + $rc->_reqOldId );
			$querydiff = wfArrayToCGI( array(
				'diff'  => $rc->getAttribute( 'rc_this_oldid' ),
				'oldid' => $rc->getAttribute( 'rc_last_oldid' ),
				'rcid'  => $rc->unpatrolled ? $rc->getAttribute( 'rc_id' ) : '',
			) + $rc->_reqCurId );

			$rc->_curLink = $this->skin->makeKnownLinkObj( $rc->getTitle(),
					$this->message['cur'], $querycur );

			if ( $rc->getAttribute( 'rc_type' ) != RC_NEW ) {
				$rc->_diffLink = $this->skin->makeKnownLinkObj( $rc->getTitle(),
					$this->message['diff'], $querydiff );
			}

			if ( $rc->getAttribute( 'rc_last_oldid' ) != 0 ) {
				// This is not the first revision
				$rc->_lastLink = $this->skin->makeKnownLinkObj( $rc->getTitle(),
					$this->message['last'], $querydiff );
			}

			$rc->_histLink = $this->skin->makeKnownLinkObj( $rc->getTitle(),
				$this->message['hist'],
				wfArrayToCGI( $rc->_reqCurId, array( 'action' => 'history' ) ) );

		}
	}

	/**
	 * Enhanced RC group
	 */
	function recentChangesBlockGroup( $block ) {
		global $wgLang;

		# Collate list of users
		$isnew = $unpatrolled = false;
		$userlinks = array();
		$overrides = array( 'minor' => false, 'bot' => false );
		foreach( $block as $rcObj ) {
			$oldid = $rcObj->mAttribs['rc_last_oldid'];
			if( $rcObj->mAttribs['rc_new'] ) {
				$isnew = $overrides['new'] = true;
			}
			$u = $rcObj->_user;
			if( !isset( $userlinks[$u] ) ) {
				$userlinks[$u] = 0;
			}
			if( $rcObj->unpatrolled ) {
				$unpatrolled =  $overrides['patrol'] = true;
			}

			$userlinks[$u]++;
		}

		# Main line, flags and timestamp

		$info = Xml::tags( 'tt', null,
			$this->getFlags( $block[0], $overrides ) . ' ' . $block[0]->timestamp );
		$rci = 'RCI' . $this->rcCacheIndex;
		$rcl = 'RCL' . $this->rcCacheIndex;
		$rcm = 'RCM' . $this->rcCacheIndex;
		$toggleLink = "javascript:toggleVisibilityE('$rci', '$rcm', '$rcl', 'block')";
		$tl =
		Xml::tags( 'span', array( 'id' => $rcm ),
			Xml::tags('a', array( 'href' => $toggleLink ), $this->arrow($this->direction ? 'r' : 'l') ) ) .
		Xml::tags( 'span', array( 'id' => $rcl, 'style' => 'display: none;' ),
			Xml::tags('a', array( 'href' => $toggleLink ), $this->downArrow() ) );

		$items[] = $tl . $info;

		# Article link
		$items[] = $block[0]->link;

		$curIdEq = 'curid=' . $block[0]->mAttribs['rc_cur_id'];
		$currentRevision = $block[0]->mAttribs['rc_this_oldid'];

		$log = $this->isLog( $block[0] );
		if( !$log ) {
			# Changes
			$n = count($block);
			static $nchanges = array();
			if ( !isset( $nchanges[$n] ) ) {
				$nchanges[$n] = wfMsgExt( 'nchanges', array( 'parsemag', 'escape'),
					$wgLang->formatNum( $n ) );
			}

			if ( !$isnew ) {
				$changes = $this->skin->makeKnownLinkObj( $block[0]->getTitle(),
					$nchanges[$n],
					$curIdEq."&diff=$currentRevision&oldid=$oldid" );
			} else {
				$changes = $nchanges[$n];
			}

			$size = $this->getCharacterDifference( $block[0], $block[count($block)-1] );
			$items[] = $this->changeInfo( $changes, $block[0]->_histLink, $size );

		}

		$items[] = $this->userSeparator;

		# Sort the list and convert to text
		$items[] = $this->makeUserlinks( $userlinks );
		$items[] = $block[0]->_watching;

		$lines = Xml::tags( 'div', null, implode( " {$this->dir}", $items ) ) . "\n" ;

		# Sub-entries
		$lines .= Xml::tags( 'div',
			array( 'id' => $rci, 'style' => 'display: none;' ),
			$this->subEntries( $block )
		) . "\n";

		$this->rcCacheIndex++;
		return $lines . "\n";
	}

	function subEntries( $block ) {
		$lines = '';
		foreach( $block as $rcObj ) {
			$items = array();
			$log = $this->isLog( $rcObj );

			$time = $rcObj->timestamp;
			if( !$log ) {
				$time = $this->skin->makeKnownLinkObj( $rcObj->getTitle(),
					$rcObj->timestamp, wfArrayToCGI( $rcObj->_reqOldId, $rcObj->_reqCurId ) );
			}

			$info = $this->getFlags( $rcObj ) . ' ' . $time;
			$items[] = $this->spacerArrow() . Xml::tags( 'tt', null, $info );

			if ( !$log ) {
				$cur  = $rcObj->_curLink;
				$last = $rcObj->_lastLink;

				if ( $block[0] === $rcObj ) {
					// no point diffing first to first
					$cur = $this->message['cur'];
				}

				$items[] = $this->changeInfo( $cur, $last, $this->getCharacterDifference( $rcObj ) );
			}

			$items[] = $this->userSeparator;
			$items[] = $rcObj->_user;
			$items[] = $rcObj->_userInfo;
			$items[] = $rcObj->_comment;

			$lines .= '<div>' . implode( " {$this->dir}", $items ) . "</div>\n";
		}
		return $lines;
	}

	protected function changeInfo( $diff, $hist, $size ) {
		if ( is_int($size) ) {
			$size = $this->wrapCharacterDifference( $size );
			return "($diff; $hist; $size)";
		} else {
			return "($diff; $hist)";
		}
	}

	/**
	 * Enhanced RC ungrouped line.
	 * @return string a HTML formated line
	 */
	function recentChangesBlockLine( $rcObj ) {
		# Flag and Timestamp
		$info = $this->getFlags( $rcObj ) . ' ' . $rcObj->timestamp;
		$items[] = $this->spacerArrow() . Xml::tags( 'tt', null, $info );

		# Article link
		$items[] = $rcObj->link;

		if ( !$this->isLog( $rcObj ) ) {
			$items[] = $this->changeInfo( $rcObj->_diffLink, $rcObj->_histLink,
				$this->getCharacterDifference( $rcObj )
			);
		}

		$items[] = $this->userSeparator;
		$items[] = $rcObj->_user;
		$items[] = $rcObj->_userInfo;
		$items[] = $rcObj->_comment;
		$items[] = $rcObj->_watching;

		return '<div>' . implode( " {$this->dir}", $items ) . "</div>\n";

	}

	/**
	 * Enhanced user tool links, with javascript functionality.
	 */
	public function userToolLinks( $userId, $userText ) {
		global $wgUser, $wgDisableAnonTalk, $wgSysopUserBans;
		$talkable = !( $wgDisableAnonTalk && 0 == $userId );
		$blockable = ( $wgSysopUserBans || 0 == $userId );

		/*
		 * Assign each different user a running id. This is used to show user tool
		 * links on demand with javascript, to reduce page size when one user has
		 * multiple changes.
		 *
		 * $linkindex is the running id, and $users contain username -> html snippet
		 * for javascript.
		 */

		static $linkindex = 0;
		$linkindex++;

		static $users = array();
		$userindex = array_search( $userText, $users, true );
		if ( $userindex === false ) {
			$users[] = $userText;
			$userindex = count( $users ) -1;
		}


		global $wgStylePath;
		$image = Xml::element( 'img', array( 'height' => '12',
			'src' => $wgStylePath . '/common/images/magnify-clip.png' )
		);


		$rci = 'RCUI' . $userindex;
		$rcl = 'RCUL' . $linkindex;
		$rcm = 'RCUM' . $linkindex;
		$toggleLink = "javascript:showUserInfo('wgUserInfo$rci', '$rcl' )";
		$tl  = Xml::tags('span', array( 'id' => $rcm ),
			Xml::tags( 'a', array( 'href' => $toggleLink ), $image ) );
		$tl .= Xml::element('span', array( 'id' => $rcl ), ' ' );

		$items = array();
		if( $talkable ) {
			$items[] = $this->skin->userTalkLink( $userId, $userText );
		}
		if( $userId ) {
			$targetPage = SpecialPage::getTitleFor( 'Contributions', $userText );
			$items[] = $this->skin->makeKnownLinkObj( $targetPage,
				wfMsgHtml( 'contribslink' ) );
		}
		if( $blockable && $wgUser->isAllowed( 'block' ) ) {
			$items[] = $this->skin->blockLink( $userId, $userText );
		}
		if( $userId && $wgUser->isAllowed( 'userrights' ) ) {
			$targetPage = SpecialPage::getTitleFor( 'Userrights', $userText );
			$items[] = $this->skin->makeKnownLinkObj( $targetPage,
				wfMsgHtml( 'cleanchanges-changerightslink' ) );
		}

		if( $items ) {
			$data = array( "wgUserInfo$rci" => '(' . implode( ' | ', $items ) . ')' );

			return array($tl, $data);
		} else {
			return '';
		}
	}

	/**
	 * Makes aggregated list of contributors for a changes group.
	 * Example: [Usera; AnotherUser; ActiveUser ‎(2×); Userabc ‎(6×)]
	 */
	function makeUserlinks( $userlinks ) {
		global $wgLang;

		/*
		 * User with least changes first, and fallback to alphabetical sorting if
		 * multiple users have same number of changes.
		 */
		krsort( $userlinks );
		asort( $userlinks );

		$users = array();
		foreach( $userlinks as $userlink => $count) {
			$text = $userlink;
			if( $count > 1 ) {
				$count = $wgLang->formatNum( $count );
				$text .= "{$wgLang->getDirMark()}×$count";
			}
			array_push( $users, $text );
		}
		$text = implode('; ', $users);
		return $this->XMLwrapper( 'changedby', "[$text]", 'span', false );
	}

	function getFlags( $rc, Array $overrides = null ) {
		// TODO: we assume all characters are of equal width, which they may be not
		$map = array(
			# item  =>        field           class      letter
			'new'   => array( 'rc_new',       'newpage', $this->message['newpageletter'] ),
			'minor' => array( 'rc_minor',     'minor',   $this->message['minoreditletter'] ),
			'bot'   => array( 'rc_bot',       'bot',     $this->message['boteditletter'] ),
		);
		if ( self::usePatrol() ) {
			$map['patrol'] = array( 'rc_patrolled', 'unpatrolled', '!' );
		}


		static $nothing = "\xc2\xa0";

		$items = array();
		foreach ( $map as $item => $data ) {
			$bool = isset($overrides[$item]) ? $overrides[$item] : $rc->getAttribute( $data[0] );
			$items[] = $this->XMLwrapper( $data[1], $bool ? $data[2] : $nothing );
		}

		return Xml::tags( 'span', null, implode( '', $items ) );
	}

	protected function getCharacterDifference( $new, $old = null ) {
		if ( $old === null ) $old = $new;

		$newSize = $new->getAttribute('rc_new_len');
		$oldSize = $old->getAttribute('rc_old_len');
		if ( $newSize === null || $oldSize === null ) {
			return '';
		}

		return $newSize - $oldSize;
	}

	public function wrapCharacterDifference( $szdiff ) {
		global $wgRCChangedSizeThreshold, $wgLang;
		static $cache = array();
		if ( !isset($cache[$szdiff]) ) {
			$prefix = $szdiff > 0 ? '+' : '';
			$cache[$szdiff] = wfMsgExt( 'rc-change-size', 'parsemag',
				$prefix . $wgLang->formatNum( $szdiff )
			);
		}

		if( $szdiff < $wgRCChangedSizeThreshold ) {
			return $this->XMLwrapper( 'mw-plusminus-neg', $cache[$szdiff], 'strong' );
		} elseif( $szdiff === 0 ) {
			return $this->XMLwrapper( 'mw-plusminus-null', $cache[$szdiff] );
		} elseif( $szdiff > 0 ) {
			return $this->XMLwrapper( 'mw-plusminus-pos', $cache[$szdiff] );
		} else {
			return $this->XMLwrapper( 'mw-plusminus-neg', $cache[$szdiff] );
		}
	}

	protected function XMLwrapper( $class, $content, $tag = 'span', $escape = true ) {
		if ( $escape ) {
			return Xml::element( $tag, array( 'class' => $class ), $content );
		} else {
			return Xml::tags( $tag, array( 'class' => $class ), $content );
		}
	}

}
