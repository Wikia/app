<?php
////
// Author: Bradley Pesicka (teknomunk).
// Date: ??
//
// Date: 20081127 - modified by Sean Colombo to work with MediaWiki 1.13.2 without any hacks to main code.
////

require_once 'extras.php';

class WatchlistFeed extends SpecialPage
{
	var $server;
	function __construct()
	{
		parent::__construct("WatchlistFeed");
	}
	function execute( $par )
	{
		$this->setHeaders();
		global $wgRequest;

		if( $uid = $wgRequest->getVal( 'uid' ) ) {
			global $wgOut, $wgUser;
			$wgOut->disable();

			$user = User::newFromName( $name = User::whoIs($uid) );
			if( !$user ) {
				$enabled = false;
			} else {
				$enabled = ( $user->getGlobalPreference( "enableWatchlistFeed" ) == "yes" ) ? true : false;
				$wgUser = $user;
			}

			$feed = $this->createFeed();

			if( !$enabled ) {
				$this->displayDisabledFeed( $feed );
			} else {
				$this->displayWatchlist( $feed, $user );
			}
		} else { # not a feed link
			global $wgUser;

			if( $wgUser->isAnon() ) {
				global $wgOut;
				$wgOut->loginToUse();
			} else {
				if( $wgRequest->getVal("wpenable") ) {
					$this->enableFeed();
				} else if( $wgRequest->getVal("wpdisable") ) {
					$this->disableFeed();
				}

				$this->displayConfigurationForm();
			}
		}
	}
	function createFeed() {
		global $wgRequest, $wgTitle, $wgFeedClasses, $wgUser;

		$feedFormat = $wgRequest->getVal( 'feed' );
		return new $wgFeedClasses[$feedFormat](
			wfMsgForContent( 'watchlistfeed-title', $wgUser->getName()),
			htmlspecialchars( wfMsgForContent( 'watchlistfeed-desc', $wgUser->getName() ) ),
			$wgTitle->getFullUrl() );
	}

	function disableFeed() {
		global $wgUser;

		$wgUser->setGlobalPreference("enableWatchlistFeed","no");
		$wgUser->saveSettings();
	}
	function enableFeed() {
		global $wgUser;

		$wgUser->setGlobalPreference("enableWatchlistFeed","yes");

		$key = $this->generateAccessKey();
		$wgUser->setGlobalAttribute("watchlistAccessKey",$key);
		$wgUser->saveSettings();
	}
	function generateAccessKey() {
		global $wgWatchlistAccessKeySize;

		$keySet = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$setSize = strlen($keySet);

		$key = "";
		for( $i = 0; $i < $wgWatchlistAccessKeySize; $i += 1 ) {
			$key .= $keySet[rand(0,$setSize)];
		}

		return $key;
	}
	function displayConfigurationForm() {
		global $wgOut,$wgRequest,$wgUser,$wgTitle;
		$option = $wgUser->getGlobalPreference( "enableWatchlistFeed" );
		$enabled = ( $option == "yes" ) ? true : false;

		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->addHTML("<form>");

			if( $enabled ) {
				$wgOut->addHTML(wfMsg("watchlistfeed-feed-state-enabled")."<br/>");

				$rssFeedUrl = $wgTitle->getFullUrl()
					."?uid=".$wgUser->getID()
					."&key=".$wgUser->getGlobalAttribute("watchlistAccessKey")
					."&feed=rss";
				$atomFeedUrl = $wgTitle->getFullUrl()
					."?uid=".$wgUser->getID()
					."&key=".$wgUser->getGlobalAttribute("watchlistAccessKey")
					."&feed=atom";

				$wgOut->addHTML(wfMsg("watchlistfeed-links",$rssFeedUrl,$atomFeedUrl));

			} else {
				$wgOut->addHTML(wfMsg("watchlistfeed-feed-state-disabled")."<br/>");
			}

			$this->submitButton( "enable" );
			$this->submitButton( "disable" );
		$wgOut->addHTML("</form>");
	}

	function displayDisabledFeed( $feed ) {
		GLOBAL $wgUser, $wgTitle;
		$feed->outHeader();
		$item = new FeedItem(
			wfMsgForContent("watchlistfeed-error-disabled-title",$wgUser->getName()),
			wfMsgForContent("watchlistfeed-error-disabled-desc", $wgUser->getName()),
			$wgTitle->getFullURL()
			);
		$feed->outItem( $item );
		$feed->outFooter();
	}

	# BEGIN COPY  - MediaWiki 1.7.1 SpecialRecentchanges.php
	function rcFormatDiff( $row ) {
		$titleObj = Title::makeTitle( $row->rc_namespace, $row->rc_title );
		return $this->rcFormatDiffRow( $titleObj,
			$row->rc_last_oldid, $row->rc_this_oldid,
			$row->rc_timestamp,
			$row->rc_comment );
	}
	function rcFormatDiffRow( $title, $oldid, $newid, $timestamp, $comment ) {
		global $wgFeedDiffCutoff, $wgContLang, $wgUser;
		$fname = 'rcFormatDiff';
		wfProfileIn( $fname );

		require_once( 'diff/DifferenceEngine.php' );
		$skin = $wgUser->getSkin();
		$completeText = '<p>' . $skin->formatComment( $comment ) . "</p>\n";

		if( $title->getNamespace() >= 0 ) {
			if( $oldid ) {
				wfProfileIn( "$fname-dodiff" );

				$de = new DifferenceEngine( $title, $oldid, $newid );
				#$diffText = $de->getDiff( wfMsg( 'revisionasof',
				#	$wgContLang->timeanddate( $timestamp ) ),
				#	wfMsg( 'currentrev' ) );
				$diffText = $de->getDiff(
					wfMsg( 'previousrevision' ), // hack
					wfMsg( 'revisionasof',
						$wgContLang->timeanddate( $timestamp ) ) );


				if ( strlen( $diffText ) > $wgFeedDiffCutoff ) {
					// Omit large diffs
					$diffLink = $title->escapeFullUrl(
						'diff=' . $newid .
						'&oldid=' . $oldid );
					$diffText = '<a href="' .
						$diffLink .
						'">' .
						htmlspecialchars( wfMsgForContent( 'difference' ) ) .
						'</a>';
				} elseif ( $diffText === false ) {
					// Error in diff engine, probably a missing revision
					$diffText = "<p>Can't load revision $newid</p>";
				} else {
					// Diff output fine, clean up any illegal UTF-8
					$diffText = UtfNormal::cleanUp( $diffText );
					$diffText = $this->rcApplyDiffStyle( $diffText );
				}
				wfProfileOut( "$fname-dodiff" );
			} else {
				$rev = Revision::newFromId( $newid );
				if( is_null( $rev ) ) {
					$newtext = '';
				} else {
					$newtext = $rev->getText();
				}
				$diffText = '<p><b>' . wfMsg( 'newpage' ) . '</b></p>' .
					'<div>' . nl2br( htmlspecialchars( $newtext ) ) . '</div>';
			}
			$completeText .= $diffText;
		}

		wfProfileOut( $fname );
		return $completeText;
	}
	/**
	* Hacky application of diff styles for the feeds.
	* Might be 'cleaner' to use DOM or XSLT or something,
	* but *gack* it's a pain in the ass.
	*
	* @param $text String:
	* @return string
	* @private
	*/
	function rcApplyDiffStyle( $text ) {
		$styles = array(
			'diff'             => 'background-color: white;',
			'diff-otitle'      => 'background-color: white;',
			'diff-ntitle'      => 'background-color: white;',
			'diff-addedline'   => 'background: #cfc; font-size: smaller;',
			'diff-deletedline' => 'background: #ffa; font-size: smaller;',
			'diff-context'     => 'background: #eee; font-size: smaller;',
			'diffchange'       => 'color: red; font-weight: bold;',
		);

		foreach( $styles as $class => $style ) {
			$text = preg_replace( "/(<[^>]+)class=(['\"])$class\\2([^>]*>)/",
				"\\1style=\"$style\"\\3", $text );
		}

		return $text;
	}
	# END COPY  - MediaWiki 1.7.1 SpecialRecentchanges.php

	function displayWatchlist( $feed, $user ) {
		global $wgOut, $IP;

		require_once "$IP/includes/specials/SpecialWatchlist.php";
		$watchlist = new Watchlist();

		$feed->outHeader();
		$watchlist->prepare();
		while ( $obj = $watchlist->getItem() ) {
			$userIp = RecentChange::extractUserIpFromRow( $obj );
			$title = Title::makeTitle( $obj->rc_namespace, $obj->rc_title );
			$talkpage = $title->getTalkPage();

			$item = new FeedItem(
				$title->getFullText(),
				$this->rcFormatDiff( $obj ),
				$title->getFullURL(),
				$obj->rc_timestamp,
				User::getUsername( $obj->rc_user, $userIp ), // SUS-812
				$talkpage->getFullURL()
				);
			$feed->outItem($item);

		}
		$watchlist->cleanup();
		$feed->outFooter();
	}

	function submitButton( $name )
	{
		global $wgOut;

		$prefix = "watchlistfeed";

		$wgOut->addHTML("<input id='wp$name' name='wp$name' type='submit' value='".wfMsg("$prefix-$name")."' accesskey='".wfMsg("$prefix-$name-key")."' title='".wfMsg("$prefix-$name")." [".wfMsg("$prefix-$name-key")."]' />");
	}
} // end class WatchlistFeed

////
// Watchlist class for simply fetching items.
////
class Watchlist{

	/* @var Database */
	private $mDbr;
	private $mChanges; // the result for the "changes" query.

	public function __construct() {}

	////
	// Pre-fetch the results from the database.
	////
	public function prepare(){
		global $wgUser, $wgRequest, $wgShowUpdatedMarker;
		$fname = 'Watchlist::prepare';

		$defaults = array(
		/* float */ 'days' => floatval( $wgUser->getGlobalPreference( 'watchlistdays' ) ), /* 3.0 or 0.5, watch further below */
		/* bool  */ 'hideOwn' => (int)$wgUser->getGlobalPreference( 'watchlisthideown' ),
		/* bool  */ 'hideBots' => (int)$wgUser->getGlobalPreference( 'watchlisthidebots' ),
		/* bool */ 'hideMinor' => (int)$wgUser->getGlobalPreference( 'watchlisthideminor' ),
		/* ?     */ 'namespace' => 'all',
		);

		extract($defaults);

		# Extract variables from the request, falling back to user preferences or
		# other default values if these don't exist
		$prefs['days'    ] = floatval( $wgUser->getGlobalPreference( 'watchlistdays' ) );
		$prefs['hideown' ] = (bool)$wgUser->getGlobalPreference( 'watchlisthideown' );
		$prefs['hidebots'] = (bool)$wgUser->getGlobalPreference( 'watchlisthidebots' );
		$prefs['hideminor'] = (bool)$wgUser->getGlobalPreference( 'watchlisthideminor' );

		# Get query variables
		$days     = $wgRequest->getVal(  'days', $prefs['days'] );
		$hideOwn  = $wgRequest->getBool( 'hideOwn', $prefs['hideown'] );
		$hideBots = $wgRequest->getBool( 'hideBots', $prefs['hidebots'] );
		$hideMinor = $wgRequest->getBool( 'hideMinor', $prefs['hideminor'] );

		# Get namespace value, if supplied, and prepare a WHERE fragment
		$nameSpace = $wgRequest->getIntOrNull( 'namespace' );
		if( !is_null( $nameSpace ) ) {
			$nameSpace = intval( $nameSpace );
			$nameSpaceClause = " AND rc_namespace = $nameSpace";
		} else {
			$nameSpace = '';
			$nameSpaceClause = '';
		}

		$this->mDbr = wfGetDB( DB_SLAVE, 'watchlist' );
		list( $page, $watchlist, $recentchanges ) = $this->mDbr->tableNamesN( 'page', 'watchlist', 'recentchanges' );

		$uid = $wgUser->getId();
		$watchlistCount = $this->mDbr->selectField( 'watchlist', 'COUNT(*)',
			array( 'wl_user' => $uid ), __METHOD__ );
		// Adjust for page X, talk:page X, which are both stored separately,
		// but treated together
		$nitems = floor($watchlistCount / 2);

		if( is_null($days) || !is_numeric($days) ) {
			$big = 1000; /* The magical big */
			if($nitems > $big) {
				# Set default cutoff shorter
				$days = $defaults['days'] = (12.0 / 24.0); # 12 hours...
			} else {
				$days = $defaults['days']; # default cutoff for shortlisters
			}
		} else {
			$days = floatval($days);
		}

		// Dump everything here
		$nondefaults = array();

		wfAppendToArrayIfNotDefault('days'     , $days         , $defaults, $nondefaults);
		wfAppendToArrayIfNotDefault('hideOwn'  , (int)$hideOwn , $defaults, $nondefaults);
		wfAppendToArrayIfNotDefault('hideBots' , (int)$hideBots, $defaults, $nondefaults);
		wfAppendToArrayIfNotDefault( 'hideMinor', (int)$hideMinor, $defaults, $nondefaults );
		wfAppendToArrayIfNotDefault('namespace', $nameSpace    , $defaults, $nondefaults);

		$hookSql = "";
		if( ! Hooks::run('BeforeWatchlist', array($nondefaults, $wgUser, &$hookSql)) ) {
			return;
		}

		if ( $days <= 0 ) {
			$andcutoff = '';
		} else {
			$andcutoff = "AND rc_timestamp > '".$this->mDbr->timestamp( time() - intval( $days * 86400 ) )."'";
			/*
			$sql = "SELECT COUNT(*) AS n FROM $page, $revision  WHERE rev_timestamp>'$cutoff' AND page_id=rev_page";
			$this->mChanges = $this->mDbr->query( $sql, $fname );
			$s = $this->mDbr->fetchObject( $this->mChanges );
			$npages = $s->n;
			*/
		}

		# If the watchlist is relatively short, it's simplest to zip
		# down its entirety and then sort the results.

		# If it's relatively long, it may be worth our while to zip
		# through the time-sorted page list checking for watched items.

		# Up estimate of watched items by 15% to compensate for talk pages...

		# Toggles
		$andHideOwn = $hideOwn ? "AND (rc_user <> $uid)" : '';
		$andHideBots = $hideBots ? "AND (rc_bot = 0)" : '';
		$andHideMinor = $hideMinor ? 'AND rc_minor = 0' : '';

		# Toggle watchlist content (all recent edits or just the latest)
		if( $wgUser->getGlobalPreference( 'extendwatchlist' )) {
			$andLatest='';
			$limitWatchlist = 'LIMIT ' . intval( $wgUser->getGlobalPreference( 'wllimit' ) );
		} else {
		# Top log Ids for a page are not stored
			$andLatest = 'AND (rc_this_oldid=page_latest OR rc_type=' . RC_LOG . ') ';
			$limitWatchlist = '';
		}

		if ( $wgShowUpdatedMarker ) {
			$wltsfield = ", ${watchlist}.wl_notificationtimestamp ";
		} else {
			$wltsfield = '';
		}
		$sql = "SELECT ${recentchanges}.* ${wltsfield}
		  FROM $watchlist,$recentchanges
		  LEFT JOIN $page ON rc_cur_id=page_id
		  WHERE wl_user=$uid
		  AND wl_namespace=rc_namespace
		  AND wl_title=rc_title
		  $andcutoff
		  $andLatest
		  $andHideOwn
		  $andHideBots
		  $andHideMinor
		  $nameSpaceClause
		  $hookSql
		  ORDER BY rc_timestamp DESC
		  $limitWatchlist";

		$this->mChanges = $this->mDbr->query( $sql, $fname );
		$numRows = $this->mDbr->numRows( $this->mChanges );

		# If there's nothing to show, stop here
		if( $numRows == 0 ) {
			return;
		}

		// Do link batch query - NOTE: I don't know what this section does or wheter it's needed - SWC 20081127
		$linkBatch = new LinkBatch;
		while ( $row = $this->mDbr->fetchObject( $this->mChanges ) ) {
			$userIp = RecentChange::extractUserIpFromRow( $row );
			$userNameUnderscored = str_replace( ' ', '_', User::getUsername( $row->rc_user, $userIp ) ); // SUS-812
			if ( $row->rc_user != 0 ) {
				$linkBatch->add( NS_USER, $userNameUnderscored );
			}
			$linkBatch->add( NS_USER_TALK, $userNameUnderscored );
		}
		$linkBatch->execute();
		$this->mDbr->dataSeek( $this->mChanges, 0 );
	} // end prepare()

	////
	// Returns one row of the result from the watchlist query.
	////
	public function getItem(){
		return $this->mDbr->fetchObject( $this->mChanges );
	} // end getItem()

	////
	// Frees memory after you're done with the query.
	////
	function cleanup() {
		$this->mDbr->freeResult( $this->mChanges );
	}

} // end class Watchlist
