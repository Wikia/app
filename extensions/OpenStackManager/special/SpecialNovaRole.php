<?php
class SpecialNovaRole extends SpecialNova {

	var $adminNova;
	var $userLDAP;

	function __construct() {
		parent::__construct( 'NovaRole', 'manageproject' );

		global $wgOpenStackManagerNovaAdminKeys;

		$this->userLDAP = new OpenStackNovaUser();
		$adminCredentials = $wgOpenStackManagerNovaAdminKeys;
		$this->adminNova = new OpenStackNovaController( $adminCredentials );
	}

	function execute( $par ) {


		if ( !$this->getUser()->isLoggedIn() ) {
			$this->notLoggedIn();
			return;
		}
		$this->userLDAP = new OpenStackNovaUser();
		$action = $this->getRequest()->getVal( 'action' );
		if ( $action == "addmember" ) {
			$this->addMember();
		} elseif ( $action == "deletemember" ) {
			$this->deleteMember();
		} else {
			$this->listGlobalRoles();
		}
	}

	/**
	 * @return bool
	 */
	function addMember() {


		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-addmember' ) );

		$roleInfo = array();
		$rolename = $this->getRequest()->getText( 'rolename' );
		$projectname = $this->getRequest()->getText( 'projectname' );
		if ( $projectname ) {
			if ( !$this->userCanExecute( $this->getUser() ) && !$this->userLDAP->inRole( $rolename, $projectname, true ) ) {
				$this->displayRestrictionError();
				return false;
			}
			$project = OpenStackNovaProject::getProjectByName( $projectname );
			$projectmembers = $project->getMembers();
			$role = OpenStackNovaRole::getProjectRoleByName( $rolename, $project );
			$rolemembers = $role->getMembers();
			$member_keys = array();
			foreach ( $projectmembers as $projectmember ) {
				if ( ! in_array( $projectmember, $rolemembers ) ) {
					$member_keys["$projectmember"] = $projectmember;
				}
			}
			if ( ! $member_keys ) {
				$this->getOutput()->addWikiMsg( 'openstackmanager-nomemberstoadd' );
				return true;
			}
			$roleInfo['members'] = array(
				'type' => 'multiselect',
				'label-message' => 'openstackmanager-member',
				'options' => $member_keys,
				'section' => 'role/info',
				'name' => 'members',
			);
		} else {
			if ( !$this->userCanExecute( $this->getUser() ) ) {
				$this->displayRestrictionError();
				return false;
			}
			$roleInfo['members'] = array(
				'type' => 'text',
				'label-message' => 'openstackmanager-member',
				'default' => '',
				'section' => 'role/info',
				'name' => 'members',
			);
		}
		$roleInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'addmember',
			'name' => 'action',
		);
		$roleInfo['rolename'] = array(
			'type' => 'hidden',
			'default' => $rolename,
			'name' => 'rolename',
		);
		$roleInfo['projectname'] = array(
			'type' => 'hidden',
			'default' => $projectname,
			'name' => 'projectname',
		);
		$roleInfo['returnto'] = array(
			'type' => 'hidden',
			'default' => $this->getRequest()->getText('returnto'),
			'name' => 'returnto',
		);

		$roleForm = new SpecialNovaRoleForm( $roleInfo, 'openstackmanager-novarole' );
		$roleForm->setTitle( SpecialPage::getTitleFor( 'NovaRole' ) );
		$roleForm->setSubmitID( 'novarole-form-addmembersubmit' );
		$roleForm->setSubmitCallback( array( $this, 'tryAddMemberSubmit' ) );
		$roleForm->show();

		return true;
	}

	/**
	 * @return bool
	 */
	function deleteMember() {
		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-removerolemember' ) );

		$rolename = $this->getRequest()->getText( 'rolename' );
		$projectname = $this->getRequest()->getText( 'projectname' );
		if ( $projectname ) {
			if ( !$this->userCanExecute( $this->getUser() ) && !$this->userLDAP->inRole( $rolename, $projectname, true ) ) {
				$this->displayRestrictionError();
				return false;
			}
			$project = OpenStackNovaProject::getProjectByName( $projectname );
			$projectmembers = $project->getMembers();
			$role = OpenStackNovaRole::getProjectRoleByName( $rolename, $project );
			$rolemembers = $role->getMembers();
			$member_keys = array();
			foreach ( $projectmembers as $projectmember ) {
				if ( in_array( $projectmember, $rolemembers ) ) {
					$member_keys["$projectmember"] = $projectmember;
				}
			}
		} else {
			if ( !$this->userCanExecute( $this->getUser() ) ) {
				$this->displayRestrictionError();
				return false;
			}
			$role = OpenStackNovaRole::getGlobalRoleByName( $rolename );
			$rolemembers = $role->getMembers();
			$member_keys = array();
			foreach ( $rolemembers as $rolemember ) {
				$member_keys["$rolemember"] = $rolemember;
			}
		}
		if ( ! $member_keys ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-nomemberstoremove' );
			return true;
		}
		$roleInfo = array();
		$roleInfo['members'] = array(
			'type' => 'multiselect',
			'label-message' => 'openstackmanager-member',
			'options' => $member_keys,
			'section' => 'role/info',
			'name' => 'members',
		);
		$roleInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'deletemember',
			'name' => 'action',
		);
		$roleInfo['rolename'] = array(
			'type' => 'hidden',
			'default' => $rolename,
			'name' => 'rolename',
		);
		$roleInfo['projectname'] = array(
			'type' => 'hidden',
			'default' => $projectname,
			'name' => 'projectname',
		);
		$roleInfo['returnto'] = array(
			'type' => 'hidden',
			'default' => $this->getRequest()->getText('returnto'),
			'name' => 'returnto',
		);

		$roleForm = new SpecialNovaRoleForm( $roleInfo, 'openstackmanager-novarole' );
		$roleForm->setTitle( SpecialPage::getTitleFor( 'NovaRole' ) );
		$roleForm->setSubmitID( 'novarole-form-deletemembersubmit' );
		$roleForm->setSubmitCallback( array( $this, 'tryDeleteMemberSubmit' ) );
		$roleForm->show();

		return true;
	}

	/**
	 * @return void
	 */
	function listGlobalRoles() {
		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-rolelist' ) );

		$out = '';

		$rolesOut = Html::element( 'th', array(), wfMsg( 'openstackmanager-rolename' ) );
		$rolesOut .= Html::element( 'th', array(),  wfMsg( 'openstackmanager-members' ) );
		$rolesOut .= Html::element( 'th', array(), wfMsg( 'openstackmanager-actions' ) );
		$roles = OpenStackNovaRole::getAllGlobalRoles();
		if ( ! $roles ) {
			$rolesOut = '';
		}
		foreach ( $roles as $role ) {
			$roleName = $role->getRoleName();
			$roleOut = Html::element( 'td', array(), $roleName );
			$roleMembers = $role->getMembers();
			$memberOut = '';
			foreach ( $roleMembers as $roleMember ) {
				$memberOut .= Html::element( 'li', array(), $roleMember );
			}
			if ( $memberOut ) {
				$memberOut = Html::rawElement( 'ul', array(), $memberOut );
			}
			$roleOut .= Html::rawElement( 'td', array(), $memberOut );
			$link = Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-addrolemember' ), array(), array( 'action' => 'addmember', 'rolename' => $roleName, 'returnto' => 'Special:NovaRole' ) );
			$actions = Html::rawElement( 'li', array(), $link );
			$link = Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-removerolemember' ), array(), array( 'action' => 'deletemember', 'rolename' => $roleName, 'returnto' => 'Special:NovaRole' ) );
			$actions .= Html::rawElement( 'li', array(), $link );
			$actions = Html::rawElement( 'ul', array(), $actions );
			$roleOut .= Html::rawElement( 'td', array(), $actions );
			$rolesOut .= Html::rawElement( 'tr', array(), $roleOut );
		}
		if ( $rolesOut ) {
			$out .= Html::rawElement( 'table', array( 'class' => 'wikitable sortable collapsible' ), $rolesOut );
		}

		$this->getOutput()->addHTML( $out );
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryAddMemberSubmit( $formData, $entryPoint = 'internal' ) {
		$projectname = $formData['projectname'];
		if ( $projectname ) {
			$project = OpenStackNovaProject::getProjectByName( $projectname );
			if ( ! $project ) {
				$this->getOutput()->addWikiMsg( 'openstackmanager-nonexistentproject' );
				return true;
			}
			$role = OpenStackNovaRole::getProjectRoleByName( $formData['rolename'], $project );
			$members = $formData['members'];
		} else {
			$role = OpenStackNovaRole::getGlobalRoleByName( $formData['rolename'] );
			$members = array( $formData['members'] );
		}
		if ( ! $role ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-nonexistentrole' );
			return true;
		}
		foreach ( $members as $member ) {
			$success = $role->addMember( $member );
			if ( $success ) {
				$this->getOutput()->addWikiMsg( 'openstackmanager-addedto', $member, $formData['rolename'] );
			} else {
				$this->getOutput()->addWikiMsg( 'openstackmanager-failedtoadd', $member, $formData['rolename'] );
			}
		}

		$out = '<br />';
		$returnto = Title::newFromText( $formData['returnto'] );
		$out .= Linker::link( $returnto, wfMsgHtml( 'openstackmanager-backprojectlist' ) );
		$this->getOutput()->addHTML( $out );

		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryDeleteMemberSubmit( $formData, $entryPoint = 'internal' ) {
		$projectname = $formData['projectname'];
		if ( $projectname ) {
			$project = OpenStackNovaProject::getProjectByName( $projectname );
			if ( ! $project ) {
				$this->getOutput()->addWikiMsg( 'openstackmanager-nonexistentproject' );
				return true;
			}
			$role = OpenStackNovaRole::getProjectRoleByName( $formData['rolename'], $project );
		} else {
			$role = OpenStackNovaRole::getGlobalRoleByName( $formData['rolename'] );
		}
		if ( ! $role ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-nonexistentrole' );
			return true;
		}
		foreach ( $formData['members'] as $member ) {
			$success = $role->deleteMember( $member );
			if ( $success ) {
				$this->getOutput()->addWikiMsg( 'openstackmanager-removedfrom', $member, $formData['rolename'] );
			} else {
				$this->getOutput()->addWikiMsg( 'openstackmanager-failedtoremove', $member, $formData['rolename'] );
			}
		}

		$out = '<br />';
		$returnto = Title::newFromText( $formData['returnto'] );
		$out .= Linker::link( $returnto, wfMsgHtml( 'openstackmanager-backprojectlist' ) );
		$this->getOutput()->addHTML( $out );

		return true;
	}
}

class SpecialNovaRoleForm extends HTMLForm {
}
