<?php
/**
 * A watchlist with changes from multiple wikis
 */
class InterwikiWatchlist extends SpecialWatchlist {
	/**
	 * Constructor
	 *
	 * @param $par Parameter passed to the page
	 */
	function __construct() {
		parent::__construct( 'InterwikiWatchlist' );
		
	}

	/**
	 * Display the interwiki watchlist
	 */
	function execute( $par ) {
		global $wgUser, $wgOut, $wgLang, $wgRequest;
		global $wgRCShowWatchingUsers, $wgEnotifWatchlist, $wgShowUpdatedMarker;
		
		// Add feed links
		$wlToken = $wgUser->getOption( 'watchlisttoken' );
		if (!$wlToken) {
			$wlToken = sha1( mt_rand() . microtime( true ) );
			$wgUser->setOption( 'watchlisttoken', $wlToken );
			$wgUser->saveSettings();
		}
		
		global $wgServer, $wgScriptPath, $wgFeedClasses;
		$apiParams = array( 'action' => 'feedwatchlist', 'allrev' => 'allrev',
							'wlowner' => $wgUser->getName(), 'wltoken' => $wlToken );
		$feedTemplate = wfScript('api').'?';
		
		foreach( $wgFeedClasses as $format => $class ) {
			$theseParams = $apiParams + array( 'feedformat' => $format );
			$url = $feedTemplate . wfArrayToCGI( $theseParams );
			$wgOut->addFeedLink( $format, $url );
		}
	
		$skin = $wgUser->getSkin();
		$specialTitle = SpecialPage::getTitleFor( 'InterwikiWatchlist' );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
	
		# Anons don't get a watchlist
		if( $wgUser->isAnon() ) {
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
	
		$wgOut->setPageTitle( wfMsg( 'interwikiwatchlist' ) );
	
		$sub  = wfMsgExt( 'watchlistfor', 'parseinline', $wgUser->getName() );
		$sub .= '<br />' . SpecialEditWatchlist::buildTools( $wgUser->getSkin() );
		$wgOut->setSubtitle( $sub );
	
		$mode = SpecialEditWatchlist::getMode( $this->getRequest(), $par );
		if( $mode !== false ) {
			# TODO: localise?
			switch( $mode ){
				case SpecialEditWatchlist::EDIT_CLEAR:
					$mode = 'clear';
					break;
				case SpecialEditWatchlist::EDIT_RAW:
					$mode = 'raw';
					break;
				default:
					$mode = null;
			}
			$title = SpecialPage::getTitleFor( 'EditWatchlist', $mode );
			$wgOut->redirect( $title->getLocalUrl() );
			return;
		}
	
		$uid = $wgUser->getId();
		if( ($wgEnotifWatchlist || $wgShowUpdatedMarker) && $wgRequest->getVal( 'reset' ) && 
			$wgRequest->wasPosted() )
		{
			$wgUser->clearAllNotifications();
			$wgOut->redirect( $specialTitle->getFullUrl() );
			return;
		}
	
		$defaults = array(
		/* float */ 'days'      => floatval( $wgUser->getOption( 'watchlistdays' ) ), /* 3.0 or 0.5, watch further below */
		/* bool  */ 'hideMinor' => (int)$wgUser->getBoolOption( 'watchlisthideminor' ),
		/* bool  */ 'hideBots'  => (int)$wgUser->getBoolOption( 'watchlisthidebots' ),
		/* bool  */ 'hideAnons' => (int)$wgUser->getBoolOption( 'watchlisthideanons' ),
		/* bool  */ 'hideLiu'   => (int)$wgUser->getBoolOption( 'watchlisthideliu' ),
		/* bool  */ 'hidePatrolled' => (int)$wgUser->getBoolOption( 'watchlisthidepatrolled' ),
		/* bool  */ 'hideOwn'   => (int)$wgUser->getBoolOption( 'watchlisthideown' ),
		/* ?     */ 'namespace' => 'all',
		/* ?     */ 'invert'    => false,
		);
	
		extract($defaults);
	
		# Extract variables from the request, falling back to user preferences or
		# other default values if these don't exist
		$prefs['days']      = floatval( $wgUser->getOption( 'watchlistdays' ) );
		$prefs['hideminor'] = $wgUser->getBoolOption( 'watchlisthideminor' );
		$prefs['hidebots']  = $wgUser->getBoolOption( 'watchlisthidebots' );
		$prefs['hideanons'] = $wgUser->getBoolOption( 'watchlisthideanon' );
		$prefs['hideliu']   = $wgUser->getBoolOption( 'watchlisthideliu' );
		$prefs['hideown' ]  = $wgUser->getBoolOption( 'watchlisthideown' );
		$prefs['hidepatrolled' ] = $wgUser->getBoolOption( 'watchlisthidepatrolled' );
	
		# Get query variables
		$days      = $wgRequest->getVal(  'days'     , $prefs['days'] );
		$hideMinor = $wgRequest->getBool( 'hideMinor', $prefs['hideminor'] );
		$hideBots  = $wgRequest->getBool( 'hideBots' , $prefs['hidebots'] );
		$hideAnons = $wgRequest->getBool( 'hideAnons', $prefs['hideanons'] );
		$hideLiu   = $wgRequest->getBool( 'hideLiu'  , $prefs['hideliu'] );
		$hideOwn   = $wgRequest->getBool( 'hideOwn'  , $prefs['hideown'] );
		$hidePatrolled   = $wgRequest->getBool( 'hidePatrolled'  , $prefs['hidepatrolled'] );
	
		# Get namespace value, if supplied, and prepare a WHERE fragment
		$nameSpace = $wgRequest->getIntOrNull( 'namespace' );
		$invert = $wgRequest->getIntOrNull( 'invert' );
		if( !is_null( $nameSpace ) ) {
			$nameSpace = intval( $nameSpace );
			if( $invert && $nameSpace !== 'all' )
				$nameSpaceClause = "integration_rc_namespace != $nameSpace";
			else
				$nameSpaceClause = "integration_rc_namespace = $nameSpace";
		} else {
			$nameSpace = '';
			$nameSpaceClause = '';
		}
	
		$dbr = wfGetDB( DB_SLAVE, 'integration_watchlist' );
		$recentchanges = $dbr->tableName( 'integration_recentchanges' );
	
		$nitems = $this->countItems();
	
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
	
		wfAppendToArrayIfNotDefault( 'days'     , $days          , $defaults, $nondefaults);
		wfAppendToArrayIfNotDefault( 'hideMinor', (int)$hideMinor, $defaults, $nondefaults );
		wfAppendToArrayIfNotDefault( 'hideBots' , (int)$hideBots , $defaults, $nondefaults);
		wfAppendToArrayIfNotDefault( 'hideAnons', (int)$hideAnons, $defaults, $nondefaults );
		wfAppendToArrayIfNotDefault( 'hideLiu'  , (int)$hideLiu  , $defaults, $nondefaults );
		wfAppendToArrayIfNotDefault( 'hideOwn'  , (int)$hideOwn  , $defaults, $nondefaults);
		wfAppendToArrayIfNotDefault( 'namespace', $nameSpace     , $defaults, $nondefaults);
		wfAppendToArrayIfNotDefault( 'hidePatrolled', (int)$hidePatrolled, $defaults, $nondefaults );
	
		if( $nitems == 0 ) {
			$wgOut->addWikiMsg( 'nowatchlist' );
			return;
		}
	
		# Possible where conditions
		$conds = array();
	
		if( $days <= 0 ) {
			$andcutoff = '';
		} else {
			$conds[] = "integration_rc_timestamp > '".$dbr->timestamp( time() - intval( $days * 86400 ) )."'";
		}
	
		# If the watchlist is relatively short, it's simplest to zip
		# down its entirety and then sort the results.
	
		# If it's relatively long, it may be worth our while to zip
		# through the time-sorted page list checking for watched items.
	
		# Up estimate of watched items by 15% to compensate for talk pages...
	
		# Toggles
		if( $hideOwn ) {
			$conds[] = "integration_rc_user != $uid";
		}
		if( $hideBots ) {
			$conds[] = 'integration_rc_bot = 0';
		}
		if( $hideMinor ) {
			$conds[] = 'integration_rc_minor = 0';
		}
		if( $hideLiu ) {
			$conds[] = 'integration_rc_user = 0';
		}
		if( $hideAnons ) {
			$conds[] = 'integration_rc_user != 0';
		}
		if ( $wgUser->useRCPatrol() && $hidePatrolled ) {
			$conds[] = 'integration_rc_patrolled != 1';
		}
		if( $nameSpaceClause ) {
			$conds[] = $nameSpaceClause;
		}
	
		# Toggle watchlist content (all recent edits or just the latest)
		if( $wgUser->getOption( 'extendwatchlist' )) {
			$limitWatchlist = intval( $wgUser->getOption( 'wllimit' ) );
			$usePage = false;
		} else {
		# Top log Ids for a page are not stored
			$conds[] = 'integration_rc_this_oldid=integration_page_latest OR integration_rc_type=' . RC_LOG;
			$limitWatchlist = 0;
			$usePage = true;
		}
	
		# Show a message about slave lag, if applicable
		$lag = wfGetLB()->safeGetLag( $dbr );		
		if( $lag > 0 )
			$wgOut->showLagWarning( $lag );
	
		# Create output form
		$form  = Xml::fieldset( wfMsg( 'watchlist-options' ), false, array( 'id' => 'mw-watchlist-options' ) );
	
		# Show watchlist header
		$form .= wfMsgExt( 'watchlist-details', array( 'parseinline' ), $wgLang->formatNum( $nitems ) );
	
		if( $wgUser->getOption( 'enotifwatchlistpages' ) && $wgEnotifWatchlist) {
			$form .= wfMsgExt( 'wlheader-enotif', 'parse' ) . "\n";
		}
		if( $wgShowUpdatedMarker ) {
			$form .= Xml::openElement( 'form', array( 'method' => 'post',
						'action' => $specialTitle->getLocalUrl(),
						'id' => 'mw-watchlist-resetbutton' ) ) .
					wfMsgExt( 'wlheader-showupdated', array( 'parseinline' ) ) . ' ' .
					Xml::submitButton( wfMsg( 'enotif_reset' ), array( 'name' => 'dummy' ) ) .
					Html::Hidden( 'reset', 'all' ) .
					Xml::closeElement( 'form' );
		}
		$form .= '<hr />';
		
		$tables = array( 'integration_recentchanges', 'integration_watchlist' );
		$fields = array( "{$recentchanges}.*" );
		$join_conds = array(
			'integration_watchlist' => array('INNER JOIN',"integration_wl_user='{$uid}' AND integration_wl_namespace=integration_rc_namespace AND integration_wl_title=integration_rc_title AND integration_wl_db=integration_rc_db"),
		);
		$options = array( 'ORDER BY' => 'integration_rc_timestamp DESC' );
		if( $wgShowUpdatedMarker ) {
			$fields[] = 'integration_wl_notificationtimestamp';
		}
		if( $limitWatchlist ) {
			$options['LIMIT'] = $limitWatchlist;
		}
	
		$rollbacker = $wgUser->isAllowed('rollback');
		if ( $usePage || $rollbacker ) {
			$tables[] = 'integration_page';
			$join_conds['integration_page'] = array('LEFT JOIN','integration_rc_cur_id=integration_page_id','integration_rc_db=integration_page_db');
			if ($rollbacker) 
				$fields[] = 'integration_page_latest';
		}
	
		InterwikiIntegrationFunctions::modifyDisplayQuery( $tables, $fields, $conds, $join_conds, $options, '' );
		wfRunHooks('SpecialWatchlistQuery', array(&$conds,&$tables,&$join_conds,&$fields) );
		
		$res = $dbr->select( $tables, $fields, $conds, __METHOD__, $options, $join_conds );
		$numRows = $dbr->numRows( $res );
	
		/* Start bottom header */
	
		$wlInfo = '';
		if( $days >= 1 ) {
			$wlInfo = wfMsgExt( 'rcnote', 'parseinline',
					$wgLang->formatNum( $numRows ),
					$wgLang->formatNum( $days ),
					$wgLang->timeAndDate( wfTimestampNow(), true ),
					$wgLang->date( wfTimestampNow(), true ),
					$wgLang->time( wfTimestampNow(), true )
				) . '<br />';
		} elseif( $days > 0 ) {
			$wlInfo = wfMsgExt( 'wlnote', 'parseinline',
					$wgLang->formatNum( $numRows ),
					$wgLang->formatNum( round($days*24) )
				) . '<br />';
		}
	
		$cutofflinks = "\n" . $this->cutoffLinks( $days, $nondefaults ) . "<br />\n";

		# Spit out some control panel links
		$links[] = $this->showHideLink( $nondefaults, 'rcshowhideminor', 'hideMinor', $hideMinor );
		$links[] = $this->showHideLink( $nondefaults, 'rcshowhidebots', 'hideBots', $hideBots );
		$links[] = $this->showHideLink( $nondefaults, 'rcshowhideanons', 'hideAnons', $hideAnons );
		$links[] = $this->showHideLink( $nondefaults, 'rcshowhideliu', 'hideLiu', $hideLiu );
		$links[] = $this->showHideLink( $nondefaults, 'rcshowhidemine', 'hideOwn', $hideOwn );
	
		if( $wgUser->useRCPatrol() ) {
			$links[] = $this->showHideLink( $nondefaults, 'rcshowhidepatr', 'hidePatrolled', $hidePatrolled );
		}
	
		# Namespace filter and put the whole form together.
		$form .= $wlInfo;
		$form .= $cutofflinks;
		$form .= $wgLang->pipeList( $links );
		$form .= Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->getTitle()->getLocalUrl(), 'id' => 'mw-watchlist-form-namespaceselector' ) );
		$form .= '<hr /><p>';
		$form .= Xml::label( wfMsg( 'namespace' ), 'namespace' ) . '&#160;';
		$form .= Xml::namespaceSelector( $nameSpace, '' ) . '&#160;';
		$form .= Xml::checkLabel( wfMsg('invert'), 'invert', 'nsinvert', $invert ) . '&#160;';
		$form .= Xml::submitButton( wfMsg( 'allpagessubmit' ) ) . '</p>';
		$form .= Html::Hidden( 'days', $days );
		if( $hideMinor )
			$form .= Html::Hidden( 'hideMinor', 1 );
		if( $hideBots )
			$form .= Html::Hidden( 'hideBots', 1 );
		if( $hideAnons )
			$form .= Html::Hidden( 'hideAnons', 1 );
		if( $hideLiu )
			$form .= Html::Hidden( 'hideLiu', 1 );
		if( $hideOwn )
			$form .= Html::Hidden( 'hideOwn', 1 );
		$form .= Xml::closeElement( 'form' );
		$form .= Xml::closeElement( 'fieldset' );
		$wgOut->addHTML( $form );
	
		$wgOut->addHTML( InterwikiIntegrationChangesList::flagLegend() );
	
		# If there's nothing to show, stop here
		if( $numRows == 0 ) {
			$wgOut->addWikiMsg( 'watchnochange' );
			return;
		}
	
		/* End bottom header */
	
		/* Do link batch query */
		$linkBatch = new LinkBatch;
		while ( $row = $dbr->fetchObject( $res ) ) {
			$userNameUnderscored = str_replace( ' ', '_', $row->integration_rc_user_text );
			if ( $row->integration_rc_user != 0 ) {
				$linkBatch->add( NS_USER, $userNameUnderscored );
			}
			$linkBatch->add( NS_USER_TALK, $userNameUnderscored );
	
			$linkBatch->add( $row->integration_rc_namespace, $row->integration_rc_title );
		}
		$linkBatch->execute();
		$dbr->dataSeek( $res, 0 );
	
		$list = InterwikiIntegrationChangesList::newFromUser( $wgUser );
		$list->setWatchlistDivs();
		
		$s = $list->beginRecentInterwikiIntegrationChangesList();
		$counter = 1;
		while ( $obj = $dbr->fetchObject( $res ) ) {
			# Make RC entry
			$rc = InterwikiIntegrationRecentChange::newFromRow( $obj );
			$rc->counter = $counter++;
	
			if ( $wgShowUpdatedMarker ) {
				$updated = $obj->integration_wl_notificationtimestamp;
			} else {
				$updated = false;
			}
	
			if ($wgRCShowWatchingUsers && $wgUser->getOption( 'shownumberswatching' )) {
				$rc->numberofWatchingusers = $dbr->selectField( 'integration_watchlist',
					'COUNT(*)',
					array(
						'integration_wl_namespace' => $obj->integration_rc_namespace,
						'integration_wl_title' => $obj->integration_rc_title,
					),
					__METHOD__ );
			} else {
				$rc->numberofWatchingusers = 0;
			}
	
			$s .= $list->recentChangesLine( $rc, $updated, $counter );
		}
		$s .= $list->endRecentInterwikiIntegrationChangesList();
	
		$dbr->freeResult( $res );
		$wgOut->addHTML( $s );
	}
	
	/**
	 * Count the number of items on a user's watchlist
	 *
	 * @return integer
	 */
	function countItems() {
		$dbr = wfGetDB( DB_SLAVE, 'integration_watchlist' );

		# Fetch the raw count
		$res = $dbr->select( 'integration_watchlist', 'COUNT(*) AS count', 
			array( 'integration_wl_user' => $this->getUser()->getId() ), __METHOD__ );
		$row = $dbr->fetchObject( $res );
		$count = $row->count;
		$dbr->freeResult( $res );

		return floor( $count / 2 );
	}
}
