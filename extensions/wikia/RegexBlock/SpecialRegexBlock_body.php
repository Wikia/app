<?php
/**
 *
 * @package MediaWiki
 * @addtopackage SpecialPage
 */

/**
 * The list of blocked names/addresses
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Bartek, Tomasz Klim, Piotr Molski <moli@wikia.com> for Wikia.com
 * @version: $Id$
 */

if ( !defined( 'MEDIAWIKI' ) ) {
    echo "This is MediaWiki extension and cannot be used standalone.\n";
    exit( 1 ) ;
}

class RegexBlockForm extends SpecialPage 
{
    var $mRegexUnblockedAddress;
    var $numResults = 0;
    var $numStatResults = 0;
    var $mPosted, $mAction;
    var $mFilter, $mRegexFilter;
    var $mLimit;
    var $mOffset;
    var $mError, $mMsg;
    
    /* constructor */
    function __construct () {
        global $wgRegexBlockMessages, $wgMessageCache;
        
        /* read messages from language's file */
        foreach( $wgRegexBlockMessages as $key => $value ) {
            $wgMessageCache->addMessages( $wgRegexBlockMessages[$key], $key );
        }

        $this->mPosted = false;
        $this->mAction = "";
        $this->mFilter = $this->mRegexFilter = "";
        $this->mError = $this->mMsg = "";

        parent::__construct( "RegexBlock", "regexblock" ); 
    }
    
	public function execute( $subpage ) {
        global $wgUser, $wgOut, $wgRequest;
        wfLoadExtensionMessages("RegexBlock");
        
        if ( $wgUser->isBlocked() ) {
            $wgOut->blockedPage();
            return;
        }

        if ( wfReadOnly() ) {
            $wgOut->readOnlyPage();
            return;
        }

        if ( !$wgUser->isAllowed( 'regexblock' ) ) {
            $this->displayRestrictionError();
            return;
        }

        #--- initial output
        $this->mTitle = Title::makeTitle( NS_SPECIAL, 'RegexBlock' );
        $wgOut->setRobotpolicy( 'noindex,nofollow' );
        $wgOut->setPageTitle( wfMsg("regexblock_title") );
        $wgOut->setArticleRelated( false );

        $this->mPosted = $wgRequest->wasPosted();
        $this->mAction = $wgRequest->getVal( 'action' );
        $this->mFilter = $wgRequest->getVal( 'filter' );
        $this->mRegexFilter = $wgRequest->getVal( 'rfilter' );
        
        list( $this->mLimit, $this->mOffset ) = $wgRequest->getLimitOffset() ;

        $this->mRegexBlockedAddress = $this->mRegexBlockedExact = $this->mRegexBlockedCreation = $this->mRegexBlockedExpire = $this->mRegexBlockedReason = "";
        if ( $this->mAction == "submit" ) {
            $this->mRegexBlockedAddress = htmlspecialchars( $wgRequest->getVal( 'wpRegexBlockedAddress',  $wgRequest->getVal('ip') ) );
            $this->mRegexBlockedExact = $wgRequest->getInt ('wpRegexBlockedExact') ;
            $this->mRegexBlockedCreation = $wgRequest->getInt ('wpRegexBlockedCreation') ;
            $this->mRegexBlockedExpire = htmlspecialchars( $wgRequest->getVal ('wpRegexBlockedExpire') );
            $this->mRegexBlockedReason = htmlspecialchars( $wgRequest->getVal ('wpRegexBlockedReason') );
        }

        /* actions */
        switch($this->mAction) {
            case 'success_block':
                $wgOut->setSubTitle( wfMsg('regexblock_success_block') );
                $this->mMsg = wfMsgWikiHtml( 'regexblock_msg_blocked', array(htmlspecialchars($wgRequest->getVal('ip'))) );
		        break;
	        case 'success_unblock': 
                $wgOut->setSubTitle( wfMsg('regexblock_success_unblock') );
                $this->mMsg = wfMsgWikiHtml( 'regexblock_msg_unblocked', array(htmlspecialchars($wgRequest->getVal('ip'))) );
		        break;
	        case 'failure_unblock': 
	            $this->mError = wfMsgWikiHtml( 'regexblock_error_unblocked', array(htmlspecialchars($wgRequest->getVal('ip'))) );
		        break;
		    case 'stats' :
		        $blckid = $wgRequest->getVal( 'blckid' );
                $this->showStatsList($blckid);
		        break;    
            case 'submit':    	    
   	            if ( $wgRequest->wasPosted() && $wgUser->matchEditToken( $wgRequest->getVal ('wpEditToken') ) ) {
   	                $this->mAction = $this->doSubmit();
                }
		        break;
            case 'delete': 
		        $this->deleteFromRegexBlockList();
		        break;
        }
        
        if (!in_array($this->mAction, array('submit', 'stats'))) {
            $this->showForm();
            unset($this->mError);
            unset($this->mMsg);
            $this->showRegexList();
        }
    }
    
    private function showForm() {
        global $wgOut, $wgUser, $wgRequest ;
        wfProfileIn( __METHOD__ );
    
        $token = htmlspecialchars( $wgUser->editToken() );
        $titleObj = Title::makeTitle( NS_SPECIAL, 'RegexBlock' );
        $action = $titleObj->escapeLocalURL( "action=submit" )."&".$this->makeListUrlParams();
    
        $expiries = RegexBlockData::getExpireValues();
    				
    				$regexBlockAddress = (empty($this->mRegexBlockedAddress) && ($wgRequest->getVal('ip') != null) && ($wgRequest->getVal('action') == null)) ? $wgRequest->getVal('ip') : $this->mRegexBlockedAddress;
    				
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "err"                   => $this->mError,
            "msg"                   => $this->mMsg,
            "action"                => $action,
            "token"                 => $token,
            "out"                   => $wgOut,
            "sel_blocker"           => $this->mFilter,
            "expiries"              => $expiries,
            "mRegexBlockedAddress"  => $regexBlockAddress,
            "mRegexBlockedExact"    => $this->mRegexBlockedExact,
            "mRegexBlockedCreation" => $this->mRegexBlockedCreation,
            "mRegexBlockedExpire"   => $this->mRegexBlockedExpire,
            "mRegexBlockedReason"   => $this->mRegexBlockedReason
        ) );
        $wgOut->addHTML( $oTmpl->execute("page-form") );

        wfProfileOut( __METHOD__ );
    }
    
    private function showRegexList() {
        global $wgOut, $wgRequest, $wgMemc, $wgLang, $wgUser;
        global $wgContLang;

        wfProfileIn( __METHOD__ );

        $titleObj = Title::makeTitle( NS_SPECIAL, 'RegexBlock' );
        $action = $titleObj->escapeLocalURL("") ."?".$this->makeListUrlParams();
        $action_unblock = $titleObj->escapeLocalURL("action=delete") ."&".$this->makeListUrlParams();
        
        $regexData = new RegexBlockData();
        $this->numResults = $regexData->fetchNbrResults();
        $filter = 'filter=' . urlencode($this->mFilter) . '&rfilter=' . urlencode($this->mRegexFilter);
        $pager = wfViewPrevNext($this->mOffset, $this->mLimit, $wgContLang->specialpage( 'RegexBlock' ), $filter, ($this->numResults - $this->mOffset) <= $this->mLimit );

        /* allow display by specific blockers only */
        $blockers =  $regexData->fetchBlockers();
        $blocker_list = array();
        if (!empty($blockers)) {
            $blocker_list = $regexData->getBlockersData($this->mFilter, $this->mRegexFilter, $this->mLimit, $this->mOffset);
        }
        
        /* make link to statistics */
        $mSkin = $wgUser->getSkin();
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "pager"         => $pager,
            "titleObj"      => $titleObj,
            "urls"          => $this->makeListUrlParams(true),
            "action"        => $action,
            "action_unblock"=> $action_unblock,
            "sel_blocker"   => $this->mFilter,
            "regex_filter"  => $this->mRegexFilter,
            "blockers"      => $blockers,
            "blocker_list"  => $blocker_list,
            "lang"          => $wgLang,
            "skin"          => $mSkin
        ) );
        $wgOut->addHTML( $oTmpl->execute("page-output") );

        wfProfileOut( __METHOD__ );
    }

    private function makeListUrlParams($no_limit = false) {
        global $wgRequest;
        $pieces = array();
        if (!$no_limit) {
            $pieces[] = 'limit=' . $this->mLimit;
            $pieces[] = 'offset=' . $this->mOffset;
        }
        $pieces[] = 'filter=' . urlencode( $wgRequest->getVal('filter') );
        $pieces[] = 'rfilter=' . urlencode( $wgRequest->getVal('rfilter') );
        
        return implode( '&', $pieces ) ;
    }
    
    /* on submit */
    private function doSubmit() {
        global $wgOut, $wgUser, $wgMemc ;

        wfProfileIn( __METHOD__ );

        /* empty name */
        if ( strlen($this->mRegexBlockedAddress) == 0 ) {
            $this->mError = wfMsg('regexblock_give_username_ip');
            wfProfileOut( __METHOD__ );
            return false;
        }

        /* castrate regexes */
        if (RegexBlockData::isValidRegex($this->mRegexBlockedAddress) ) {
            $this->mError = wfMsg('regexblock_invalid_expr');
            wfProfileOut( __METHOD__ );
            return false;
        }
        
        /* check expiry */
        if ( strlen ($this->mRegexBlockedExpire) == 0 ) {
            $this->mError = wfMsg('regexblock_invalid_period');
            wfProfileOut( __METHOD__ );
            return false;
        }

        if ($this->mRegexBlockedExpire != 'infinite') {
            $expiry = strtotime( $this->mRegexBlockedExpire );
            if ( $expiry < 0 || $expiry === false ) {
                $this->mError = wfMsg( 'ipb_expiry_invalid' );
                wfProfileOut( __METHOD__ );
                return false;
            }
            $expiry = wfTimestamp( TS_MW, $expiry );
        } else {
            $expiry = $this->mRegexBlockedExpire ;    
        }

        $result = RegexBlockData::blockUser($this->mRegexBlockedAddress, $expiry, $this->mRegexBlockedExact, $this->mRegexBlockedCreation, $this->mRegexBlockedReason);
		/* clear memcache */
		$uname = $wgUser->getName();
		wfRegexBlockUnsetKeys($this->mRegexBlockedAddress);

        wfProfileOut( __METHOD__ );
        
        /* redirect */
        $titleObj = Title::makeTitle( NS_SPECIAL, 'RegexBlock' ) ;
        $wgOut->redirect( $titleObj->getFullURL( 'action=success_block&ip=' .urlencode( $this->mRegexBlockedAddress )."&".$this->makeListUrlParams() ) ) ;

        return;
    }
    
    /* remove name or address from list - without confirmation */
    private function deleteFromRegexBlockList() {
        global $wgOut, $wgRequest, $wgMemc, $wgUser ;

        wfProfileIn( __METHOD__ );
        
        $result = false;
        $ip = $wgRequest->getVal('ip');
        $blocker = $wgRequest->getVal('blocker') ;
        $titleObj = Title::makeTitle( NS_SPECIAL, 'Regexblock' ) ;

        if (function_exists('wfRegexBlockClearExpired')) {
            $result = wfRegexBlockClearExpired($ip, $blocker);
        } else {
            /* delete */
            $dbw =& wfGetDB( DB_MASTER );
            
            $dbw->delete(
                    wfSharedTable(REGEXBLOCK_TABLE), 
                    array("blckby_name = {$dbw->addQuotes($ip)}"),
                    __METHOD__
                );
                
            if ( $dbw->affectedRows() ) {
                /* success, remember to delete cache key  */
                wfRegexBlockUnsetKeys( $ip );
                $result = true;
            }
        }

        wfProfileOut( __METHOD__ );
        if ($result === true) {
            $wgOut->redirect( $titleObj->getFullURL( 'action=success_unblock&ip='.urlencode($ip).'&'.$this->makeListUrlParams() ) );
        } else {
            $wgOut->redirect( $titleObj->getFullURL( 'action=failure_unblock&ip='.urlencode($ip).'&'.$this->makeListUrlParams() ) );
        }
        
        return;
    }
    
    /* statistic */
    private function showStatsList($blckid) {
        global $wgOut, $wgLang, $wgUser;
        global $wgContLang;

        wfProfileIn( __METHOD__ );

        $titleObj = Title::makeTitle( NS_SPECIAL, 'RegexBlock' );
        $action = $titleObj->escapeLocalURL("") ."?".$this->makeListUrlParams(true);
        
        $regexData = new RegexBlockData();
        $this->numStatResults = $regexData->fetchNbrStatResults($blckid);
        $filter = 'action=stats&filter=' . urlencode($this->mFilter) . '&blckid=' . urlencode($blckid);
        $pager = wfViewPrevNext($this->mOffset, $this->mLimit, $wgContLang->specialpage( 'RegexBlock' ), $filter, ($this->numStatResults - $this->mOffset) <= $this->mLimit );

        /* allow display by specific blockers only */
        $blockInfo =  $regexData->getRegexBlockById($blckid);
        $stats_list = array();
        if ( !empty($blockInfo) && (is_object($blockInfo)) ) {
            $stats_list = $regexData->getStatsData($blckid, $this->mLimit, $this->mOffset);
        }
        
        $oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
        $oTmpl->set_vars( array(
            "pager"         => $pager,
            "action"        => $action,
            "stats_list"    => $stats_list,
            "lang"          => $wgLang,
            "skin"          => $wgUser->getSkin(),
            "blockInfo"     => $blockInfo,
            "titleObj"      => $titleObj,
        ) );
        $wgOut->addHTML( $oTmpl->execute("page-stats") );

        wfProfileOut( __METHOD__ );
    }
}
