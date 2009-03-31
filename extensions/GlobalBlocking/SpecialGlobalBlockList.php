<?php
if ( ! defined( 'MEDIAWIKI' ) )
	die();

class SpecialGlobalBlockList extends SpecialPage {
	public $mSearchIP, $mSearch;

	function __construct() {
		wfLoadExtensionMessages('GlobalBlocking');
		parent::__construct( 'GlobalBlockList' );
	}

	function execute( $par ) {
		global $wgUser,$wgOut,$wgRequest;

		$this->setHeaders();
		$this->loadParameters();

		$wgOut->setPageTitle( wfMsg( 'globalblocking-list' ) );
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
		
		// Add a few useful links
		$link_list = /*message-->title*/array( 'globalblocking-goto-block' => 'GlobalBlock', 'globalblocking-goto-unblock' => 'RemoveGlobalBlock', 'globalblocking-goto-status' => 'GlobalBlockStatus' );
		$links = '';
		$sk = $wgUser->getSkin();
		foreach( $link_list as $msg => $pagename ) {
			$title = SpecialPage::getTitleFor( $pagename );
			$links .= Xml::tags( 'li', null, $sk->makeKnownLinkObj( $title, wfMsg( $msg ) ) );
		}
		
		$wgOut->addHTML( Xml::tags( 'ul', null, $links ) );

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

		$wgOut->addHTML( $pager->getNavigationBar() .
				Xml::tags( 'ul', null, $pager->getBody() ) .
				$pager->getNavigationBar() );
	}

	function loadParameters() {
		global $wgRequest,$wgUser;
		$this->mSearchIP = Block::normaliseRange($wgRequest->getText( 'ip' ));
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
		global $wgLang,$wgUser;
		
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
		$whitelistTitle = SpecialPage::getTitleFor( "GlobalBlockStatus" );
		$unblockTitle = SpecialPage::getTitleFor( "RemoveGlobalBlock" );
		
		## Do afterthoughts (comment, links for admins)
		$info = array();
		$info[] = $sk->commentBlock($row->gb_reason);

		if( $wgUser->isAllowed( 'globalunblock' ) ) {
			$info[] = '(' . $sk->makeKnownLinkObj($unblockTitle,
				wfMsg( 'globalblocking-list-unblock' ),
				'address=' . urlencode( $row->gb_address ) ) . ')';
		}
		
		if( $wgUser->isAllowed( 'globalblock-whitelist' ) ) {
			$info[] = '(' . $sk->makeKnownLinkObj($whitelistTitle, 
				wfMsg( 'globalblocking-list-whitelist' ),
				'address=' . urlencode( $row->gb_address ) ) . ')';
		}
		
		## Userpage link / Info on originating wiki
		$display_wiki = GlobalBlocking::getWikiName( $row->gb_by_wiki );
		$user_display = GlobalBlocking::maybeLinkUserpage( $row->gb_by_wiki, $row->gb_by );
		
		## Put it all together.
		return Xml::openElement( 'li' ) .
			wfMsgExt( 'globalblocking-list-blockitem', array( 'parseinline' ), $timestamp,
				$user_display, $display_wiki, $row->gb_address,
				implode( ', ', $options) ) .
				' ' .
				implode( ' ', $info ) .
			Xml::closeElement( 'li' );
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
