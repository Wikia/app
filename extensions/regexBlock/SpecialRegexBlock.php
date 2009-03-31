<?php
/**
 * A special page with the interface for blocking, viewing and unblocking
 * user names and IP addresses
 *
 * @file
 * @ingroup Extensions
 * @author Bartek Łapiński <bartek at wikia-inc.com>, Piotr Molski <moli at wikia-inc.com>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
*/

/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if( !defined('MEDIAWIKI') )
	die();

class RegexBlockForm extends SpecialPage {
	var $mRegexUnblockedAddress;
	var $numResults = 0;
	var $numStatResults = 0;
	var $mPosted, $mAction;
	var $mFilter, $mRegexFilter;
	var $mLimit;
	var $mOffset;
	var $mError, $mMsg;

	/**
	 * Constructor
	 */
	public function __construct() {
		$this->mPosted = false;
		$this->mAction = '';
		$this->mFilter = $this->mRegexFilter = '';
		$this->mError = $this->mMsg = '';
		parent::__construct( 'RegexBlock'/*class*/, 'regexblock'/*restriction*/ );
		wfLoadExtensionMessages('RegexBlock');
	}

	/**
	 * Show the special page
	 *
	 * @param $subpage Mixed: parameter passed to the page or null
	 */
	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest;

		# If the user doesn't have the required 'regexblock' permission, display an error
		if ( !$wgUser->isAllowed( 'regexblock' ) ) {
			$this->displayRestrictionError();
			return;
		}

		# Show a message if the database is in read-only mode
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}

		# If user is blocked, s/he doesn't need to access this page
		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		// Initial output
		$this->mTitle = $this->getTitle();
		$wgOut->setRobotPolicy( 'noindex,nofollow' );
		$wgOut->setPageTitle( wfMsg('regexblock-page-title') );
		$wgOut->setArticleRelated( false );

		$this->mPosted = $wgRequest->wasPosted();
		$this->mAction = $wgRequest->getVal( 'action' );
		$this->mFilter = $wgRequest->getVal( 'filter' );
		$this->mRegexFilter = $wgRequest->getVal( 'rfilter' );
		
		list( $this->mLimit, $this->mOffset ) = $wgRequest->getLimitOffset();

		$this->mRegexBlockedAddress = $this->mRegexBlockedExact = $this->mRegexBlockedCreation = $this->mRegexBlockedExpire = $this->mRegexBlockedReason = '';
		if ( $this->mAction == 'submit' ) {
			$this->mRegexBlockedAddress = htmlspecialchars( $wgRequest->getVal( 'wpRegexBlockedAddress', $wgRequest->getVal( 'ip' ) ) );
			$this->mRegexBlockedExact = $wgRequest->getInt( 'wpRegexBlockedExact' );
			$this->mRegexBlockedCreation = $wgRequest->getInt( 'wpRegexBlockedCreation' );
			$this->mRegexBlockedExpire = htmlspecialchars( $wgRequest->getVal( 'wpRegexBlockedExpire' ) );
			$this->mRegexBlockedReason = htmlspecialchars( $wgRequest->getVal( 'wpRegexBlockedReason' ) );
		}

		/* Actions */
		switch( $this->mAction ) {
			case 'success_block':
				$wgOut->setSubTitle( wfMsg( 'regexblock-block-success' ) );
				$this->mMsg = wfMsgWikiHtml( 'regexblock-block-log', array( htmlspecialchars( $wgRequest->getVal( 'ip' ) ) ) );
				break;
			case 'success_unblock':
				$wgOut->setSubTitle( wfMsg( 'regexblock-unblock-success' ) );
				$this->mMsg = wfMsgWikiHtml( 'regexblock-unblock-log', array( htmlspecialchars( $wgRequest->getVal( 'ip' ) ) ) );
				break;
			case 'failure_unblock': 
				$this->mError = wfMsgWikiHtml( 'regexblock-unblock-error', array( htmlspecialchars( $wgRequest->getVal( 'ip' ) ) ) );
				break;
			case 'stats':
				$blckid = $wgRequest->getVal( 'blckid' );
				$this->showStatsList($blckid);
				break;	
			case 'submit':			
   				if ( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
   					$this->mAction = $this->doSubmit();
				}
				break;
			case 'delete': 
				$this->deleteFromRegexBlockList();
				break;
		}

		if ( !in_array( $this->mAction, array( 'submit', 'stats' ) ) ) {
			$this->showForm();
			unset($this->mError);
			unset($this->mMsg);
			$this->showRegexList();
		}
	}

	/**
	 * Show the form for blocking IPs / users
	 */
	private function showForm() {
		global $wgOut, $wgUser, $wgRequest;
		wfProfileIn( __METHOD__ );
   
		$token = htmlspecialchars( $wgUser->editToken() );
		$action = $this->mTitle->escapeLocalURL( "action=submit&".$this->makeListUrlParams() );
		$err = $this->mError;
		$msg = $this->mMsg;

		$expiries = RegexBlockData::getExpireValues();
		$regexBlockAddress = ( empty( $this->mRegexBlockedAddress ) && ( $wgRequest->getVal( 'ip' ) != null ) &&
			( $wgRequest->getVal( 'action' ) == null ) ) ? $wgRequest->getVal( 'ip' ) : $this->mRegexBlockedAddress;

		$wgOut->addHTML('<div style="float:left; clear:both; margin-left: auto; margin-right:auto">');
		if ( '' != $err ) {
			$wgOut->setSubtitle( wfMsgHtml( 'formerror' ) );
			$wgOut->addHTML('<h2 class="errorbox">'.$this->mError.'</h2>');
		} elseif ( $msg != '' ) {
			$wgOut->addHTML('<h2 class="successbox">'.$this->mMsg.'</h2>');
		}
		$wgOut->addHTML('</div><div style="clear:both; width:auto;">'.wfMsgExt('regexblock-help', 'parse').'</div>
		<fieldset style="width:90%; margin:auto;" align="center"><legend>'.wfMsg('regexblock-form-submit').'</legend>
		<form name="regexblock" method="post" action="'.$action.'">
		<table border="0">
		<tr>
		<td align="right">'.wfMsg('regexblock-form-username').'</td>
		<td align="left">
			<input tabindex="1" name="wpRegexBlockedAddress" id="wpRegexBlockedAddress" size="40" value="'.$regexBlockAddress.'" style="border: 1px solid #2F6FAB;" />
		</td>
		</tr>
		<tr>
		<td align="right">'.ucfirst( wfMsg('regexblock-form-reason') ).'</td>
		<td align="left">
			<input tabindex="2" name="wpRegexBlockedReason" id="wpRegexBlockedReason" size="40" value="'.$this->mRegexBlockedReason.'" style="border: 1px solid #2F6FAB;" />
		</td>
		</tr>
		<tr>
		<td align="right">'.ucfirst( wfMsg('regexblock-form-expiry') ).'</td>
		<td align="left">
			<select name="wpRegexBlockedExpire" id="wpRegexBlockedExpire" tabindex="3" style="border: 1px solid #2F6FAB;">'."\n");
		foreach( $expiries as $k => $v ) {
			$selected = htmlspecialchars( ($k == $this->mRegexBlockedExpire) ) ? ' selected="selected"' : '';
			$wgOut->addHTML('<option value="'.htmlspecialchars($v).'"'.$selected.'>'.htmlspecialchars($v).'</option>');
		}
		$wgOut->addHTML('</select>');
		$checkExact = htmlspecialchars( ($this->mRegexBlockedExact) ) ? 'checked="checked"' : '';
		$checkCreation = htmlspecialchars( ($this->mRegexBlockedCreation) ) ? 'checked="checked"' : '';
		$wgOut->addHTML('</td></tr>
						<tr>
						<td align="right">&nbsp;</td>
						<td align="left">
							<input type="checkbox" tabindex="4" name="wpRegexBlockedExact" id="wpRegexBlockedExact" value="1" '.$checkExact.' />
							<label for="wpRegexBlockedExact">'. ucfirst( wfMsg('regexblock-form-match') ) .'</label>
						</td></tr>
						<tr>
						<td align="right">&nbsp;</td>
						<td align="left">
							<input type="checkbox" tabindex="5" name="wpRegexBlockedCreation" id="wpRegexBlockedCreation" value="1" '.$checkCreation.' />
							<label for="wpRegexBlockedCreation">'.wfMsg('regexblock-form-account-block').'</label>
						</td></tr>
						<tr>
						<td align="right">&nbsp;</td>
						<td align="left">
							<input tabindex="6" name="wpRegexBlockedSubmit" type="submit" value="'.wfMsg('regexblock-form-submit').'" style="color:#2F6FAB;" />
						</td></tr></table>
						<input type="hidden" name="wpEditToken" value="'.$token.'" />
						</form>
						</fieldset>
						<br />');
		wfProfileOut( __METHOD__ );
	}

	/**
	 * Show the list of regex blocks - current and expired, along with some controls (unblock, statistics, etc.)
	 */
	private function showRegexList() {
		global $wgOut, $wgRequest, $wgMemc, $wgLang, $wgUser, $wgContLang;

		wfProfileIn( __METHOD__ );

		$action = $this->mTitle->escapeLocalURL( $this->makeListUrlParams() );
		$action_unblock = $this->mTitle->escapeLocalURL( "action=delete&".$this->makeListUrlParams() );

		$regexData = new RegexBlockData();
		$this->numResults = $regexData->fetchNbrResults();
		$filter = 'filter=' . urlencode($this->mFilter) . '&rfilter=' . urlencode($this->mRegexFilter);
		$pager = wfViewPrevNext( $this->mOffset, $this->mLimit, $wgContLang->specialpage( 'RegexBlock' ), $filter, ($this->numResults - $this->mOffset) <= $this->mLimit );

		/* allow display by specific blockers only */
		$blockers = $regexData->fetchBlockers();
		$blocker_list = array();
		if ( !empty( $blockers ) ) {
			$blocker_list = $regexData->getBlockersData($this->mFilter, $this->mRegexFilter, $this->mLimit, $this->mOffset);
		}

		/* make link to statistics */
		$mSkin = $wgUser->getSkin();
		$wgOut->addHTML('<br /><b>'.wfMsg('regexblock-currently-blocked').'</b>
					<p>'.$pager.'</p>
					<form name="regexlist" method="get" action="'.htmlspecialchars($action).'">
					'.wfMsg('regexblock-view-blocked').'
					<select name="filter">
					<option value="">'.wfMsg('regexblock-view-all').'</option>');

		if ( is_array( $blockers ) ) {
			foreach( $blockers as $id => $blocker ) {
				$sel = htmlspecialchars( ( $this->mFilter == $blocker ) ) ? ' selected="selected"' : '';
				$wgOut->addHTML('<option value="'.htmlspecialchars($blocker).'"'. $sel.'>'.htmlspecialchars($blocker).'</option>');
			}
		}

		$wgOut->addHTML('</select>&nbsp;'.wfMsg('regexblock-regex-filter').'<input type="text" name="rfilter" id="regex_filter" value="'.$this->mRegexFilter.'" />
					<input type="submit" value="'.wfMsg('regexblock-view-go').'">
					</form>
					<br /><br />');
		if ( !empty( $blockers ) ) {
			$wgOut->addHTML('<ul>');
			$loop = 0;
			$comma = " <b>&#183;</b> "; // the spaces here are intentional
			foreach( $blocker_list as $id => $row ) { 
				$loop++;
				$color_expire = "%s";
				if ( 'infinite' == $row['expiry'] ) {
					$row['expiry'] = wfMsg('regexblock-view-block-infinite');
				} else {
					if ( wfTimestampNow() > $row['expiry'] ) {
						$color_expire = "<span style=\"color:#DC143C\">%s</span>";
					}
					$row['expiry'] = sprintf($color_expire, $wgLang->timeanddate( wfTimestamp( TS_MW, $row['expiry'] ), true ));
				}

				$exact_match = (($row['exact_match']) ? wfMsg('regexblock-view-match') : wfMsg('regexblock-view-regex'));
				$create_block = ($row['create_block']) ? wfMsg('regexblock-view-account') : '';
				$reason = '<i>'.$row['reason'].'</i>';
				$stats_link = $mSkin->makeKnownLinkObj( $this->mTitle, wfMsg('regexblock-view-stats'), 'action=stats&blckid=' . urlencode($row['blckid']));

				$wgOut->addHTML('<li style="border-bottom:1px dashed #778899; padding-bottom:2px;font-size:11px">
					<b><font style="color:#3B7F07; font-size:12px">'.$row['blckby_name'].'</font>'.$comma.$exact_match.$create_block.'</b>'.$comma.' 
					('.wfMsg('regexblock-view-block-by').': <b>'.$row['blocker'].'</b>, '.$reason.') '.wfMsg('regexblock-view-time', $row['time']).$comma.' 
					(<a href="'.$action_unblock.'&ip='.$row['ublock_ip'].'&blocker='.$row['ublock_blocker'].'">'.wfMsg('regexblock-view-block-unblock').'</a>) '.$comma.$row['expiry'].$comma.' ('.$stats_link.')
					</li>');
			}
			$wgOut->addHTML('</ul><br /><br /><p>'.$pager.'</p>');
		} else {
			$wgOut->addWikiMsg('regexblock-view-empty');
		}

		wfProfileOut( __METHOD__ );
	}

	private function makeListUrlParams( $no_limit = false ) {
		global $wgRequest;
		$pieces = array();
		if ( !$no_limit ) {
			$pieces[] = 'limit=' . $this->mLimit;
			$pieces[] = 'offset=' . $this->mOffset;
		}
		$pieces[] = 'filter=' . urlencode( $wgRequest->getVal( 'filter' ) );
		$pieces[] = 'rfilter=' . urlencode( $wgRequest->getVal( 'rfilter' ) );
		
		return implode( '&', $pieces );
	}

	/* On submit */
	private function doSubmit() {
		global $wgOut, $wgUser, $wgMemc;

		wfProfileIn( __METHOD__ );

		/* empty name */
		if ( strlen($this->mRegexBlockedAddress) == 0 ) {
			$this->mError = wfMsg('regexblock-form-submit-empty');
			wfProfileOut( __METHOD__ );
			return false;
		}

		/* castrate regexes */
		if ( RegexBlockData::isValidRegex($this->mRegexBlockedAddress) ) {
			$this->mError = wfMsg('regexblock-form-submit-regex');
			wfProfileOut( __METHOD__ );
			return false;
		}

		/* check expiry */
		if ( strlen($this->mRegexBlockedExpire) == 0 ) {
			$this->mError = wfMsg('regexblock-form-submit-expiry');
			wfProfileOut( __METHOD__ );
			return false;
		}

		if ( $this->mRegexBlockedExpire != 'infinite' ) {
			$expiry = strtotime( $this->mRegexBlockedExpire );
			if ( $expiry < 0 || $expiry === false ) {
				$this->mError = wfMsg( 'ipb_expiry_invalid' );
				wfProfileOut( __METHOD__ );
				return false;
			}
			$expiry = wfTimestamp( TS_MW, $expiry );
		} else {
			$expiry = $this->mRegexBlockedExpire;	
		}

		$result = RegexBlockData::blockUser($this->mRegexBlockedAddress, $expiry, $this->mRegexBlockedExact, $this->mRegexBlockedCreation, $this->mRegexBlockedReason);
		/* clear memcached */
		$uname = $wgUser->getName();
		RegexBlock::unsetKeys($this->mRegexBlockedAddress);

		wfProfileOut( __METHOD__ );
		
		/* redirect */
		$wgOut->redirect( $this->mTitle->getFullURL( 'action=success_block&ip=' .urlencode( $this->mRegexBlockedAddress )."&".$this->makeListUrlParams() ) );

		return;
	}

	/**
	 * Remove name or address from list - without confirmation
	 */
	private function deleteFromRegexBlockList() {
		global $wgOut, $wgRequest, $wgMemc, $wgUser;

		wfProfileIn( __METHOD__ );

		$ip = $wgRequest->getVal( 'ip' );
		$blocker = $wgRequest->getVal( 'blocker' );

		$result = RegexBlock::clearExpired( $ip, $blocker );

		wfProfileOut( __METHOD__ );
		if ( $result === true ) {
			$wgOut->redirect( $this->mTitle->getFullURL( 'action=success_unblock&ip='.urlencode($ip).'&'.$this->makeListUrlParams() ) );
		} else {
			$wgOut->redirect( $this->mTitle->getFullURL( 'action=failure_unblock&ip='.urlencode($ip).'&'.$this->makeListUrlParams() ) );
		}

		return;
	}

	/**
	 * Display some statistics when a user clicks stats link (&action=stats)
	 *
	 * @param $blckid Int: ID number of the block
	 */
	private function showStatsList( $blckid ) {
		global $wgOut, $wgLang, $wgUser, $wgContLang;

		wfProfileIn( __METHOD__ );

		$action = $this->mTitle->escapeLocalURL( $this->makeListUrlParams(true) );
		$skin = $wgUser->getSkin();

		$regexData = new RegexBlockData();
		$this->numStatResults = $regexData->fetchNbrStatResults($blckid);
		$filter = 'action=stats&filter=' . urlencode($this->mFilter) . '&blckid=' . urlencode($blckid);
		$pager = wfViewPrevNext($this->mOffset, $this->mLimit, $wgContLang->specialpage( 'RegexBlock' ), $filter, ($this->numStatResults - $this->mOffset) <= $this->mLimit );

		/* allow display by specific blockers only */
		$blockInfo = $regexData->getRegexBlockById($blckid);
		$stats_list = array();
		if ( !empty( $blockInfo ) && ( is_object( $blockInfo ) ) ) {
			$stats_list = $regexData->getStatsData($blckid, $this->mLimit, $this->mOffset);
		}

		$blocker_link = $skin->makeKnownLinkObj( $this->mTitle, $blockInfo->blckby_blocker, 'filter=' . urlencode($blockInfo->blckby_blocker) );
		$blockername_link = $skin->makeKnownLinkObj( $this->mTitle, $blockInfo->blckby_name, 'rfilter=' . urlencode($blockInfo->blckby_name) );

		$wgOut->addHTML('<h5>'.wfMsg('regexblock-stats-title').' <strong> '.$blockername_link.'</strong> ('.wfMsg('regexblock-view-block-by').': <b>'.$blocker_link.'</b>,&nbsp;<i>'.( ($blockInfo->blckby_reason) ? wfMsg('regexblock-form-reason') . $blockInfo->blckby_reason : wfMsg('regexblock-view-reason-default') ).'</i>)</h5><br />');
		if ( !empty( $stats_list ) ) {
			$wgOut->addHTML('<p>'.$pager.'</p><br /><ul>');
			foreach( $stats_list as $id => $row ) {
				$wgOut->addHTML('<li style="border-bottom:1px dashed #778899; padding-bottom:2px;font-size:11px">
					'.wfMsg('regexblock-match-stats-record', array($row->stats_match, $row->stats_user, htmlspecialchars($row->stats_dbname), $wgLang->timeanddate( wfTimestamp( TS_MW, $row->stats_timestamp ), true ), $row->stats_ip) ).'
					</li>');
			}
			$wgOut->addHTML('</ul><br /><p>'.$pager.'</p>');
		} else {
			$wgOut->addWikiMsg('regexblock-nodata-found');
		}

		wfProfileOut( __METHOD__ );
	}
}

/**
 * @class RegexBlockData
 * helper classes & functions
 * @author Bartek Łapiński
 * @author Piotr Molski
 */
class RegexBlockData {
	var $mNbrResults;

	public function __construct() {
		$this->mNbrResults = 0;
	}	

	/**
	 * Fetch number of all rows 
	 */
	public function fetchNbrResults() {
		global $wgMemc;

		wfProfileIn( __METHOD__ );

		$this->mNbrResults = 0;
		/* we use memcached here */
		$key = RegexBlock::memcKey( REGEXBLOCK_SPECIAL_KEY, REGEXBLOCK_SPECIAL_NUM_RECORD );
		$cached = $wgMemc->get( $key );

		if ( empty( $cached ) ) {
			$dbr = RegexBlock::getDB( DB_MASTER );

			$oRes = $dbr->select( REGEXBLOCK_TABLE,
				array("COUNT(*) AS cnt"),
				array("blckby_blocker <> ''"), 
				__METHOD__
			);

			if ( $oRow = $dbr->fetchObject( $oRes ) ) {
				$this->mNbrResults = $oRow->cnt;
			}
			$dbr->freeResult($oRes);
			$wgMemc->set($key, $this->mNbrResults, REGEXBLOCK_EXPIRE);
		} else {
			$this->mNbrResults = $cached;
		}

		wfProfileOut( __METHOD__ );
		return $this->mNbrResults;
	}

	public function getNbrResults() {
		return $this->mNbrResults;
	}

	/**
	 * Fetch names of all blockers and write them into select's options
	 *
	 * @return $blockers_array
	 */
	public function fetchBlockers() {
		return RegexBlock::getBlockers();
	}

	/**
	 *
	 * @param $current
	 * @param $username
	 * @param $limit
	 * @param $offset
	 * @return $blocker_list
	 */
	public function getBlockersData( $current = '', $username = '', $limit, $offset ) {
		global $wgLang, $wgUser;

		wfProfileIn( __METHOD__ );

		$blocker_list = array();
		/* get data and play with data */
		$dbr = RegexBlock::getDB( DB_MASTER );
		$conds = array("blckby_blocker <> ''");

		if ( !empty( $current ) ) {
			$conds = array("blckby_blocker = {$dbr->addQuotes($current)}");
		}

		if ( !empty( $username ) ) {
			$conds = array("blckby_name LIKE {$dbr->addQuotes('%'.$username.'%')}");
		}

		$oRes = $dbr->select( REGEXBLOCK_TABLE,
			array("blckby_id, blckby_name, blckby_blocker, blckby_timestamp, blckby_expire, blckby_create, blckby_exact, blckby_reason"),
			$conds,
			__METHOD__,
			array("LIMIT" => $limit, "OFFSET" => $offset, "ORDER BY" => "blckby_id desc")
		);

		while( $oRow = $dbr->fetchObject($oRes) ) {
			$ublock_ip = urlencode($oRow->blckby_name);
			$ublock_blocker = urlencode($oRow->blckby_blocker);
			$reason = ($oRow->blckby_reason) ? wfMsg('regexblock-form-reason') . $oRow->blckby_reason : wfMsg('regexblock-view-reason-default');
			$time = $wgLang->timeanddate( wfTimestamp( TS_MW, $oRow->blckby_timestamp ), true );

			/* put data to array */
			$blocker_list[] = array(
				'blckby_name' => $oRow->blckby_name,
				'exact_match' => $oRow->blckby_exact,
				'create_block' => $oRow->blckby_create,
				'blocker' => $oRow->blckby_blocker,
				'reason' => $reason,
				'time' => $time,
				'ublock_ip'	=> $ublock_ip,
				'ublock_blocker' => $ublock_blocker,
				'expiry' => $oRow->blckby_expire,
				'blckid' => $oRow->blckby_id
			);
		}
		$dbr->freeResult($oRes);

		wfProfileOut( __METHOD__ );
		return $blocker_list;
	}

	/**
	 * Fetch number of all stats rows
	 *
	 * @param $id Int: ID of the regexBlock entry (value of stats_blckby_id column in the REGEXBLOCK_STATS_TABLE database table)
	 * @return $nbrStats
	 */
	public function fetchNbrStatResults( $id ) {
		wfProfileIn( __METHOD__ );
		$nbrStats = 0;

		$dbr = RegexBlock::getDB( DB_SLAVE );
		$oRes = $dbr->select( REGEXBLOCK_STATS_TABLE,
			array("COUNT(*) AS cnt"),
			array("stats_blckby_id = '".intval($id)."'"),
			__METHOD__
		);

		if ( $oRow = $dbr->fetchObject($oRes) ) {
			$nbrStats = $oRow->cnt;
		}
		$dbr->freeResult($oRes);

		wfProfileOut( __METHOD__ );
		return $nbrStats;
	}

	/**
	 * Fetch all logs
	 *
	 * @param $id Int: ID of the regexBlock entry (value of stats_blckby_id column in the REGEXBLOCK_STATS_TABLE database table)
	 * @param $limit
	 * @param $offset
	 * @return $stats
	 */
	public function getStatsData( $id, $limit = 50, $offset = 0 ) {
		wfProfileIn( __METHOD__ );
		$stats = array();

		/* from database */
		$dbr = RegexBlock::getDB( DB_SLAVE );
		$conds = array("stats_blckby_id = '".intval($id)."'");
		$oRes = $dbr->select( REGEXBLOCK_STATS_TABLE,
			array("stats_blckby_id", "stats_user", "stats_blocker", "stats_timestamp", "stats_ip", "stats_match", "stats_dbname"),
			$conds,
			__METHOD__,
			array("LIMIT" => $limit, "OFFSET" => $offset, "ORDER BY" => "stats_timestamp DESC")
		);

		while( $oRow = $dbr->fetchObject($oRes) ) {
			$stats[] = $oRow;
		}
		$dbr->freeResult($oRes);

		wfProfileOut( __METHOD__ );
		return $stats;
	}

	/**
	 * Fetch record for selected identifier of regex block
	 *
	 * @param $id Int: ID of the regexBlock entry (value of blckby_id column in the REGEXBLOCK_STATS_TABLE database table)
	 * @return $record
	 */
	public function getRegexBlockById( $id ) {
		wfProfileIn( __METHOD__ );
		$record = null;

		$dbr = RegexBlock::getDB( DB_MASTER );
		$oRes = $dbr->select( REGEXBLOCK_TABLE,
			array("blckby_id", "blckby_name", "blckby_blocker", "blckby_timestamp", "blckby_expire", "blckby_create", "blckby_exact", "blckby_reason"),
			array("blckby_id = '".intval($id)."'"),
			__METHOD__
		);

		if( $oRow = $dbr->fetchObject($oRes) ) {
			$record = $oRow;
		}
		$dbr->freeResult($oRes);
		
		wfProfileOut( __METHOD__ );
		return $record;
	}

	/**
	 * Insert a block record to the REGEXBLOCK_TABLE database table
	 *
	 * @param $address
	 * @param $expiry Mixed: expiry time of the block
	 * @param $exact
	 * @param $creation
	 * @param $reason Mixed: given block reason, which will be displayed to the regexblocked user
	 */
	static public function blockUser( $address, $expiry, $exact, $creation, $reason ) {
		global $wgUser;

		wfProfileIn( __METHOD__ );
		/* make insert */
		$dbw = RegexBlock::getDB( DB_MASTER );
		$name = $wgUser->getName();

		$oRes = $dbw->replace( REGEXBLOCK_TABLE,
			array( 'blckby_id', 'blckby_name' ),
			array(
				'blckby_id' => 'null',
				'blckby_name' => $address, 
				'blckby_blocker' => $name, 
				'blckby_timestamp' => wfTimestampNow(),
				'blckby_expire' => $expiry,
				'blckby_exact' => intval($exact),
				'blckby_create' => intval($creation),
				'blckby_reason' => $reason
			),
			__METHOD__
		);

		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Gets and returns the expiry time values
	 *
	 * @return array Array of block expiry times
	 */
	static public function getExpireValues() {
		$expiry_values = explode( ",", wfMsg('regexblock-expire-duration') );
		$expiry_text = array('1 hour', '2 hours', '4 hours', '6 hours', '1 day', '3 days', '1 week', '2 weeks', '1 month', '3 months', '6 months', '1 year', 'infinite');

		if ( !function_exists('array_combine') ) {
			function array_combine($a, $b) {
				$out = array();
				foreach( $a as $k => $v ) {
					$out[$v] = $b[$k];
				}
				return $out;
			}
		}

		return array_combine($expiry_text, $expiry_values);
	}

	/**
	 * Check that the given regex is valid
	 *
	 * @param $text Mixed: regular expression to be tested for validity
	 */
	static function isValidRegex( $text ) {
		return ( sprintf( "%s", @preg_match("/{$text}/", 'regex') ) === '' );
	}	
}