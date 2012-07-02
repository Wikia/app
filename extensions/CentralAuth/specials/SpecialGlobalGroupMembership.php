<?php
/**
 * Equivalent of Special:Userrights for global groups.
 *
 * @ingroup Extensions
 */

class SpecialGlobalGroupMembership extends UserrightsPage {
	var $mGlobalUser;

	function __construct() {
		SpecialPage::__construct( 'GlobalGroupMembership' );

		$this->mGlobalUser = CentralAuthUser::getInstance( $this->getUser() );
	}

	/**
	 * @return String
	 */
	function getSuccessURL() {
		$knownWikis = $this->mGlobalUser->listAttached();
		$title = $this->getTitle( $this->mTarget );
		return $title->getFullURL( 'wpKnownWiki=' . urlencode( $knownWikis[0] ) );
	}

	/**
	 * Output a form to allow searching for a user
	 */
	function switchForm() {
		global $wgScript;

		$knownwiki = $this->getRequest()->getVal( 'wpKnownWiki' );
		$knownwiki = $knownwiki ? $knownwiki : wfWikiId();

		// Generate wiki selector
		$selector = new XmlSelect( 'wpKnownWiki', 'wpKnownWiki', $knownwiki );

		foreach ( CentralAuthUser::getWikiList() as $wiki ) {
			$selector->addOption( $wiki );
		}

		$this->getOutput()->addModuleStyles( 'mediawiki.special' );
		$this->getOutput()->addHTML(
			Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript, 'name' => 'uluser', 'id' => 'mw-userrights-form1' ) ) .
			Html::hidden( 'title',  $this->getTitle() ) .
			Xml::openElement( 'fieldset' ) .
			Xml::element( 'legend', array(), wfMsg( 'userrights-lookup-user' ) ) .
			Xml::inputLabel( wfMsg( 'userrights-user-editname' ), 'user', 'username', 30, $this->mTarget ) . ' <br />' .
			Xml::label( wfMsg( 'centralauth-globalgrouppermissions-knownwiki' ), 'wpKnownWiki' ) . ' ' .
			$selector->getHTML() . '<br />' .
			Xml::submitButton( wfMsg( 'editusergroup' ) ) .
			Xml::closeElement( 'fieldset' ) .
			Xml::closeElement( 'form' ) . "\n"
		);
	}

	/**
	 * @return array
	 */
	function changeableGroups() {
		# # Should be a global user
		if ( !$this->mGlobalUser->exists() || !$this->mGlobalUser->isAttached() ) {
			return array();
		}

		$allGroups = CentralAuthUser::availableGlobalGroups();

		# # Permission MUST be gained from global rights.
		if ( $this->mGlobalUser->hasGlobalPermission( 'globalgroupmembership' ) ) {
			# specify addself and removeself as empty arrays -- bug 16098
			return array( 'add' => $allGroups, 'remove' =>  $allGroups, 'add-self' => array(), 'remove-self' => array() );
		} else {
			return array( 'add' => array(), 'remove' =>  array(), 'add-self' => array(), 'remove-self' => array() );
		}
	}

	/**
	 * @param $username
	 * @return Status
	 */
	function fetchUser( $username ) {
		$knownwiki = $this->getRequest()->getVal( 'wpKnownWiki' );

		$user = CentralAuthGroupMembershipProxy::newFromName( $username );

		if ( !$user ) {
			return Status::newFatal( 'nosuchusershort', $username );
		} elseif ( !$this->getRequest()->getCheck( 'saveusergroups' ) && !$user->attachedOn( $knownwiki ) ) {
			return Status::newFatal( 'centralauth-globalgroupmembership-badknownwiki',
					$username, $knownwiki );
		}

		return Status::newGood( $user );
	}

	/**
	 * @static
	 * @return array
	 */
	protected static function getAllGroups() {
		return CentralAuthUser::availableGlobalGroups();
	}

	/**
	 * @param $user User
	 * @param $output OutputPage
	 */
	protected function showLogFragment( $user, $output ) {
		$pageTitle = Title::makeTitleSafe( NS_USER, $user->getName() );
		$output->addHTML( Xml::element( 'h2', null, LogPage::logName( 'gblrights' ) . "\n" ) );
		LogEventsList::showLogExtract( $output, 'gblrights', $pageTitle->getPrefixedText() );
	}

	/**
	 * @param $user User
	 * @param $oldGroups
	 * @param $newGroups
	 * @param $reason
	 */
	function addLogEntry( $user, $oldGroups, $newGroups, $reason ) {
		$log = new LogPage( 'gblrights' );

		$log->addEntry( 'usergroups',
			$user->getUserPage(),
			$reason,
			array(
				$this->makeGroupNameList( $oldGroups ),
				$this->makeGroupNameList( $newGroups )
			)
		);
	}
}
