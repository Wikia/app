<?php
class SpecialNovaProject extends SpecialNova {

	var $adminNova;
	var $userLDAP;

	function __construct() {
		parent::__construct( 'NovaProject', 'manageproject' );

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
		if ( $action == "delete" ) {
			$this->deleteProject();
		} elseif ( $action == "addmember" ) {
			$this->addMember();
		} elseif ( $action == "deletemember" ) {
			$this->deleteMember();
		} else {
			$this->listProjects();
		}
	}

	/**
	 * @return bool
	 */
	function addMember() {
		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-addmember' ) );

		$project = $this->getRequest()->getText( 'projectname' );
		if ( !$this->userCanExecute( $this->getUser() ) && !$this->userLDAP->inProject( $project ) ) {
			$this->notInProject();
			return false;
		}
		$projectInfo = array();
		$projectInfo['member'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-member',
			'default' => '',
			'name' => 'member',
		);
		$projectInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'addmember',
			'name' => 'action',
		);
		$projectInfo['projectname'] = array(
			'type' => 'hidden',
			'default' => $project,
			'name' => 'projectname',
		);

		$projectForm = new SpecialNovaProjectForm( $projectInfo, 'openstackmanager-novaproject' );
		$projectForm->setTitle( SpecialPage::getTitleFor( 'NovaProject' ) );
		$projectForm->setSubmitID( 'novaproject-form-addmembersubmit' );
		$projectForm->setSubmitCallback( array( $this, 'tryAddMemberSubmit' ) );
		$projectForm->show();

		return true;
	}

	/**
	 * @return bool
	 */
	function deleteMember() {
		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-removemember' ) );

		$projectname = $this->getRequest()->getText( 'projectname' );
		if ( !$this->userCanExecute( $this->getUser() ) && !$this->userLDAP->inProject( $projectname ) ) {
			$this->notInProject();
			return false;
		}
		$project = OpenStackNovaProject::getProjectByName( $projectname );
		$projectmembers = $project->getMembers();
		$member_keys = array();
		foreach ( $projectmembers as $projectmember ) {
			$member_keys["$projectmember"] = $projectmember;
		}
		$projectInfo = array();
		$projectInfo['members'] = array(
			'type' => 'multiselect',
			'label-message' => 'openstackmanager-member',
			'options' => $member_keys,
			'name' => 'members',
		);
		$projectInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'deletemember',
			'name' => 'action',
		);
		$projectInfo['projectname'] = array(
			'type' => 'hidden',
			'default' => $projectname,
			'name' => 'projectname',
		);

		$projectForm = new SpecialNovaProjectForm( $projectInfo, 'openstackmanager-novaproject' );
		$projectForm->setTitle( SpecialPage::getTitleFor( 'NovaProject' ) );
		$projectForm->setSubmitID( 'novaproject-form-deletemembersubmit' );
		$projectForm->setSubmitCallback( array( $this, 'tryDeleteMemberSubmit' ) );
		$projectForm->show();

		return true;
	}

	/**
	 * @return bool
	 */
	function deleteProject() {
		$this->setHeaders();
		if ( !$this->userCanExecute( $this->getUser() ) ) {
			$this->displayRestrictionError();
			return false;
		}
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-deleteproject' ) );

		$project = $this->getRequest()->getText( 'projectname' );
		if ( ! $this->getRequest()->wasPosted() ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-removeprojectconfirm', $project );
		}
		$projectInfo = array();
		$projectInfo['projectname'] = array(
			'type' => 'hidden',
			'default' => $project,
			'name' => 'projectname',
		);
		$projectInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'delete',
			'name' => 'action',
		);
		$projectForm = new SpecialNovaProjectForm( $projectInfo, 'openstackmanager-novaproject' );
		$projectForm->setTitle( SpecialPage::getTitleFor( 'NovaProject' ) );
		$projectForm->setSubmitID( 'novaproject-form-deleteprojectsubmit' );
		$projectForm->setSubmitCallback( array( $this, 'tryDeleteSubmit' ) );
		$projectForm->show();

		return true;
	}

	/**
	 * @return void
	 */
	function listProjects() {
		$this->setHeaders();
		$this->getOutput()->setPageTitle( wfMsg( 'openstackmanager-projectlist' ) );
		$this->getOutput()->addModuleStyles( 'ext.openstack' );

		if ( $this->userLDAP->inGlobalRole( 'cloudadmin' ) ) {
			$projectInfo = array();
			$projectInfo['projectname'] = array(
				'type' => 'text',
				'label-message' => 'openstackmanager-projectname',
				'validation-callback' => array( $this, 'validateText' ),
				'default' => '',
				'section' => 'project',
				'name' => 'projectname',
			);
			$projectInfo['member'] = array(
				'type' => 'text',
				'label-message' => 'openstackmanager-member',
				'default' => '',
				'section' => 'project',
				'name' => 'member',
			);
			$role_keys = array();
			foreach ( OpenStackNovaProject::$rolenames as $rolename ) {
				$role_keys["$rolename"] = $rolename;
			}
			$projectInfo['roles'] = array(
				'type' => 'multiselect',
				'label-message' => 'openstackmanager-roles',
				'section' => 'project',
				'options' => $role_keys,
				'name' => 'roles',
			);

			$projectInfo['action'] = array(
				'type' => 'hidden',
				'default' => 'create',
				'name' => 'action',
			);

			$projectForm = new SpecialNovaProjectForm( $projectInfo, 'openstackmanager-novaproject' );
			$projectForm->setTitle( SpecialPage::getTitleFor( 'NovaProject' ) );
			$projectForm->setSubmitID( 'novaproject-form-createprojectsubmit' );
			$projectForm->setSubmitCallback( array( $this, 'tryCreateSubmit' ) );
			$projectForm->show();
		}

		$out = '';

		$header = Html::element( 'th', array(),  wfMsg( 'openstackmanager-members' ) );
		$header .= Html::element( 'th', array(),  wfMsg( 'openstackmanager-roles' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-actions' ) );
		$projects = OpenStackNovaProject::getAllProjects();
		if ( ! $projects ) {
			$projectsOut = '';
		}
		foreach ( $projects as $project ) {
			$projectName = $project->getProjectName();
			$projectName = htmlentities( $projectName );
			$out .= Html::rawElement( 'h2', array( 'class' => 'mw-customtoggle-' . $projectName, 'id' => 'novaproject' ), $projectName );
			$projectMembers = $project->getMembers();
			$memberOut = '';
			foreach ( $projectMembers as $projectMember ) {
				$memberOut .= Html::element( 'li', array(), $projectMember );
			}
			if ( $memberOut ) {
				$memberOut = Html::rawElement( 'ul', array(), $memberOut );
			}
			$projectOut = Html::rawElement( 'td', array(), $memberOut );
			$rolesOut = Html::element( 'th', array(), wfMsg( 'openstackmanager-rolename' ) );
			$rolesOut .= Html::element( 'th', array(),  wfMsg( 'openstackmanager-members' ) );
			$rolesOut .= Html::element( 'th', array(), wfMsg( 'openstackmanager-actions' ) );
			foreach ( $project->getRoles() as $role ) {
				$roleOut = Html::element( 'td', array(), $role->getRoleName() );
				$roleMembers = '';
				$specialRoleTitle = Title::newFromText( 'Special:NovaRole' );
				foreach ( $role->getMembers() as $member ) {
					$roleMembers .= Html::element( 'li', array(), $member );
				}
				$roleMembers = Html::rawElement( 'ul', array(), $roleMembers );
				$roleOut .= Html::rawElement( 'td', array(), $roleMembers );
				$link = Linker::link( $specialRoleTitle, wfMsgHtml( 'openstackmanager-addrolemember' ), array(),
								   array( 'action' => 'addmember', 'projectname' => $projectName, 'rolename' => $role->getRoleName(), 'returnto' => 'Special:NovaProject' ) );
				$actions = Html::rawElement( 'li', array(), $link );
				$link = Linker::link( $specialRoleTitle, wfMsgHtml( 'openstackmanager-removerolemember' ), array(),
								   array( 'action' => 'deletemember', 'projectname' => $projectName, 'rolename' => $role->getRoleName(), 'returnto' => 'Special:NovaProject' ) );
				$actions .= Html::rawElement( 'li', array(), $link );
				$actions = Html::rawElement( 'ul', array(), $actions );
				$roleOut .= Html::rawElement( 'td', array(), $actions );
				$rolesOut .= Html::rawElement( 'tr', array(), $roleOut );
			}
			$rolesOut = Html::rawElement( 'table', array( 'class' => 'wikitable sortable collapsible' ), $rolesOut );
			$projectOut .= Html::rawElement( 'td', array( 'class' => 'Nova_cell' ), $rolesOut );
			$link = Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-deleteproject' ), array(),
							   array( 'action' => 'delete', 'projectname' => $projectName ) );
			$actions = Html::rawElement( 'li', array(), $link );
			$link = Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-addmember' ), array(),
									 array( 'action' => 'addmember', 'projectname' => $projectName ) );
			$actions .= Html::rawElement( 'li', array(), $link );
			$link = Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-removemember' ), array(),
							   array( 'action' => 'deletemember', 'projectname' => $projectName ) );
			$actions .= Html::rawElement( 'li', array(), $link );
			$actions = Html::rawElement( 'ul', array(), $actions );
			$projectOut .= Html::rawElement( 'td', array(), $actions );
			$projectOut = Html::rawElement( 'tr', array(), $projectOut );
			$projectOut = $header . $projectOut;
			$projectOut = Html::rawElement( 'table', array( 'class' => 'wikitable sortable collapsible' ), $projectOut );
			$out .= Html::rawElement( 'div', array( 'class' => 'mw-collapsible', 'id' => 'mw-customcollapsible-' . $projectName ), $projectOut );
		}

		$this->getOutput()->addHTML( $out );
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryCreateSubmit( $formData, $entryPoint = 'internal' ) {
		global $wgOpenStackManagerDefaultSecurityGroupRules;

		$success = OpenStackNovaProject::createProject( $formData['projectname'] );
		if ( ! $success ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-createprojectfailed' );
			return false;
		}
		$project = OpenStackNovaProject::getProjectByName( $formData['projectname'] );
		$members = explode( ',', $formData['member'] );
		foreach ( $members as $member ) {
			$project->addMember( $member );
		}
		$roles = $project->getRoles();
		foreach ( $roles as $role ) {
			if ( in_array( $role->getRoleName(), $formData['roles'] ) ) {
				foreach ( $members as $member ) {
					$role->addMember( $member );
				}
			}
		}
		# Create a default security group for this project, and add configured default rules
		$groupname = 'default';
		# Change the connection to reference this project
		$this->adminNova->configureConnection( $formData['projectname'] );
		$this->adminNova->createSecurityGroup( $groupname, '' );
		foreach ( $wgOpenStackManagerDefaultSecurityGroupRules as $rule ) {
			$fromport = '';
			$toport = '';
			$protocol = '';
			$ranges = array();
			$groups = array();
			if ( array_key_exists( 'fromport', $rule ) ) {
				$fromport = $rule['fromport'];
			}
			if ( array_key_exists( 'toport', $rule ) ) {
				$toport = $rule['toport'];
			}
			if ( array_key_exists( 'protocol', $rule ) ) {
				$protocol = $rule['protocol'];
			}
			if ( array_key_exists( 'ranges', $rule ) ) {
				$ranges = $rule['ranges'];
			}
			if ( array_key_exists( 'groups', $rule ) ) {
				foreach ( $rule['groups'] as $group ) {
					if ( !array_key_exists( 'groupname', $group ) ) {
						# TODO: log an error here
						continue;
					}
					if ( array_key_exists( 'project', $group ) ) {
						$groupproject = $group['project'];
					} else {
						# Assume groups with no project defined are
						# referencing this project's group
						$groupproject = $formData['projectname'];
					}
					$groups[] = array( 'groupname' => $group['groupname'], 'project' => $groupproject );
				}
			}
			$this->adminNova->addSecurityGroupRule( $groupname, $fromport, $toport, $protocol, $ranges, $groups );
		}
		# Reset connection to default
		$this->adminNova->configureConnection();
		$project->editArticle();
		$this->getOutput()->addWikiMsg( 'openstackmanager-createdproject' );

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-addadditionaldomain' ) );
		$this->getOutput()->addHTML( $out );

		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryDeleteSubmit( $formData, $entryPoint = 'internal' ) {
		$success = OpenStackNovaProject::deleteProject( $formData['projectname'] );
		if ( $success ) {
			$project = OpenStackNovaProject::getProjectByName( $formData['projectname'] );
			$project->deleteArticle();
			$this->getOutput()->addWikiMsg( 'openstackmanager-deletedproject' );
		} else {
			$this->getOutput()->addWikiMsg( 'openstackmanager-deleteprojectfailed' );
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backprojectlist' ) );
		$this->getOutput()->addHTML( $out );

		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryAddMemberSubmit( $formData, $entryPoint = 'internal' ) {
		$project = new OpenStackNovaProject( $formData['projectname'] );
		$members = explode( ',', $formData['member'] );
		foreach ( $members as $member ) {
			$success = $project->addMember( $member );
			if ( $success ) {
				$project->editArticle();
				$this->getOutput()->addWikiMsg( 'openstackmanager-addedto', $formData['member'], $formData['projectname'] );
			} else {
				$this->getOutput()->addWikiMsg( 'openstackmanager-failedtoadd', $formData['member'], $formData['projectname'] );
			}
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backprojectlist' ) );
		$this->getOutput()->addHTML( $out );

		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryDeleteMemberSubmit( $formData, $entryPoint = 'internal' ) {
		$project = OpenStackNovaProject::getProjectByName( $formData['projectname'] );
		if ( ! $project ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-nonexistentproject' );
			return true;
		}
		foreach ( $formData['members'] as $member ) {
			$success = $project->deleteMember( $member );
			if ( $success ) {
				$project->editArticle();
				$this->getOutput()->addWikiMsg( 'openstackmanager-removedfrom', $member, $formData['projectname'] );
			} else {
				$this->getOutput()->addWikiMsg( 'openstackmanager-failedtoremove', $member, $formData['projectname'] );
			}
		}
		$out = '<br />';

		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backprojectlist' ) );
		$this->getOutput()->addHTML( $out );

		return true;
	}

}

class SpecialNovaProjectForm extends HTMLForm {
}
