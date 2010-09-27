<?php
/**
 * @package MediaWiki
 * @subpackage SpecialPage
 * @author Chris Stafford <uberfuzzy@wikia-inc.com> for Wikia.com
 * @version: 1.0
 */

if ( !defined( 'MEDIAWIKI' ) ) { 
	echo "This is MediaWiki extension and cannot be used standalone.\n"; exit( 1 ) ; 
}

class CloakCheck extends SpecialPage {
	var $mMinAge = "1 month";
	var $mMinEC = "100";
	
	function  __construct() {
		parent::__construct( "CloakCheck"  /*class*/, '' /*restriction*/);
		wfLoadExtensionMessages("CloakCheck");
	}
	
	public function execute( $subpage ) {
		global $wgRequest, $wgUser, $wgOut;

		if( $wgUser->isAnon() ) {
			$this->displayRestrictionError();
			return;
		}
		if( $wgUser->isBlocked() ) {
			$wgOut->blockedPage();
			return;
		}

		/**
		 * initial output
		 */

		
		$this->mTitle = Title::makeTitle( NS_SPECIAL, 'CloakCheck' );
		$wgOut->setPageTitle( wfMsg('cloakcheck') );
		$wgOut->setRobotpolicy( 'noindex,nofollow' );
		$wgOut->setArticleRelated( false );

		#staff can see other people, users cant
		if( !$wgUser->isAllowed( 'staff' ) ) {
			#user is user, show just button
			$this->isStaff = false;
			$this->mTarget = $wgUser->getName();
		} else {
			#user is staff, allow to use full form/subpage
			$this->isStaff = true;
			$this->mTarget = $wgRequest->getText('username', $subpage);
		}

		/**
		 * show form
		 */
			$this->doForm();
		if( $wgRequest->wasPosted() ) {
			$this->process();
		}
	}

	private function doForm() {
		global $wgOut;

		$wgOut->addHTML("<form action=\"". $this->mTitle->getFullURL() ."\" method='post'>\n");
		
		if( $this->isStaff ) {
			$wgOut->addHTML( wfMsg('cloakcheck-form-username') . ": <input name='username' value=\"". htmlspecialchars($this->mTarget) ."\" />\n");
			$wgOut->addHTML("<input type='submit' value='". wfMsg('cloakcheck-form-check') ."' />\n");
		} else {
			$wgOut->addHTML("<input type='submit' value='". wfMsg('cloakcheck-form-check-self') ."' />\n");
		}
		$wgOut->addHTML("</form>\n");
	}

	private function process() {
		global $wgOut, $wgRequest;

		$wgOut->addHTML("<hr/>\n");

		$username = trim( $this->mTarget );
		if( $username == '' ) {
			$wgOut->addWikiMsg('cloakcheck-process-empty');
			return;
		}

		$user = User::newFromName( $username );
		if( $user === null || $user->getId() === 0 ) {
			$wgOut->addWikiMsg('cloakcheck-process-notexist');
			return;
		}

		$wgOut->addWikiMsg('cloakcheck-process-username', $username);

		/***** account age *****/
		$uReg = strtotime( $user->getRegistration() );
		$cutoff = strtotime( $this->mMinAge );
		if( $uReg < $cutoff ) {
			$wgOut->addHTML( Wikia::successbox( wfMsg('cloakcheck-process-accountage-yes') ) );
		} else {
			$wgOut->addHTML( Wikia::errorbox( wfMsg('cloakcheck-process-accountage-no') ) );
		}
		
		/***** email *****/
		if( $user->isEmailConfirmed() ){
			$wgOut->addHTML( Wikia::successbox( wfMsg('cloakcheck-process-emailconf-yes') ) );
		} else {
			$wgOut->addHTML( Wikia::errorbox( wfMsg('cloakcheck-process-emailconf-no') ) );
		}
		
		/***** global edits *****/
		if( $this->getGlobalEdits( $user->getId() ) >= $this->mMinEC ){
			$wgOut->addHTML( Wikia::successbox( wfMsg('cloakcheck-process-edits-yes') ) );
		} else {
			$wgOut->addHTML( Wikia::errorbox( wfMsg('cloakcheck-process-edits-no') ) );
		}
	}
	
	private function getGlobalEdits( $uid ) {
		global $wgStatsDB;
		$nscount = array();

		$dbs = wfGetDB(DB_SLAVE, array(), $wgStatsDB);
		$res = $dbs->select(
			array( 'city_user_edits' ),
			array( 'ue_edit_namespace as namespace', 'ue_edit_count as count' ),
			array(
				'ue_user_id' => $uid
			),
			__METHOD__
		);

		$total = 0;
		while( $row = $dbs->fetchObject( $res ) ) {
			$total += $row->count;
		}

		return $total;
	}
}
