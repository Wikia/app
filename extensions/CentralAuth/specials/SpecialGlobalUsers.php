<?php

class SpecialGlobalUsers extends SpecialPage {
	function __construct() {
		parent::__construct( 'GlobalUsers' );
	}

	function execute( $par ) {
		global $wgContLang;
		$this->setHeaders();

		$pg = new GlobalUsersPager( $this->getContext(), $par );

		if ( $par ) {
			$pg->setGroup( $par );
		}
		$rqGroup = $this->getRequest()->getVal( 'group' );
		if ( $rqGroup ) {
			$pg->setGroup( $rqGroup );
		}
		$rqUsername = $wgContLang->ucfirst( $this->getRequest()->getVal( 'username' ) );
		if ( $rqUsername ) {
			$pg->setUsername( $rqUsername );
		}

		$this->getOutput()->addHTML( $pg->getPageHeader() );
		$this->getOutput()->addHTML( $pg->getNavigationBar() );
		$this->getOutput()->addHTML( '<ul>' . $pg->getBody() . '</ul>' );
		$this->getOutput()->addHTML( $pg->getNavigationBar() );
	}
}

class GlobalUsersPager extends UsersPager {
	protected $requestedGroup = false, $requestedUser;

	function __construct( IContextSource $context = null, $par = null ) {
		parent::__construct( $context, $par );
		$this->mDb = CentralAuthUser::getCentralSlaveDB();
	}

	/**
	 * @param $group string
	 * @return mixed
	 */
	function setGroup( $group = '' ) {
		if ( !$group ) {
			$this->requestedGroup = false;
			return;
		}
		$this->requestedGroup = $group;
	}

	/**
	 * @param $username string
	 * @return mixed
	 */
	function setUsername( $username = '' ) {
		if ( !$username ) {
			$this->requestedUser = false;
			return;
		}
		$this->requestedUser = $username;
	}

	/**
	 * @return string
	 */
	function getIndexField() {
		return 'gu_name';
	}

	/**
	 * @return array
	 */
	function getDefaultQuery() {
		$query = parent::getDefaultQuery();
		if ( !isset( $query['group'] ) && $this->requestedGroup ) {
			$query['group'] = $this->requestedGroup;
		}
		return $this->mDefaultQuery = $query;
	}

	/**
	 * @return array
	 */
	function getQueryInfo() {
		$localwiki = wfWikiID();
		$conds = array( 'gu_hidden' => CentralAuthUser::HIDDEN_NONE );

		if ( $this->requestedGroup ) {
			$conds['gug_group'] = $this->requestedGroup;
		}

		if ( $this->requestedUser ) {
			$conds[] = 'gu_name >= ' . $this->mDb->addQuotes( $this->requestedUser );
		}

		return array(
			'tables' => " (globaluser LEFT JOIN localuser ON gu_name = lu_name AND lu_wiki = '{$localwiki}') LEFT JOIN global_user_groups ON gu_id = gug_user ",
			'fields' => array( 'gu_id', 'gu_name', 'gu_locked', 'lu_attached_method', 'COUNT(gug_group) AS gug_numgroups', 'MAX(gug_group) AS gug_singlegroup'  ),
			'conds' => $conds,
			'options' => array( 'GROUP BY' => 'gu_name' ),
		);
	}

	/**
	 * Formats a row
	 * @param object $row The row to be formatted for output
	 * @return string HTML li element with username and info about this user
	 */
	function formatRow( $row ) {
		$user = htmlspecialchars( $row->gu_name );
		$info = array();
		if ( $row->gu_locked ) {
			$info[] = wfMsg( 'centralauth-listusers-locked' );
		}
		if ( $row->lu_attached_method ) {
			$info[] = wfMsg( 'centralauth-listusers-attached', $row->gu_name );
		} else {
			$info[] = wfMsg( 'centralauth-listusers-nolocal' );
		}
		$groups = $this->getUserGroups( $row );

		if ( $groups ) {
			$info[] = $groups;
		}
		$info = $this->getLanguage()->commaList( $info );
		return Html::rawElement( 'li', array(), wfMsgExt( 'centralauth-listusers-item', array('parseinline'), $user, $info ) );
	}

	/**
	 * @return String
	 */
	function getBody() {
		if ( !$this->mQueryDone ) {
			$this->doQuery();
		}
		$batch = new LinkBatch;

		$this->mResult->rewind();

		foreach ( $this->mResult as $row ) {
			$batch->addObj( Title::makeTitleSafe( NS_USER, $row->gu_name ) );
		}
		$batch->execute();
		$this->mResult->rewind();
		return AlphabeticPager::getBody();
	}

	/**
	 * @param $row
	 * @return bool|string
	 */
	protected function getUserGroups( $row ) {
		if ( !$row->gug_numgroups ) {
			return false;
		}
		if ( $row->gug_numgroups == 1 ) {
			return User::makeGroupLinkWiki( $row->gug_singlegroup, User::getGroupMember( $row->gug_singlegroup ) );
		}
		$result = $this->mDb->select( 'global_user_groups', 'gug_group', array( 'gug_user' => $row->gu_id ), __METHOD__ );
		$rights = array();
		foreach ( $result as $row2 ) {
			$rights[] = User::makeGroupLinkWiki( $row2->gug_group, User::getGroupMember( $row2->gug_group ) );
		}
		return implode( ', ', $rights );
	}

	/**
	 * @return array
	 */
	public function getAllGroups() {
		$result = array();
		foreach ( CentralAuthUser::availableGlobalGroups() as $group ) {
			$result[$group] = User::getGroupName( $group );
		}
		return $result;
	}
}
