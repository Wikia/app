<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Piotr Molski <moli@wikia-inc.com> for Wikia.com
 * @version: 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This is MediaWiki extension and cannot be used standalone.\n"; exit( 1 ) ;
}

class Multiwikiedit extends MultiTask {
	private $mType = 'Multiwikiedit';
	private $mRights = 'multiwikiedit';
	/**
	 * constructor
	 */
	function  __construct() {
		parent::__construct( $this->mType  /*class*/, $this->mRights );

		$this->mMainForm = "main-edit";
		$this->mPreviewForm = "confirm-form";
		$this->mFinishForm = "row-list";

		$this->mTaskClass = "MultiWikiEditTask";
	}

	/**
	 * execute
	 *
	 * execute special page
	 *
	 * @access public
	 *
	 * @return none
	 */
	public function execute( $subpage ) {
		global $wgUser, $wgOut, $wgRequest;

		if ( !$this->checkRestriction() ) {
			return;
		}

		/* */
		$this->mTitle = Title::makeTitle( NS_SPECIAL, $this->mType );
		$this->parseParams();

		$wgOut->setPageTitle( wfMsg('multiwikiedit_title') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		if ( $this->mAction == 'success' ) {
			// do something?
		}
		else if ( ( $wgRequest->wasPosted() ) && ( $this->mAction == 'submit' ) && ( $wgUser->matchEditToken( $this->mEditToken ) ) ) {
			if ( !$this->mPage ) {
				$this->showForm( wfMsg('multiwikiedit_no_page') );
			}
			elseif ( $this->mText == '' ) {
				$this->showForm( wfMsg('multiwikiedit_add_text') ) ;
			}
			else {
				$wgOut->setSubTitle ( wfMsg('multiwikiedit_processing') . wfMsg( 'word-separator' ) . wfMsg ('multiwikiedit_from_form') );
				$this->doSubmit(0);
			}
		}
		else if ( ( $wgRequest->wasPosted() ) && ( $this->mAction == 'addTask' ) && ( $wgUser->matchEditToken( $this->mEditToken ) ) ) {
			if ( !$this->mPage ) {
				$this->showForm( wfMsg('multiwikiedit_no_page') );
			}
			elseif ( $this->mText == '' ) {
				$this->showForm( wfMsg('multiwikiedit_add_text') ) ;
			}
			else {
				$wgOut->setSubTitle ( wfMsg('multiwikiedit_processing') . wfMsg( 'word-separator' ) . wfMsg ('multiwikiedit_from_form') );
				$this->doSubmit(1);
			}
		}
		else {
			$this->showForm() ;
		}
	}

	/**
	 * makeDefaultTaskParams
	 *
	 * make params of tasks
	 *
	 * @access private
	 *
	 * @return none (set local variables)
	 */
	protected function makeDefaultTaskParams($lang = '', $cat = '', $city_id = 0) {
		global $wgUser;

		$this->mTaskParams['mode'] = $this->mMode;
		$this->mTaskParams['page'] = $this->mPage;
		$this->mTaskParams['wikis'] = $this->mWikiInbox;
		$this->mTaskParams['range'] = $this->mRange;
		$this->mTaskParams['text'] = $this->mText;
		$this->mTaskParams['summary'] = $this->mSummary;
		$this->mTaskParams['lang'] = $lang;
		$this->mTaskParams['cat'] = $cat;
		$this->mTaskParams['selwikia'] = $city_id;

		$this->mTaskParams['flags'] = array(
			$this->mMinorEdit,
			$this->mBotEdit,
			$this->mAutoSummary,
			$this->mNoRecentChanges,
			$this->mNewOnly
		);
		$this->mTaskParams['edittoken'] = $this->mEditToken;
		$this->mTaskParams['user'] = $this->mUser;

		$this->mTaskParams['admin'] = $wgUser->getName();

		$this->mTaskParams['page'] = array();

		$this->explodePages();
	}

	/**
	 * getBackUrl
	 *
	 * display url to main page of special page
	 *
	 * @access public
	 *
	 * @return string
	 */
	protected function getBackUrl() {
		$sk = RequestContext::getMain()->getSkin();
		return "<br/><br/>". wfMsg('multiwikiedit_link_back', $sk->makeKnownLinkObj($this->mTitle, '<b>' . wfMsg( 'multitasks-link-back-label' ) . '</b>') );
	}
}
