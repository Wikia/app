<?php

class SpecialGlobalUsers extends SpecialPage {

	function __construct() {
		wfLoadExtensionMessages('SpecialCentralAuth');
		parent::__construct( 'GlobalUsers' );
	}

	function execute( $par ) {
		global $wgOut, $wgRequest, $wgContLang;
		$this->setHeaders();

		$pg = new GlobalUsersPager();

		if( $par ) {
			$pg->setGroup( $par );
		}
		if( $rqGroup = $wgRequest->getVal( 'group' ) ) {
			$pg->setGroup( $rqGroup );
		}
		if( $rqUsername = $wgContLang->ucfirst( $wgRequest->getVal( 'username' ) ) ) {
			$pg->setUsername( $rqUsername );
		}

		$wgOut->addHTML( $pg->getPageHeader() );
		$wgOut->addHTML( $pg->getNavigationBar() );
		$wgOut->addHTML( '<ul>' . $pg->getBody() . '</ul>' );
		$wgOut->addHTML( $pg->getNavigationBar() );
	}
}

class GlobalUsersPager extends UsersPager {
	private $mGroup, $mUsername;

	function __construct() {
		parent::__construct();
		$this->mDb = CentralAuthUser::getCentralSlaveDB();
	}

	function setGroup( $group = '' ) {
		if( !$group ) {
			$this->mGroup = false;
			return;
		}
		$groups = array_keys( $this->getAllGroups() );
		if( in_array( $group, $groups ) ) {
			$this->mGroup = $group;
		} else {
			$this->mGroup = false;
		}
	}

	function setUsername( $username = '' ) {
		if( !$username ) {
			$this->mUsername = false;
			return;
		}
		$this->mUsername = $username;
	}

	function getIndexField() {
		return 'gu_name';
	}
	
	function getQueryInfo() {
		$localwiki = wfWikiID();
		$conds = array( 'gu_hidden' => 0 );

		if( $this->mGroup )
			$conds['gug_group'] = $this->mGroup;

		if( $this->mUsername )
			$conds[] = 'gu_name >= ' . $this->mDb->addQuotes( $this->mUsername );

		return array(
			'tables' => " (globaluser LEFT JOIN localuser ON gu_name = lu_name AND lu_wiki = '{$localwiki}') LEFT JOIN global_user_groups ON gu_id = gug_user ",
			'fields' => array( 'gu_id', 'gu_name', 'gu_locked', 'lu_attached_method', 'COUNT(gug_group) AS gug_numgroups', 'MAX(gug_group) AS gug_singlegroup'  ),
			'conds' => $conds,
			'options' => array( 'GROUP BY' => 'gu_name' ),
		);
	}

	function formatRow( $row ) {
		$user = htmlspecialchars( $row->gu_name );
		$info = array();
		if( $row->gu_locked )
			$info[] = wfMsgHtml( 'centralauth-listusers-locked' );
		if( $row->lu_attached_method ) {
			$userPage = Title::makeTitle( NS_USER, $row->gu_name );
			$text = wfMsgHtml( 'centralauth-listusers-attached' );
			$info[] = $this->getSkin()->makeLinkObj( $userPage, $text );
		} else {
			$info[] = wfMsgHtml( 'centralauth-listusers-nolocal' );
		}
		$groups = $this->getUserGroups( $row );
		if( $groups ) {
			$info[] = $groups;
		}
		$info = implode( ', ', $info );
		return '<li>' . wfSpecialList( $user, $info ) . '</li>';
	}

	function getBody() {
		if (!$this->mQueryDone) {
			$this->doQuery();
		}
		$batch = new LinkBatch;

		$this->mResult->rewind();

		while ( $row = $this->mResult->fetchObject() ) {
			$batch->addObj( Title::makeTitleSafe( NS_USER, $row->gu_name ) );
		}
		$batch->execute();
		$this->mResult->rewind();
		return AlphabeticPager::getBody();
	}

	function getUserGroups( $row ) {
		if( !$row->gug_numgroups )
			return false;
		if( $row->gug_numgroups == 1 ) {
			return self::buildGroupLink( $row->gug_singlegroup );
		}
		$result = $this->mDb->select( 'global_user_groups', 'gug_group', array( 'gug_user' => $row->gu_id ), __METHOD__ );
		$rights = array();
		while( $row2 = $this->mDb->fetchObject( $result ) ) 
			$rights[] = self::buildGroupLink( $row2->gug_group );
		return implode( ', ', $rights );
	}

	function getAllGroups() {
		$result = array();
		foreach( CentralAuthUser::availableGlobalGroups() as $group ) {
			$result[$group] = User::getGroupName( $group );
		}
		return $result;
	}
}
