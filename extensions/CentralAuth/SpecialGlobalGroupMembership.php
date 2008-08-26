<?php

/**
  *
  * Equivalent of Special:Userrights for global groups.
  * @addtogroup extensions
  */
  
class SpecialGlobalGroupMembership extends UserrightsPage {
	var $mGlobalUser;
	function SpecialGlobalGroupMembership() {
		SpecialPage::SpecialPage( 'GlobalGroupMembership' );
		wfLoadExtensionMessages('SpecialCentralAuth');
		
		global $wgUser;
		$this->mGlobalUser = CentralAuthUser::getInstance( $wgUser );
	}
	
	/**
	 * Output a form to allow searching for a user
	 */
	function switchForm() {
		global $wgOut, $wgScript, $wgRequest;
		
		$knownwiki = $wgRequest->getVal( 'wpKnownWiki' );
		$knownwiki = $knownwiki ? $knownwiki : wfWikiId();
		
		// Generate wiki selector
		$selector = new XmlSelect('wpKnownWiki', 'wpKnownWiki', $knownwiki);
		
		foreach (CentralAuthUser::getWikiList() as $wiki) {
			$selector->addOption( $wiki );
		}
		
		$wgOut->addHTML(
			Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript, 'name' => 'uluser', 'id' => 'mw-userrights-form1' ) ) .
			Xml::hidden( 'title',  $this->getTitle() ) .
			Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', array(), wfMsg( 'userrights-lookup-user' ) ) .
			Xml::inputLabel( wfMsg( 'userrights-user-editname' ), 'user', 'username', 30, $this->mTarget ) . ' <br/>' .
			Xml::label( wfMsgExt('centralauth-globalgrouppermissions-knownwiki', array('parseinline')), 'wpKnownWiki' ) .
			$selector->getHTML() . '<br/>' .
			Xml::submitButton( wfMsg( 'editusergroup' ) ) .
			Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' ) . "\n"
		);
	}
	
	function changeableGroups() {
		global $wgUser;
		
		## Should be a global user
		if (!$this->mGlobalUser->exists() || !$this->mGlobalUser->isAttached()) {
			return array();
		}
		
		$allGroups = CentralAuthUser::availableGlobalGroups();
		
		## Permission MUST be gained from global rights.
		if ( $this->mGlobalUser->hasGlobalPermission( 'globalgroupmembership' ) ) {
			return array( 'add' => $allGroups, 'remove' =>  $allGroups);
		} else {
			return array();
		}
	}
	
	function fetchUser( $username ) {
		global $wgOut, $wgUser, $wgRequest;
		
		$knownwiki = $wgRequest->getVal('wpKnownWiki');
		
		$user = CentralAuthGroupMembershipProxy::newFromName( $username );
	
		if( !$user ) {
			$wgOut->addWikiMsg( 'nosuchusershort', $username );
			return null;
		} elseif (!$wgRequest->getCheck( 'saveusergroups' ) && !$user->attachedOn($knownwiki)) {
			$wgOut->addWikiMsg( 'centralauth-globalgroupmembership-badknownwiki', $username, $knownwiki );
			return null;
		}
	
		return $user;
	}
	
	protected static function getAllGroups() {
		return CentralAuthUser::availableGlobalGroups();
	}
	
	protected function showLogFragment( $user, $output ) {
		$pageTitle = Title::makeTitleSafe( NS_USER, $user->getName());
		$output->addHtml( Xml::element( 'h2', null, LogPage::logName( 'gblrights' ) . "\n" ) );
		LogEventsList::showLogExtract( $output, 'gblrights', $pageTitle->getPrefixedText() );
	}
	
	function addLogEntry( $user, $oldGroups, $newGroups ) {
		global $wgRequest;
		
		$log = new LogPage( 'gblrights' );

		$log->addEntry( 'usergroups',
			$user->getUserPage(),
			$wgRequest->getText( 'user-reason' ),
			array(
				$this->makeGroupNameList( $oldGroups ),
				$this->makeGroupNameList( $newGroups )
			)
		);
	}
}
