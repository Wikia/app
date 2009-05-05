<?php
/**
 * Protect against register_globals vulnerabilities.
 * This line must be present before any global variable is referenced.
 */
if( !defined( 'MEDIAWIKI' ) )
	die();

class TextRegex extends SpecialPage {
	var $action;

	/**
	* Constructor
	*/
	function __construct() {
		parent::__construct( 'TextRegex', 'textregex' );
		wfLoadExtensionMessages( 'TextRegex' );
	}

	/**
	 * Show the special page
	 *
	 * @param $par Mixed: parameter passed to the page or null
	 */
	function execute( $subpage ) {
		global $wgOut, $wgUser, $wgRequest, $wgLang;

		if ( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			return;
		}
		if ( !$wgUser->isAllowed( 'textregex' ) ) {
			$this->displayRestrictionError();
			return;
		}
		
		$this->action = $wgRequest->getVal( 'action' );
		$this->mBlockedRegex = $wgRequest->getVal( 'wpBlockedRegex',  $wgRequest->getVal( 'text' ) );

		$wgOut->setPageTitle( wfMsgHtml( 'textregex-page-title' ) );

		$subpage = $wgLang->lc(trim($subpage));
		$oTextRegexList = new TextRegexList( $subpage );
		$oTextRegexForm = new TextRegexForm( $oTextRegexList, $subpage, $this->mBlockedRegex );
		$db_conn = DB_SLAVE;
		if ( empty($subpage) ) {
			if ( $this->action == 'addsubpage' && $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
				$oTextRegexForm->selectSubpage();
			} else {
				$oTextRegexForm->showSubpages('');
			}
		} else if ( $this->action == 'stats' ) {
			$id = htmlspecialchars( $wgRequest->getVal( 'id' ) );
			$oTextRegexList->showStatsList( $id );
		} else {
			if ( $this->action == 'success_block' ) {
				$wgOut->setSubTitle( wfMsg( 'textregex-block-succ' ) );
				$wgOut->addHTML(wfMsgExt('textregex-block-message', 'parse', htmlspecialchars($this->mBlockedRegex) ));
				$db_conn = DB_MASTER;
				$oTextRegexList->unsetKeys();
				$oTextRegexForm->showForm('');
			} elseif ( $this->action == 'success_unblock' ) {
				$wgOut->setSubTitle( wfMsg( 'textregex-unblock-succ' ) );
				$wgOut->addHTML(wfMsgExt('textregex-unblock-message', 'parse', htmlspecialchars($this->mBlockedRegex)) );
				$db_conn = DB_MASTER;
				$oTextRegexList->unsetKeys();
				$oTextRegexForm->showForm('');
			} elseif ( $this->action == 'failure_unblock' ) {
				$id = htmlspecialchars( $wgRequest->getVal( 'id' ) );
				$db_conn = DB_MASTER;
				$oTextRegexList->unsetKeys();				
				$oTextRegexForm->showForm( wfMsg( 'textregex-error-unblocking', $id ) );
			} else if ( $wgRequest->wasPosted() && ($this->action == 'submit') && $wgUser->matchEditToken( $wgRequest->getVal( 'wpEditToken' ) ) ) {
				$oTextRegexForm->doSubmit();
			} else if ( $this->action == 'delete' ) {
				$oTextRegexList->deleteFromList();
				$oTextRegexList->unsetKeys();				
			} else {
				$oTextRegexForm->showForm( '' );
			}
			$oTextRegexList->showList( '', $db_conn );
		}
	}
}

/* the list of blocked phrases */
class TextRegexList {
	var $numResults = 0;
	var $subList = "";
	var $limit = 50;
	var $offset = 0;
	var $oTitle;
	var $trId;

	/* constructor */
	function __construct ( $par ) {
		global $wgRequest;

		$this->subList = $par;
		list( $this->limit, $this->offset ) = $wgRequest->getLimitOffset();

		$this->oTitle = SpecialPage::getTitleFor( 'TextRegex', $par );
		$this->trId = $wgRequest->getVal( 'id' );
	}

	/* wrapper for GET values */
	public function getListBits() {
		return implode( '&', 
			array(
				"limit=" . $this->limit,
				"offset=" . $this->offset,
			)
		);
	}

	public function getMemcKey() {
		global $wgMemc;
		return wfMemcKey( 'textRegex', $this->subList);
	}

	public function getMemcAllKey() {
		global $wgMemc;
		return wfMemcKey( 'textRegex', $this->subList, 'all' );
	}

	/* useful for cleaning the memcached keys */
	public function unsetKeys() {
		global $wgMemc;
		$wgMemc->delete( $this->getMemcKey() );
		$wgMemc->delete( $this->getMemcAllKey() );
	}

	/**
	 * Output list of blocked expressions
	 *
	 * @param $err string: error message
	 */
	function showList( $err, $db_conn = DB_SLAVE ) {
		wfProfileIn( __METHOD__ );
		global $wgOut, $wgRequest, $wgLang;

		$action = $action_unblock = "";
		$regexList = $this->getMemcData();
		#---
		$action = $this->oTitle->escapeLocalURL( $this->getListBits() );
		$action_unblock = $this->oTitle->escapeLocalURL( 'action=delete&' . $this->getListBits() );
		$action_stats = $this->oTitle->escapeLocalURL( 'action=stats&' . $this->getListBits() );
		if ( empty($regexList) ) {
			$dbr = wfGetDBExt( $db_conn );
			$res = $dbr->select ( 
				"`dataware`.`text_regex`", 
				'tr_id,	tr_text, tr_timestamp, tr_user, tr_subpage',
				array('tr_subpage' => $this->subList), 
				__METHOD__, 
				array( 'LIMIT' => $this->limit, 'OFFSET' => $this->offset ) 
			);
			$regexList = array();
			while ( $row = $res->fetchObject() ) {
				$time = $wgLang->timeanddate( wfTimestamp( TS_MW, $row->tr_timestamp ), true );
				
				$regexList[] = array (
					"text" 			=> $row->tr_text,
					"id" 			=> $row->tr_id,
					"timestamp" 	=> $time,
					"user"			=> $row->tr_user,
					"subpage"		=> $row->tr_subpage,
					"err"			=> $err
				);
			}
			$res->free();
			$this->setMemcData($regexList);
		}
		
		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"oTitle" 			=> $this->oTitle,
			"sPrevNext" 		=> $this->showPrevNext( $wgOut, 0 ),
			"regexList"			=> $regexList,
			"action_unblock"	=> $action_unblock,
			"action"			=> $action,
			"action_stats"		=> $action_stats
		) );
		#---
		$wgOut->addHtml($oTmpl->execute("textregex-list"));
		wfProfileOut( __METHOD__ );
		
		return ;
	}

	/* remove from list - without confirmation */
	function deleteFromList($regexText) {
		wfProfileIn( __METHOD__ );
		global $wgOut, $wgRequest, $wgUser;
		/* info */
		$oRegexCore = new TextRegexCore($this->subList, $this->trId);
		$oRegexInfo = $oRegexCore->getOneRegex();
		/* delete */
		$dbw = wfGetDBExt( DB_MASTER );
		$dbw->delete( 
			"`dataware`.`text_regex`",
			array( 'tr_id' => $this->trId ), 
			__METHOD__ 
		);
		
		if ( $dbw->affectedRows() ) {
			/* success  */
			wfProfileOut( __METHOD__ );
			$wgOut->redirect( $this->oTitle->getFullURL( 'action=success_unblock&text='.urlencode($oRegexInfo->tr_text).'&'.$this->getListBits() ) );
		} else {
			wfProfileOut( __METHOD__ );
			$wgOut->redirect( $this->oTitle->getFullURL( 'action=failure_unblock&text='.urlencode($oRegexInfo->tr_text).'&'.$this->getListBits() ) );
		}
	}

	/**
	 * get data from memcache
	 */
	function getMemcData() {
		wfProfileIn( __METHOD__ );
		global $wgMemc;

		/* we use memcached here */
		$key = $this->getMemcKey();
		$cached = $wgMemc->get( $key );
		$results = array();
		if ( !empty( $cached ) ) {
			$results = $cached;
		}
		wfProfileOut( __METHOD__ );
		return $results;
	}

	/*
	 * set data in memcache
	 */
	function setMemcData( $data ) {
		wfProfileIn( __METHOD__ );
		global $wgMemc;

		/* we use memcached here */
		$key = $this->getMemcKey();
		$wgMemc->set( $key, $data, 3600 * 24 );
		wfProfileOut( __METHOD__ );
		return true;
	}

	/**
	 * Validate the given regex
	 * This was originally the SimplifiedRegex extension
	 *
	 * @param $text Regex to be validated
	 * @return False if exceptions were found, otherwise true
	 */
	static function validateRegex( $text ) {
		try {
			$test = @preg_match("/{$text}/", 'Whatever');
			if( !is_int($test) ) {
				throw new Exception("error!");
			}
		}
		catch( Exception $e ) {
			return false;
		}
		return true;
	}

	/* on success */
	function showSuccess() {
		global $wgOut, $wgRequest;
		$wgOut->setPageTitle( wfMsg( 'textregex-page-title-success' ) );
		$wgOut->setSubTitle( wfMsg( 'textregex-unblock-succ' ) );
		$wgOut->addWikiMsg( 'textregex-unblock-message', $wgRequest->getVal( 'text' ) );
	}

	/* init for showprevnext */
	function showPrevNext( &$out, $display = 1 ) {
		global $wgContLang;
		$html = wfViewPrevNext(
			$this->offset,
			$this->limit,
			$wgContLang->specialpage( 'TextRegex/'.$this->subList ),
			'',
			($this->numResults - $this->offset) <= $this->limit
		);
		$text = '<p>' . $html . '</p>';
		if ($display == 1) {
			$out->addHTML( $text );
		} 
		return $text;
	}

    public function showStatsList($regex_id) {
        global $wgOut, $wgLang, $wgUser;
        global $wgContLang;

        wfProfileIn( __METHOD__ );

        $regexData = new TextRegexCore( $this->subList, $regex_id );
        $regexInfo = $regexData->getOneRegex();
        $numStatResults = $regexData->fetchNbrStatResults();
        #---
        if ( !empty($regexInfo) ) {
			$regexStats = array();
			if ($numStatResults > 0) {
				$regexStats = $regexData->getRegexStats();
			}
			$filter = 'action=stats&id=' . urlencode($regex_id);
			$pager = wfViewPrevNext(
				$this->offset, 
				$this->limit, 
				$wgContLang->specialpage( 'TextRegex/'.$this->subList ), 
				$filter, 
				($numStatResults - $this->offset) <= $this->limit 
			);

			$action = $this->oTitle->escapeLocalURL( $this->getListBits() );
			$wgOut->setSubTitle( wfMsgExt( 'textregex-return-mainpage', 'parse', $action ) );

			$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
			$oTmpl->set_vars( array(
				"pager"         => $pager,
				"stats_list"    => $regexStats,
				"lang"          => $wgLang,
				"skin"          => $wgUser->getSkin(),
				"oTitle"      	=> $this->oTitle,
				"regexInfo"		=> $regexInfo,
				"action" 		=> $action,
				"numStatResults"=> $numStatResults
			) );
			$wgOut->addHTML( $oTmpl->execute("textregex-stats") );
		} else {
			$wgOut->addHTML( wfMsg('textregex-invalid-regexid') );
		}

        wfProfileOut( __METHOD__ );
        return 1;
    }
}

/* the form for blocking phrases */
class TextRegexForm {
	var $mBlockedRegex;
	var $oTitle;
	var $subPage;
	var $action;
	var $oTRList;

	/* constructor */
	function TextRegexForm( $oTRList, $subpage, $mBlockedRegex ) {
		global $wgRequest, $wgUser;
		$this->mBlockedRegex = $mBlockedRegex; 
		if ( !empty($subpage) ) {
			$this->oTitle = SpecialPage::getTitleFor( 'TextRegex', $subpage );
		} else {
			$this->oTitle = SpecialPage::getTitleFor( 'TextRegex' );
		}
		$this->subPage = $subpage;
		$this->mAction = $wgRequest->getVal( 'action' );
		$this->mToken = htmlspecialchars( $wgUser->editToken() );
		$this->oTRList = $oTRList;
	}

	/* output */
	function showForm( $err ) {
		global $wgOut, $wgUser, $wgRequest;

		$action = $this->oTitle->escapeLocalURL( "action=submit&".$this->oTRList->getListBits() );

		$blockedRegex = $this->mBlockedRegex;
		if ( $this->mAction == 'submit' ) {
			$blockedRegex = htmlspecialchars( $this->mBlockedRegex );
		}

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"oTitle" 		=> $this->oTitle,
			"blockedRegex"	=> $blockedRegex,
			"token"			=> $this->mToken,
			"subpage"		=> $this->subPage,
			"action"		=> $action,
			"err"			=> $err
		) );
		#---
		$wgOut->addHtml($oTmpl->execute("textregex-form"));
		return 1;
	}

	/* on submit */
	function doSubmit() {
		wfProfileIn( __METHOD__ );
		global $wgOut, $wgUser, $wgMemc;

		/* empty name */
		if ( strlen($this->mBlockedRegex) == 0 ) {
			$this->showForm( wfMsgHtml( 'textregex-empty-regex' ) );
			wfProfileOut( __METHOD__ );
			return;
		}
		/* validate expression */
		if ( !$simple_regex = TextRegexList::validateRegex( $this->mBlockedRegex ) ) {
			$this->showForm( wfMsgHtml( 'textregex-invalid-regex' ) );
			wfProfileOut( __METHOD__ );
			return;
		}

		/* make insert */
		$dbw = wfGetDBExt( DB_MASTER );
		$iUser = $wgUser->getId();
		$timestamp = wfTimestampNow();

		$dbw->insert(
			"`dataware`.`text_regex`",
			array(
				'tr_text' => $this->mBlockedRegex,
				'tr_timestamp' => $timestamp,
				'tr_user' => intval($iUser),
				'tr_subpage' => $this->subPage
			),
			__METHOD__,
			array( 'IGNORE' )
		);

		/* duplicate entry */
		if ( !$dbw->affectedRows() ) {
			$this->showForm( wfMsgHtml( 'textregex-already-added', $this->mBlockedRegex ) );
			wfProfileOut( __METHOD__ );
			return;
		}
		
		/* redirect */
		wfProfileOut( __METHOD__ );
		$wgOut->redirect( $this->oTitle->getFullURL( 'action=success_block&text=' .$this->mBlockedRegex.'&'.$this->oTRList->getListBits() ) );
	}
	
	function showSubpages($err) {
		global $wgOut;
		
		wfProfileIn( __METHOD__ );
		$regexCore = new TextRegexCore( $this->subPage, 0 );
		$subpages = $regexCore->getAllSubpages();

		$action = $this->oTitle->escapeLocalURL( "action=addsubpage" );

		$oTmpl = new EasyTemplate( dirname( __FILE__ ) . "/templates/" );
		$oTmpl->set_vars( array(
			"oTitle" 		=> $this->oTitle,
			"subpages"		=> $subpages,
			"token"			=> $this->mToken,
			"action"		=> $action,
			"err"			=> $err
		) );
		#---
		$wgOut->addHtml($oTmpl->execute("textregex-subpages"));
		wfProfileOut( __METHOD__ );
		return 1;
	}
	
	function selectSubpage() {
		global $wgRequest, $wgOut;
		$__subpage = $wgRequest->getVal( 'wpBlockedRegexList' );
		if ( empty($__subpage) ) {
			$__subpage = $wgRequest->getVal('wpBlockedRegexListName');
		}
		if (!empty($__subpage)) {
			$oNewTitle = SpecialPage::getTitleFor( 'TextRegex', $__subpage );
		} else {
			$oNewTitle = $this->oTitle;
		}
		$wgOut->redirect( $oNewTitle->getFullURL( $this->oTRList->getListBits() ) );
	}
}

class TextRegexCore {
	var $subPage;
	var $id;
	/* constructor */
	function TextRegexCore( $subpage, $id ) {
		$this->subPage = $subpage;
		$this->id = $id;
	}
	
	public function getRegexes( $db_conn = DB_SLAVE ) {
		wfProfileIn( __METHOD__ );
		global $wgMemc, $wgUser, $wgLang;

		$oTRList = new TextRegexList($this->subPage);
		$key = $oTRList->getMemcAllKey();
		$regexList = array();
		$cached = $wgMemc->get($key) ;
		if ( !$cached ) {
			$dbr = wfGetDBExt( $db_conn );
			$res = $dbr->select ( 
				"`dataware`.`text_regex`", 
				'tr_id,	tr_text, tr_timestamp, tr_user, tr_subpage',
				array('tr_subpage' => $this->subPage), 
				__METHOD__ 
			);
			$regexList = array();
			while ( $row = $res->fetchObject() ) {
				$time = $wgLang->timeanddate( wfTimestamp( TS_MW, $row->tr_timestamp ), true );
				
				$regexList[] = array (
					"text" 				=> $row->tr_text,
					"id" 				=> $row->tr_id,
					"timestamp" 		=> $time,
					"user"				=> $row->tr_user,
					"subpage"			=> $row->tr_subpage,
				);
			}
			$wgMemc->set($key, $regexList, 3600 * 24) ; 
			$dbr->freeResult ($res) ;
		} else {
			$regexList = $cached;
		}	
		wfProfileOut( __METHOD__ );
		return $regexList;
	}

	public function getAllSubpages() {
		wfProfileIn( __METHOD__ );
		global $wgMemc, $wgUser ;

		$dbr = wfGetDBExt( DB_SLAVE );
		$res = $dbr->select ( 
			"`dataware`.`text_regex`", 
			'distinct(tr_subpage)',
			"", 
			__METHOD__ 
		);
		$regexList = array();
		while ( $row = $res->fetchObject() ) {
			$regexList[] = $row->tr_subpage;
		}
		$dbr->freeResult ($res) ;
		wfProfileOut( __METHOD__ );
		return $regexList;
	}

	public function getOneRegex() {
		wfProfileIn( __METHOD__ );
		global $wgMemc, $wgUser ;

		$dbr = wfGetDBExt( DB_SLAVE );
		$row = $dbr->selectRow ( 
			"`dataware`.`text_regex`", 
			'tr_id,	tr_text, tr_timestamp, tr_user, tr_subpage',
			array("tr_id" => $this->id), 
			__METHOD__ 
		);
		wfProfileOut( __METHOD__ );
		return $row;
	}
	
	public function setID( $id ) {
		$this->id = $id;
	}
	
	public function setStats( $text, $comment ) {
		global $wgUser;
		wfProfileIn( __METHOD__ );
		/* make insert */
		$dbw = wfGetDBExt( DB_MASTER );
		$iUser = $wgUser->getId();
		$timestamp = wfTimestampNow();

		$data = array (
			'trs_tr_id' => $this->id,
			'trs_timestamp' => $timestamp,
			'trs_user' => intval($iUser),
			'trs_text' => $text,
			'trs_comment' => $comment
		);
		$dbw->insert( "`dataware`.`text_regex_stats`", $data, __METHOD__, array( 'IGNORE' ) );
		$dbw->commit();
		$lastId = $dbw->insertId();
		wfProfileIn( __METHOD__ );
		
		return $lastId;
	}

	public function getRegexStats() {
		wfProfileIn( __METHOD__ );
		global $wgMemc, $wgUser, $wgLang;

		$dbr = wfGetDBExt( DB_SLAVE );
		$res = $dbr->select ( 
			"`dataware`.`text_regex_stats`", 
			'trs_tr_id, trs_timestamp, trs_user, trs_text, trs_comment',
			array('trs_tr_id' => $this->id), 
			__METHOD__,
			array("ORDER BY" => 'trs_timestamp desc')
		);
		$regexStats = array();
		while ( $row = $res->fetchObject() ) {
			$time = $wgLang->timeanddate( wfTimestamp( TS_MW, $row->trs_timestamp ), true );
			
			$regexStats[] = array (
				"text" 				=> $row->trs_text,
				"id" 				=> $row->trs_tr_id,
				"regex_id"			=> $this->id,
				"timestamp" 		=> $time,
				"user"				=> $row->trs_user,
				"comment"			=> $row->trs_comment,
			);
		}
		$dbr->freeResult ($res) ;

		wfProfileOut( __METHOD__ );
		return $regexStats;
	}

    /* fetch number of all stats rows */
    public function fetchNbrStatResults() {

        wfProfileIn( __METHOD__ );
        $nbrStats = 0;

		$dbr = wfGetDBExt( DB_SLAVE );
        $oRes = $dbr->select(
			"`dataware`.`text_regex_stats`", 
            array("COUNT(*) as cnt"),
			array('trs_tr_id' => $this->id), 
            __METHOD__
        );

        if ($oRow = $dbr->fetchObject($oRes)) {
            $nbrStats = $oRow->cnt;
        }
        $dbr->freeResult($oRes);

        wfProfileOut( __METHOD__ );
        return $nbrStats;
    }

    /* check if text contain "bad" words (if yes, put comment to the stats table) */
	public function isAllowedText ($text, $comment = "") {
        wfProfileIn( __METHOD__ );

        if ( !is_array($text) ) {
        	$aWordsInText = array($text);
		} else {
	        $aWordsInText = $text;
		}
		$aBadWords = $this->getRegexes( DB_MASTER );
				
		#$sBadWords
		if ( !empty($aBadWords) && !empty($aWordsInText) ) {
			#--- check every word in text
			foreach ($aWordsInText as $sWord) {
				$sWord = trim($sWord);
				#--- check every regex
				foreach ($aBadWords as $badWord) {
					if ( empty($badWord) && !is_array($badWord) ) continue;
					$badWordTxt = trim($badWord['text']);
					$badWordId = intval($badWord['id']);
					if ( @preg_match("/{$badWordTxt}/i", $sWord, $m) ) {
						#--- match
						$this->setID($badWordId);
						$this->setStats($sWord, $comment);
						#--- 
						wfProfileOut( __METHOD__ );
						return false;
					}
				}
			}
		}

		wfProfileOut( __METHOD__ );
		return true;
	}

}
