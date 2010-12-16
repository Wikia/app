<?php

class SpecialGlobalBlockList extends SpecialPage {
	public $mSearchIP, $mSearch;

	function __construct() {
		wfLoadExtensionMessages('GlobalBlocking');
		parent::__construct( 'GlobalBlockList' );
	}

	function execute( $par ) {
		global $wgUser,$wgOut,$wgRequest;

		$this->setHeaders();
		$ip = isset( $par ) ? $par : $wgRequest->getText( 'ip' );
		$this->loadParameters( $ip );

		$wgOut->setPageTitle( wfMsg( 'globalblocking-list' ) );
		$wgOut->setSubtitle( GlobalBlocking::buildSubtitleLinks( 'GlobalBlockList' ) );
		$wgOut->setRobotPolicy( "noindex,nofollow" );
		$wgOut->setArticleRelated( false );
		$wgOut->enableClientCache( false );

		$this->showList();
	}

	function showList( ) {
		global $wgOut,$wgScript,$wgUser;
		$errors = array();

		// Validate search IP
		$ip = $this->mSearchIP;
		if (!IP::isIPAddress($ip) && strlen($ip)) {
			$errors[] = array('globalblocking-list-ipinvalid',$ip);
			$ip = '';
		}

		$wgOut->addWikiMsg( 'globalblocking-list-intro' );
		

		// Build the search form
		$searchForm = '';
		$searchForm .= Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', null, wfMsg( 'globalblocking-search-legend' ) );
		$searchForm .= Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript, 'name' => 'globalblocklist-search' ) );
		$searchForm .= Xml::hidden( 'title',  SpecialPage::getTitleFor('GlobalBlockList')->getPrefixedText() );

		if (is_array($errors) && count($errors)>0) {
			$errorstr = '';
			
			foreach ( $errors as $error ) {
				if (is_array($error)) {
					$msg = array_shift($error);
				} else {
					$msg = $error;
					$error = array();
				}
				
				$errorstr .= Xml::tags( 'li', null, wfMsgExt( $msg, array( 'parseinline' ), $error ) );
			}

			$wgOut->addWikiMsg( 'globalblocking-unblock-errors', count($errors) );
			$wgOut->addHTML( Xml::tags( 'ul', array( 'class' => 'error' ), $errorstr ) );
		}

		$fields = array();
		$fields['globalblocking-search-ip'] = Xml::input( 'ip', 45, $ip );
		$searchForm .= Xml::buildForm( $fields, 'globalblocking-search-submit' );

		$searchForm .= Xml::closeElement( 'form' ) . Xml::closeElement( 'fieldset' );
		$wgOut->addHTML( $searchForm );

		// Build a list of blocks.
		$conds = array();
		
		if (strlen($ip)) {
			list ($range_start, $range_end) = IP::parseRange( $ip );
			
			if ($range_start != $range_end) {
				// They searched for a range. Match that exact range only
				$conds = array( 'gb_address' => $ip );
			} else {
				// They searched for an IP. Match any range covering that IP		
				$hex_ip = IP::toHex( $ip );
				$ip_pattern = substr( $hex_ip, 0, 4 ) . '%'; // Don't bother checking blocks out of this /16.
				
				$dbr = wfGetDB( DB_SLAVE );
			
				$conds = array( 'gb_range_end>='.$dbr->addQuotes($hex_ip), // This block in the given range.
						'gb_range_start<='.$dbr->addQuotes($hex_ip),
						'gb_range_start like ' . $dbr->addQuotes( $ip_pattern ),
						'gb_expiry>'.$dbr->addQuotes($dbr->timestamp(wfTimestampNow())) );
			}
		}

		$pager = new GlobalBlockListPager( $this, $conds );
		$body = $pager->getBody();
		if( $body != '' ) {
			$wgOut->addHTML( $pager->getNavigationBar() .
					Html::rawElement( 'ul', array(), $body ) .
					$pager->getNavigationBar() );
		} else {
			$wgOut->wrapWikiMsg( "<div class='mw-globalblocking-noresults'>\n$1</div>\n",
				array( 'globalblocking-list-noresults' ) );
		}
	}

	function loadParameters( $ip ) {
		global $wgUser;
		$this->mSearchIP = Block::normaliseRange( trim( $ip ) );
	}
}

// Shamelessly stolen from SpecialIpblocklist.php
class GlobalBlockListPager extends ReverseChronologicalPager {
	public $mForm, $mConds;

	function __construct( $form, $conds = array() ) {
		$this->mForm = $form;
		$this->mConds = $conds;
		parent::__construct();
		$this->mDb = GlobalBlocking::getGlobalBlockingSlave();
	}

	function formatRow( $row ) {
		global $wgLang, $wgUser;
		
		## One-time setup
		static $sk=null;
		
		if (is_null($sk)) {
			$sk = $wgUser->getSkin();
		}
		
		## Setup
		$timestamp = $row->gb_timestamp;
		$expiry = $row->gb_expiry;
		$options = array();
		
		## Options to display
		$options[] = Block::formatExpiry( $expiry );
		
		# Check for whitelisting.
		$wlinfo = GlobalBlocking::getWhitelistInfo( $row->gb_id );
		if ($wlinfo) {
			$options[] = wfMsg( 'globalblocking-list-whitelisted', User::whois($wlinfo['user']), $wlinfo['reason'] );
		}
		
		$timestamp = $wgLang->timeanddate( wfTimestamp( TS_MW, $timestamp ), true );

		if ($row->gb_anon_only)
			$options[] = wfMsg('globalblocking-list-anononly');
		
		$titleObj = SpecialPage::getTitleFor( "GlobalBlockList" );
		
		## Do afterthoughts (comment, links for admins)
		$info = array();

		if( $wgUser->isAllowed( 'globalunblock' ) ) {
			$unblockTitle = SpecialPage::getTitleFor( "RemoveGlobalBlock" );
			$info[] = $sk->link( $unblockTitle, 
								wfMsgExt( 'globalblocking-list-unblock', 'parseinline' ),
								array(),
								array( 'address' => $row->gb_address )
							);
		}

		global $wgApplyGlobalBlocks;
		if( $wgUser->isAllowed( 'globalblock-whitelist' ) && $wgApplyGlobalBlocks ) {
			$whitelistTitle = SpecialPage::getTitleFor( "GlobalBlockStatus" );
			$info[] = $sk->link( $whitelistTitle, 
								wfMsgExt( 'globalblocking-list-whitelist', 'parseinline' ),
								array(),
								array( 'address' => $row->gb_address )
							);
		}

		if ( $wgUser->isAllowed( 'globalblock' ) ) {
			$reblockTitle = SpecialPage::getTitleFor( 'GlobalBlock' );
			$msg = wfMsgExt( 'globalblocking-list-modify', 'parseinline' );
			$info[] = $sk->link(
						$reblockTitle,
						$msg,
						array(),
						array( 'wpAddress' => $row->gb_address, 'modify' => 1 )
					);
		}

		## Userpage link / Info on originating wiki
		$display_wiki = GlobalBlocking::getWikiName( $row->gb_by_wiki );
		$user_display = GlobalBlocking::maybeLinkUserpage( $row->gb_by_wiki, $row->gb_by );
		$infoItems = count( $info ) ? wfMsg( 'parentheses', $wgLang->pipeList( $info ) ) : '';

		## Put it all together.
		return Html::rawElement( 'li', array(),
				wfMsgExt( 'globalblocking-list-blockitem', array( 'parseinline' ),
					$timestamp,
					$user_display,
					$display_wiki,
					$row->gb_address,
					$wgLang->commaList( $options )
					) . ' ' .
				$sk->commentBlock( $row->gb_reason ) . ' ' .
				$infoItems
			);
	}

	function getQueryInfo() {
		$conds = $this->mConds;
		#$conds[] = 'gb_expiry>' . $this->mDb->addQuotes( $this->mDb->timestamp() );
		return array(
			'tables' => 'globalblocks',
			'fields' => '*',
			'conds' => $conds,
		);
	}

	function getIndexField() {
		return 'gb_timestamp';
	}
}
