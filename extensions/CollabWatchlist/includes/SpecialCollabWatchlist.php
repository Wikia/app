<?php
/**
 * Implements Special:CollabWatchlist
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along
 * with this program; if not, write to the Free Software Foundation, Inc.,
 * 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 * http://www.gnu.org/copyleft/gpl.html
 *
 * @file
 * @ingroup SpecialPage CollabWatchlist
 */
class SpecialCollabWatchlist extends SpecialWatchlist {

	/**
	 * Constructor
	 */
	public function __construct() {
		//XXX That's nasty, SpecialWatchlist should have a corresponding constructor,
		// or expose the methods we need publicly
		SpecialPage::__construct( 'CollabWatchlist' );
	}

	/**
	 * Main execution point
	 *
	 * @param $par Parameter passed to the page
	 */
	function execute( $par ) {
		global $wgUser, $wgOut, $wgLang, $wgRequest;
		global $wgRCShowWatchingUsers;
		global $wgEnotifWatchlist;

		// Add feed links
		$wlToken = $wgUser->getOption( 'watchlisttoken' );
		if ( !$wlToken ) {
			$wlToken = sha1( mt_rand() . microtime( true ) );
			$wgUser->setOption( 'watchlisttoken', $wlToken );
			$wgUser->saveSettings();
		}

		global $wgFeedClasses;
		$apiParams = array( 'action' => 'feedwatchlist', 'allrev' => 'allrev',
							'wlowner' => $wgUser->getName(), 'wltoken' => $wlToken );
		$feedTemplate = wfScript( 'api' ) . '?';

		foreach ( $wgFeedClasses as $format => $class ) {
			$theseParams = $apiParams + array( 'feedformat' => $format );
			$url = $feedTemplate . wfArrayToCGI( $theseParams );
			$wgOut->addFeedLink( $format, $url );
		}

		$skin = $wgUser->getSkin();
		$specialTitle = SpecialPage::getTitleFor( 'CollabWatchlist' );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );

		# Anons don't get a watchlist
		if ( $wgUser->isAnon() ) {
			$wgOut->setPageTitle( wfMsg( 'watchnologin' ) );
			$llink = $skin->linkKnown(
				SpecialPage::getTitleFor( 'Userlogin' ),
				wfMsgHtml( 'loginreqlink' ),
				array(),
				array( 'returnto' => $specialTitle->getPrefixedText() )
			);
			$wgOut->addHTML( wfMsgWikiHtml( 'watchlistanontext', $llink ) );
			return;
		}

		$wgOut->setPageTitle( wfMsg( 'collabwatchlist' ) );

		$listIdsAndNames = CollabWatchlistChangesList::getCollabWatchlistIdAndName( $wgUser->getId() );
		$sub = wfMsgExt(
			'watchlistfor2',
			array( 'parseinline', 'replaceafter' ),
			$wgUser->getName(),
			''
		);
		$sub .= '<br />' . CollabWatchlistEditor::buildTools( $listIdsAndNames, $wgUser->getSkin() );
		$wgOut->setSubtitle( $sub );

		$uid = $wgUser->getId();

		// The filter form has one checkbox for each tag, build an array
		$postValues = $wgRequest->getValues();
		$tagFilter = array();
		foreach ( $postValues as $key => $value ) {
			if ( stripos( $key, 'collaborative-watchlist-filtertag-' ) === 0 ) {
				$tagFilter[] = $postValues[$key];
			}
		}
		// Alternative syntax for requests from links (show / hide ...)
		if ( empty( $tagFilter ) ) {
			$tagFilter = explode( '|', $wgRequest->getVal( 'filterTags' ) );
		}

		$defaults = array(
		/* float */ 'days'      => floatval( $wgUser->getOption( 'watchlistdays' ) ), /* 3.0 or 0.5, watch further below */
		/* bool  */ 'hideMinor' => (int)$wgUser->getBoolOption( 'watchlisthideminor' ),
		/* bool  */ 'hideBots'  => (int)$wgUser->getBoolOption( 'watchlisthidebots' ),
		/* bool  */ 'hideAnons' => (int)$wgUser->getBoolOption( 'watchlisthideanons' ),
		/* bool  */ 'hideLiu'   => (int)$wgUser->getBoolOption( 'watchlisthideliu' ),
		/* bool  */ 'hideListUser'   => (int)$wgUser->getBoolOption( 'collabwatchlisthidelistuser' ),
		/* bool  */ 'hidePatrolled' => (int)$wgUser->getBoolOption( 'watchlisthidepatrolled' ),
		/* bool  */ 'hideOwn'   => (int)$wgUser->getBoolOption( 'watchlisthideown' ),
		/* int   */ 'collabwatchlist' => 0,
		/* ?     */ 'globalwatch' => 'all',
		/* ?     */ 'invert'    => false,
		/* ?     */ 'invertTags' => false,
		/* ?     */ 'filterTags' => '',
		);

		extract( $defaults );

		# Extract variables from the request, falling back to user preferences or
		# other default values if these don't exist
		$prefs['days']      = floatval( $wgUser->getOption( 'watchlistdays' ) );
		$prefs['hideminor'] = $wgUser->getBoolOption( 'watchlisthideminor' );
		$prefs['hidebots']  = $wgUser->getBoolOption( 'watchlisthidebots' );
		$prefs['hideanons'] = $wgUser->getBoolOption( 'watchlisthideanon' );
		$prefs['hideliu']   = $wgUser->getBoolOption( 'watchlisthideliu' );
		$prefs['hideown' ]  = $wgUser->getBoolOption( 'watchlisthideown' );
		$prefs['hidelistuser'] = $wgUser->getBoolOption( 'collabwatchlisthidelistuser' );
		$prefs['hidepatrolled' ] = $wgUser->getBoolOption( 'watchlisthidepatrolled' );
		$prefs['invertTags' ] = $wgUser->getBoolOption( 'collabwatchlistinverttags' );
		$prefs['filterTags' ] = $wgUser->getOption( 'collabwatchlistfiltertags' );

		# Get query variables
		$days      = $wgRequest->getVal(  'days'     , $prefs['days'] );
		$hideMinor = $wgRequest->getBool( 'hideMinor', $prefs['hideminor'] );
		$hideBots  = $wgRequest->getBool( 'hideBots' , $prefs['hidebots'] );
		$hideAnons = $wgRequest->getBool( 'hideAnons', $prefs['hideanons'] );
		$hideLiu   = $wgRequest->getBool( 'hideLiu'  , $prefs['hideliu'] );
		$hideOwn   = $wgRequest->getBool( 'hideOwn'  , $prefs['hideown'] );
		$hideListUser = $wgRequest->getBool( 'hideListUser', $prefs['hidelistuser'] );
		$hidePatrolled = $wgRequest->getBool( 'hidePatrolled'  , $prefs['hidepatrolled'] );
		$filterTags = implode( '|', $tagFilter );
		$invertTags = $wgRequest->getBool( 'invertTags'  , $prefs['invertTags'] );

		# Get collabwatchlist value, if supplied, and prepare a WHERE fragment
		$collabWatchlist = $wgRequest->getIntOrNull( 'collabwatchlist' );
		if ( !is_null( $collabWatchlist ) && $collabWatchlist !== 'all' ) {
			$collabWatchlist = intval( $collabWatchlist );
		}
		if ( array_key_exists( $collabWatchlist, $listIdsAndNames ) ) {
			$wgOut->addHTML( Xml::element( 'h2', null, $listIdsAndNames[$collabWatchlist] ) );
		}

		if ( ( $mode = CollabWatchlistEditor::getMode( $wgRequest, $par ) ) !== false ) {
			$editor = new CollabWatchlistEditor();
			$editor->execute( $collabWatchlist, $listIdsAndNames, $wgOut, $wgRequest, $mode );
			return;
		}
		if ( !$collabWatchlist )
			return;

		$dbr = wfGetDB( DB_SLAVE, 'watchlist' );
		$recentchanges = $dbr->tableName( 'recentchanges' );

		$nitems = $dbr->selectField( 'collabwatchlistcategory', 'COUNT(*)',
			$collabWatchlist == 0 ? array() : array( 'cw_id' => $collabWatchlist
			), __METHOD__ );
		if ( $nitems == 0 ) {
			$wgOut->addWikiMsg( 'nowatchlist' );
			return;
		}

		// Dump everything here
		$nondefaults = array();

		wfAppendToArrayIfNotDefault( 'days'     , $days          , $defaults, $nondefaults );
		wfAppendToArrayIfNotDefault( 'hideMinor', (int)$hideMinor, $defaults, $nondefaults );
		wfAppendToArrayIfNotDefault( 'hideBots' , (int)$hideBots , $defaults, $nondefaults );
		wfAppendToArrayIfNotDefault( 'hideAnons', (int)$hideAnons, $defaults, $nondefaults );
		wfAppendToArrayIfNotDefault( 'hideLiu'  , (int)$hideLiu  , $defaults, $nondefaults );
		wfAppendToArrayIfNotDefault( 'hideOwn'  , (int)$hideOwn  , $defaults, $nondefaults );
		wfAppendToArrayIfNotDefault( 'hideListUser', (int)$hideListUser, $defaults, $nondefaults );
		wfAppendToArrayIfNotDefault( 'collabwatchlist', $collabWatchlist, $defaults, $nondefaults );
		wfAppendToArrayIfNotDefault( 'hidePatrolled', (int)$hidePatrolled, $defaults, $nondefaults );
		wfAppendToArrayIfNotDefault( 'filterTags', $filterTags   , $defaults, $nondefaults );
		wfAppendToArrayIfNotDefault( 'invertTags', $invertTags   , $defaults, $nondefaults );

		if ( $days <= 0 ) {
			$andcutoff = '';
		} else {
			$andcutoff = "rc_timestamp > '" . $dbr->timestamp( time() - intval( $days * 86400 ) ) . "'";
		}

		# If the watchlist is relatively short, it's simplest to zip
		# down its entirety and then sort the results.

		# If it's relatively long, it may be worth our while to zip
		# through the time-sorted page list checking for watched items.

		# Up estimate of watched items by 15% to compensate for talk pages...

		# Toggles
		$andHideOwn   = $hideOwn   ? "rc_user != $uid" : '';
		$andHideBots  = $hideBots  ? "rc_bot = 0" : '';
		$andHideMinor = $hideMinor ? "rc_minor = 0" : '';
		$andHideLiu   = $hideLiu   ? "rc_user = 0" : '';
		$andHideAnons = $hideAnons ? "rc_user != 0" : '';
		$andHideListUser = $hideListUser ? $this->wlGetFilterClauseListUser( $collabWatchlist ) : '';
		$andHidePatrolled = $wgUser->useRCPatrol() && $hidePatrolled ? "rc_patrolled != 1" : '';

		# Toggle watchlist content (all recent edits or just the latest)
		if ( $wgUser->getOption( 'extendwatchlist' ) ) {
			$andLatest = '';
	 		$limitWatchlist = intval( $wgUser->getOption( 'wllimit' ) );
			$usePage = false;
		} else {
		# Top log Ids for a page are not stored
			$andLatest = 'rc_this_oldid=page_latest OR rc_type=' . RC_LOG;
			$limitWatchlist = 0;
			$usePage = true;
		}

		# Show a message about slave lag, if applicable
		$lag = wfGetLB()->safeGetLag( $dbr );
		if ( $lag > 0 )
			$wgOut->showLagWarning( $lag );

		# Create output form
		$form  = Xml::fieldset( wfMsg( 'watchlist-options' ), false, array( 'id' => 'mw-watchlist-options' ) );

		# Show watchlist header
		$form .= wfMsgExt( 'collabwatchlist-details', array( 'parseinline' ), $wgLang->formatNum( $nitems ) );

		if ( $wgUser->getOption( 'enotifwatchlistpages' ) && $wgEnotifWatchlist ) {
			$form .= wfMsgExt( 'wlheader-enotif', 'parse' ) . "\n";
		}
		$form .= '<hr />';

		$tables = array( 'recentchanges', 'categorylinks' );
		$fields = array( "{$recentchanges}.*" );
		$categoryClause = $this->wlGetFilterClauseForCollabWatchlistIds( $collabWatchlist, 'cl_to', 'rc_cur_id' );
		// If this collaborative watchlist does not contain any categories, add a clause which gives
		// us an empty result
		$conds = isset( $categoryClause ) ? array( $categoryClause ) : array( 'false' );
		$join_conds = array(
			'categorylinks' => array( 'LEFT OUTER JOIN', "rc_cur_id=cl_from" ),
		);
		if ( !empty( $tagFilter ) ) {
			// The tag filter causes a query runtime of O(MxN), where M is relative to the number
			// of recentchanges we select (from a table which is purged periodically, limited to 250)
			// and N is relative the number of change_tag entries for a recentchange. Doing it
			// the other way around (selecting from change_tag first, is probably slower, as the
			// change_tag table is never purged.
			// Using the tag_summary table for filtering is difficult, at least I have been unable to
			// find a common SQL compliant way for using regular expressions which works across Postgre / Mysql
			// Furthermore, ChangeTags does not seem to prevent tags containing ',' from being set,
			// which renders tag_summary quite unusable
			if ( $invertTags ) {
				$filter = 'EXISTS ';
			} else {
				$filter = 'NOT EXISTS ';
			}
			$filter .= '(SELECT cwlrt.ct_rc_id FROM collabwatchlistrevisiontag cwlrt
					WHERE cwlrt.ct_rc_id = recentchanges.rc_id AND cwlrt.ct_tag ';
			if ( count( $tagFilter ) > 1 )
				$filter .= 'IN (' . $dbr->makeList( $tagFilter ) . '))';
			else
				$filter .= ' = ' . $dbr->addQuotes( current( $tagFilter ) ) . ')';
			$conds[] = $filter;
		}
		$options = array( 'ORDER BY' => 'rc_timestamp DESC' );
		if ( $limitWatchlist ) {
			$options['LIMIT'] = $limitWatchlist;
		}
		if ( $andcutoff ) $conds[] = $andcutoff;
		if ( $andLatest ) $conds[] = $andLatest;
		if ( $andHideOwn ) $conds[] = $andHideOwn;
		if ( $andHideBots ) $conds[] = $andHideBots;
		if ( $andHideMinor ) $conds[] = $andHideMinor;
		if ( $andHideLiu ) $conds[] = $andHideLiu;
		if ( $andHideAnons ) $conds[] = $andHideAnons;
		if ( $andHideListUser ) $conds[] = $andHideListUser;
		if ( $andHidePatrolled ) $conds[] = $andHidePatrolled;

		$rollbacker = $wgUser->isAllowed( 'rollback' );
		if ( $usePage || $rollbacker ) {
			$tables[] = 'page';
			$join_conds['page'] = array( 'LEFT JOIN', 'rc_cur_id=page.page_id' );
			if ( $rollbacker )
				$fields[] = 'page_latest';
		}

		ChangeTags::modifyDisplayQuery( $tables, $fields, $conds, $join_conds, $options, '' );
		wfRunHooks( 'SpecialCollabWatchlistQuery', array( &$conds, &$tables, &$join_conds, &$fields ) );

		$res = $dbr->select( $tables, $fields, $conds, __METHOD__, $options, $join_conds );
		$numRows = $dbr->numRows( $res );

		/* Start bottom header */

		$wlInfo = '';
		if ( $days >= 1 ) {
			$wlInfo = wfMsgExt( 'rcnote', 'parseinline',
					$wgLang->formatNum( $numRows ),
					$wgLang->formatNum( $days ),
					$wgLang->timeAndDate( wfTimestampNow(), true ),
					$wgLang->date( wfTimestampNow(), true ),
					$wgLang->time( wfTimestampNow(), true )
				) . '<br />';
		} elseif ( $days > 0 ) {
			$wlInfo = wfMsgExt( 'wlnote', 'parseinline',
					$wgLang->formatNum( $numRows ),
					$wgLang->formatNum( round( $days * 24 ) )
				) . '<br />';
		}

		$cutofflinks = "\n" . $this->cutoffLinks( $days, 'CollabWatchlist', $nondefaults ) . "<br />\n";

		$thisTitle = SpecialPage::getTitleFor( 'CollabWatchlist' );

		# Spit out some control panel links
		$links[] = $this->showHideLink( $nondefaults, 'rcshowhideminor', 'hideMinor', $hideMinor );
		$links[] = $this->showHideLink( $nondefaults, 'rcshowhidebots', 'hideBots', $hideBots );
		$links[] = $this->showHideLink( $nondefaults, 'rcshowhideanons', 'hideAnons', $hideAnons );
		$links[] = $this->showHideLink( $nondefaults, 'rcshowhideliu', 'hideLiu', $hideLiu );
		$links[] = $this->showHideLink( $nondefaults, 'rcshowhidemine', 'hideOwn', $hideOwn );
		$links[] = $this->showHideLink( $nondefaults, 'collabwatchlistshowhidelistusers', 'hideListUser', $hideListUser );

		if ( $wgUser->useRCPatrol() ) {
			$links[] = $this->showHideLink( $nondefaults, 'rcshowhidepatr', 'hidePatrolled', $hidePatrolled );
		}

		# Namespace filter and put the whole form together.
		$form .= $wlInfo;
		$form .= $cutofflinks;
		$form .= $wgLang->pipeList( $links );
		$form .= Xml::openElement( 'form', array( 'method' => 'get', 'action' => $thisTitle->getLocalUrl() ) );
		$form .= '<hr /><p>';
		$tagsAndInfo = CollabWatchlistChangesList::getValidTagsAndInfo( array_keys( $listIdsAndNames ) );
		if ( count( $tagsAndInfo ) > 0 ) {
			$form .= wfMsg( 'collabwatchlistfiltertags' ) . ':&nbsp;&nbsp;';
		}
		foreach ( $tagsAndInfo as $tag => $tagInfo ) {
			$tagAttr = array(
				'name' => 'collaborative-watchlist-filtertag-' . $tag,
				'type' => 'checkbox',
				'value' => $tag );
			if ( in_array( $tag, $tagFilter ) ) {
				$tagAttr['checked'] = 'checked';
			}
			$form .= Xml::element( 'input', $tagAttr ) . '&nbsp;' . Xml::label( $tag, 'collaborative-watchlist-filtertag-' . $tag ) . '&nbsp;';
		}
		if ( count( $tagsAndInfo ) > 0 ) {
			$form .= '<br />';
		}
		$form .= Xml::checkLabel( wfMsg( 'collabwatchlistinverttags' ), 'invertTags', 'nsinvertTags', $invertTags ) . '<br />';
		$form .= CollabWatchlistChangesList::collabWatchlistSelector( $listIdsAndNames, $collabWatchlist, '', 'collabwatchlist', wfMsg( 'collabwatchlist' ) ) . '&nbsp;';
		$form .= Xml::submitButton( wfMsg( 'allpagessubmit' ) ) . '</p>';
		$form .= Html::hidden( 'days', $days );
		if ( $hideMinor )
			$form .= Html::hidden( 'hideMinor', 1 );
		if ( $hideBots )
			$form .= Html::hidden( 'hideBots', 1 );
		if ( $hideAnons )
			$form .= Html::hidden( 'hideAnons', 1 );
		if ( $hideLiu )
			$form .= Html::hidden( 'hideLiu', 1 );
		if ( $hideOwn )
			$form .= Html::hidden( 'hideOwn', 1 );
		if ( $hideListUser )
			$form .= Html::hidden( 'hideListUser', 1 );
		if ( $wgUser->useRCPatrol() )
			if ( $hidePatrolled )
				$form .= Html::hidden( 'hidePatrolled', 1 );
		$form .= Xml::closeElement( 'form' );
		$form .= Xml::closeElement( 'fieldset' );
		$wgOut->addHTML( $form );

		# If there's nothing to show, stop here
		if ( $numRows == 0 ) {
			$wgOut->addWikiMsg( 'watchnochange' );
			return;
		}

		/* End bottom header */

		/* Do link batch query */
		$linkBatch = new LinkBatch;
		foreach ( $res as $row ) {
			$userNameUnderscored = str_replace( ' ', '_', $row->rc_user_text );
			if ( $row->rc_user != 0 ) {
				$linkBatch->add( NS_USER, $userNameUnderscored );
			}
			$linkBatch->add( NS_USER_TALK, $userNameUnderscored );

			$linkBatch->add( $row->rc_namespace, $row->rc_title );
		}
		$linkBatch->execute();
		$dbr->dataSeek( $res, 0 );

		$list = CollabWatchlistChangesList::newFromUser( $wgUser );
		$list->setWatchlistDivs();

		$s = $list->beginRecentChangesList();
		$counter = 1;
		foreach ( $res as $obj ) {
			# Make RC entry
			$rc = RecentChange::newFromRow( $obj );
			$rc->counter = $counter++;

			if ( $wgRCShowWatchingUsers && $wgUser->getOption( 'shownumberswatching' ) ) {
				$rc->numberofWatchingusers = $dbr->selectField( 'watchlist',
					'COUNT(*)',
					array(
						'wl_namespace' => $obj->rc_namespace,
						'wl_title' => $obj->rc_title,
					),
					__METHOD__ );
			} else {
				$rc->numberofWatchingusers = 0;
			}

			$tags = $this->wlTagsForRevision( $obj->rc_this_oldid, array( $collabWatchlist ) );
//			if( isset($tags) ) {
//				// Filter recentchanges which contain unwanted tags
//				$tagNames = array();
//				foreach($tags as $tagInfo) {
//					$tagNames[] = $tagInfo['ct_tag'];
//				}
//				$unwantedTagsFound = array_intersect($tagFilter, $tagNames);
//				if( !empty($unwantedTagsFound) )
//					continue;
//			}
			$attrs = $rc->getAttributes();
			$attrs['collabwatchlist_tags'] = $tags;
			$rc->setAttribs( $attrs );

			$s .= $list->recentChangesLine( $rc, false, $counter );
		}
		$s .= $list->endRecentChangesList();

		$dbr->freeResult( $res );
		$wgOut->addHTML( $s );
	}

	/**
	 * Returns html
	 *
	 * @return string
	 */
	protected function cutoffLinks( $days, $page = 'Watchlist', $options = array() ) {
		return SpecialWatchlist::cutoffLinks( $days, $page, $options );
	}

	/** Returns an array of maps representing collab watchlist tags. The following fields are present
	 * in each map:
	 * - cw_id Id of the collaborative watchlist
	 * - ct_tag Name of the tag
	 * - collabwatchlistrevisiontag.user_id User which set the tag
	 * - user_name Username of the user which set the tag
	 * - rrt_comment Collabwatchlist tag comment
	 * @param $rev_id
	 * @param $cw_ids
	 * @return unknown_type
	 */
	function wlTagsForRevision( $rev_id, $cw_ids = array(), $filterTags = array() ) {
		// Some DB stuff
		$dbr = wfGetDB( DB_SLAVE );
		$cond = array();
		if ( isset( $cw_ids ) && !( count( $cw_ids ) == 1 && $cw_ids[0] == 0 ) ) {
			$cond = array( "cw_id" => $cw_ids );
		}
		if ( isset( $filterTags ) && count( $filterTags ) > 0 ) {
			$cond[] = "ct_tag not in (" . $dbr->makeList( $filterTags ) . ")";
		}
		// $table, $vars, $conds='', $fname = 'Database::select', $options = array(), $join_conds = array()
		$res = $dbr->select( array( 'change_tag', 'collabwatchlistrevisiontag', 'user' ), # Tables
			array( 'cw_id', 'collabwatchlistrevisiontag.ct_tag', 'collabwatchlistrevisiontag.user_id', 'user_name', 'rrt_comment' ), # Fields
			array( 'change_tag.ct_rev_id' => $rev_id ) + $cond,  # Conditions
			__METHOD__, array(),
			 # Join conditions
			array(	'collabwatchlistrevisiontag' => array( 'JOIN', 'change_tag.ct_rc_id = collabwatchlistrevisiontag.ct_rc_id AND change_tag.ct_tag = collabwatchlistrevisiontag.ct_tag' ),
					'user' => array( 'JOIN', 'collabwatchlistrevisiontag.user_id = user.user_id' )
			)
		);
		$tags = array();
		foreach ( $res as $row ) {
			$tags[] = get_object_vars( $row );
		}
		return $tags;
	}

	/**
	 * Constructs the filter SQL clause for the given collaborative watchlist ids.
	 * It filters entries which are not relevant for the given watchlists. I.e.
	 * entries which don't belong to a category and are not listed explicitly as a
	 * page for one of the given watchlists.
	 * @param $cw_ids Array: A list of collaborative watchlist ids
	 * @param $catNameCol String: The name of the column containing category names
	 * @param $pageIdCol String: The name of the column containing page ids
	 * @return String: An SQL clause usable in the conditions parameter of $db->select()
	 */
	function wlGetFilterClauseForCollabWatchlistIds( $cw_ids, $catNameCol, $pageIdCol ) {
		global $wgCollabWatchlistRecursiveCatScan;
		$excludedCatPageIds = array();
		$includedCatPageIds = array();
		$includedPageIds = array();
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( array( 'collabwatchlist', 'collabwatchlistcategory', 'page' ), # Tables
			array( 'cat_page_id', 'page_title', 'page_namespace', 'subtract' ), # Fields
			$cw_ids != 0 ? array( 'collabwatchlist.cw_id' => $cw_ids ) : array(),  # Conditions
			__METHOD__, array(),
			 # Join conditions
			array(	'collabwatchlistcategory' => array( 'JOIN', 'collabwatchlist.cw_id = collabwatchlistcategory.cw_id' ),
					'page' => array( 'JOIN', 'page.page_id = collabwatchlistcategory.cat_page_id' ) )
		);
		foreach ( $res as $row ) {
			if ( $row->page_namespace == NS_CATEGORY ) {
				if ( $row->subtract ) {
					$excludedCatPageIds[$row->cat_page_id] = $row->page_title;
				} else {
					$includedCatPageIds[$row->cat_page_id] = $row->page_title;
				}
			} else {
				$includedPageIds[$row->cat_page_id] = $row->page_title;
			}
		}

		if ( $wgCollabWatchlistRecursiveCatScan && $includedCatPageIds ) {
			$catTree = new CategoryTreeManip();
			$catTree->setMaxDepth($wgCollabWatchlistRecursiveCatScan);
			$catTree->initialiseFromCategoryNames( array_values( $includedCatPageIds ) );
			$catTree->disableCategoryIds( array_keys( $excludedCatPageIds ) );
			$enabledCategoryNames = $catTree->getEnabledCategoryNames();
			if ( empty( $enabledCategoryNames ) )
				return;
			$collabWatchlistClause = '(' . $catNameCol . " IN (" . implode( ',', $this->addQuotes( $dbr, $enabledCategoryNames ) ) . ") ";
			if ( !empty( $includedPageIds ) ) {
				$collabWatchlistClause .= ' OR ' . $pageIdCol . ' IN (' . implode( ',', $this->addQuotes( $dbr, array_keys( $includedPageIds ) ) ) . ')';
			}
			$collabWatchlistClause .= ')';
		} elseif ( !empty( $includedPageIds ) ) {
			$collabWatchlistClause = $pageIdCol . ' IN (' . implode( ',', $this->addQuotes( $dbr, array_keys( $includedPageIds ) ) ) . ')';
		}
		return $collabWatchlistClause;
	}

	/**
	 * Constructs the user filter SQL clause for the given collaborative watchlist ids.
	 * It filters entries from the users of the given watchlists.
	 * @param $cw_ids Array: A list of collaborative watchlist ids
	 * @return String: An SQL clause usable in the conditions parameter of $db->select()
	 */
	function wlGetFilterClauseListUser( $cw_id ) {
		$excludedUserIds = array();
		$dbr = wfGetDB( DB_SLAVE );
		$res = $dbr->select( 'collabwatchlistuser', # Tables
			'user_id', # Fields
			array( 'collabwatchlistuser.cw_id' => $cw_id )  # Conditions
		);
		$clause = '';
		foreach ( $res as $row ) {
			$excludedUserIds[] = $row->user_id;
		}
		if ( $res->numRows() > 0 ) {
			$clause = '( rc_user NOT IN (';
			$clause .= implode( ',', $this->addQuotes( $dbr, $excludedUserIds ) ) . ') )';
		}
		return $clause;
	}

	//XXX SpecialWatchlist should let us pass the page title
	public function showHideLink( $options, $message, $name, $value ) {
		global $wgUser;

		$showLinktext = wfMsgHtml( 'show' );
		$hideLinktext = wfMsgHtml( 'hide' );
		$title = SpecialPage::getTitleFor( 'CollabWatchlist' );
		$skin = $wgUser->getSkin();

		$label = $value ? $showLinktext : $hideLinktext;
		$options[$name] = 1 - (int) $value;

		return wfMsgHtml( $message, $skin->linkKnown( $title, $label, array(), $options ) );
	}

	/**
	 * Runs $db->addQuotes() for each of the strings
	 * @param $db Database: The db object to use
	 * @param $strings Array: A list of strings to quote
	 * @return Array: The $strings quoted by $db->addQuotes()
	 */
	public static function addQuotes( $db, $strings ) {
		$result = array();
		foreach ( $strings as $string ) {
			$result[] = $db->addQuotes( $string );
		}
		return $result;
	}
}
