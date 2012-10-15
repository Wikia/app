<?php
class SpecialNovaSecurityGroup extends SpecialNova {

	/**
	 * @var OpenStackNovaController
	 */
	var $adminNova, $userNova;

	/**
	 * @var OpenStackNovaUser
	 */
	var $userLDAP;

	function __construct() {
		parent::__construct( 'NovaSecurityGroup' );
	}

	function execute( $par ) {
		global $wgOpenStackManagerNovaAdminKeys;

		if ( !$this->getUser()->isLoggedIn() ) {
			$this->notLoggedIn();
			return;
		}
		$this->userLDAP = new OpenStackNovaUser();
		if ( ! $this->userLDAP->exists() ) {
			$this->noCredentials();
			return;
		}
		$adminCredentials = $wgOpenStackManagerNovaAdminKeys;
		$this->adminNova = new OpenStackNovaController( $adminCredentials );

		$action = $this->getRequest()->getVal( 'action' );

		if ( $action == "create" ) {
			$this->createSecurityGroup();
		} elseif ( $action == "delete" ) {
			$this->deleteSecurityGroup();
		} elseif ( $action == "configure" ) {
			// Currently unsupported
			#$this->configureSecurityGroup();
			$this->listSecurityGroups();
		} elseif ( $action == "addrule" ) {
			$this->addRule();
		} elseif ( $action == "removerule" ) {
			$this->removeRule();
		} else {
			$this->listSecurityGroups();
		}
	}

	/**
	 * @return bool
	 */
	function createSecurityGroup() {


		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-createsecuritygroup' ) );

		$project = $this->getRequest()->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'netadmin', $project ) ) {
			$this->notInRole( 'netadmin' );
			return false;
		}
		$securityGroupInfo = array();
		$securityGroupInfo['groupname'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-securitygroupname',
			'default' => '',
			'name' => 'groupname',
		);
		$securityGroupInfo['description'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-securitygroupdescription',
			'default' => '',
			'name' => 'description',
		);
		$securityGroupInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
			'name' => 'project',
		);

		$securityGroupInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'create',
			'name' => 'action',
		);

		$securityGroupForm = new SpecialNovaSecurityGroupForm( $securityGroupInfo, 'openstackmanager-novasecuritygroup' );
		$securityGroupForm->setTitle( SpecialPage::getTitleFor( 'NovaSecurityGroup' ) );
		$securityGroupForm->setSubmitID( 'openstackmanager-novainstance-createsecuritygroupsubmit' );
		$securityGroupForm->setSubmitCallback( array( $this, 'tryCreateSubmit' ) );
		$securityGroupForm->show();

		return true;

	}

	/**
	 * @return bool
	 */
	function configureSecurityGroup() {


		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-configuresecuritygroup' ) );

		$securitygroupname = $this->getRequest()->getText( 'groupname' );
		$project = $this->getRequest()->getText( 'project' );
		$securitygroup = $this->adminNova->getSecurityGroup( $securitygroupname, $project );
		$description = $securitygroup->getGroupDescription();
		if ( ! $this->userLDAP->inRole( 'netadmin', $project ) ) {
			$this->notInRole( 'netadmin' );
			return false;
		}
		$securityGroupInfo = array();
		$securityGroupInfo['groupname'] = array(
			'type' => 'hidden',
			'default' => $securitygroupname,
			'name' => 'groupname',
		);
		$securityGroupInfo['description'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-securitygroupdescription',
			'default' => $description,
			'name' => 'description',
		);
		$securityGroupInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
			'name' => 'project',
		);

		$securityGroupInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'configure',
			'name' => 'action',
		);

		$securityGroupForm = new SpecialNovaSecurityGroupForm( $securityGroupInfo, 'openstackmanager-novasecuritygroup' );
		$securityGroupForm->setTitle( SpecialPage::getTitleFor( 'NovaSecurityGroup' ) );
		$securityGroupForm->setSubmitID( 'openstackmanager-novainstance-configuresecuritygroupsubmit' );
		$securityGroupForm->setSubmitCallback( array( $this, 'tryConfigureSubmit' ) );
		$securityGroupForm->show();

		return true;

	}

	/**
	 * @return bool
	 */
	function deleteSecurityGroup() {


		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-deletesecuritygroup' ) );

		$project = $this->getRequest()->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'netadmin', $project ) ) {
			$this->notInRole( 'netadmin' );
			return false;
		}
		$securitygroupname = $this->getRequest()->getText( 'groupname' );
		if ( ! $this->getRequest()->wasPosted() ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-deletesecuritygroup-confirm', $securitygroupname );
		}
		$securityGroupInfo = array();
		$securityGroupInfo['groupname'] = array(
			'type' => 'hidden',
			'default' => $securitygroupname,
			'name' => 'groupname',
		);
		$securityGroupInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
			'name' => 'project',
		);
		$securityGroupInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'delete',
			'name' => 'action',
		);
		$securityGroupForm = new SpecialNovaSecurityGroupForm( $securityGroupInfo, 'openstackmanager-novasecuritygroup' );
		$securityGroupForm->setTitle( SpecialPage::getTitleFor( 'NovaSecurityGroup' ) );
		$securityGroupForm->setSubmitID( 'novainstance-form-deletesecuritygroupsubmit' );
		$securityGroupForm->setSubmitCallback( array( $this, 'tryDeleteSubmit' ) );
		$securityGroupForm->show();

		return true;
	}

	/**
	 * @return bool
	 */
	function listSecurityGroups() {
		$this->setHeaders();
		$this->getOutput()->addModuleStyles( 'ext.openstack' );
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-securitygrouplist' ) );

		$userProjects = $this->userLDAP->getProjects();

		$out = '';
		$groupheader = Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygroupname' ) );
		$groupheader .= Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygroupdescription' ) );
		$groupheader .= Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygrouprule' ) );
		$groupheader .= Html::element( 'th', array(), wfMsg( 'openstackmanager-actions' ) );
		$ruleheader = Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygrouprule-fromport' ) );
		$ruleheader .= Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygrouprule-toport' ) );
		$ruleheader .= Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygrouprule-protocol' ) );
		$ruleheader .= Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygrouprule-ipranges' ) );
		$ruleheader .= Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygrouprule-groups' ) );
		$ruleheader .= Html::element( 'th', array(), wfMsg( 'openstackmanager-actions' ) );
		$projectArr = array();
		$securityGroups = $this->adminNova->getSecurityGroups();
		foreach ( $securityGroups as $group ) {
			$project = $group->getOwner();
			if ( ! in_array( $project, $userProjects ) ) {
				continue;
			}
			$groupname = $group->getGroupName();
			$groupOut = Html::element( 'td', array(), $groupname );
			$groupOut .= Html::element( 'td', array(), $group->getGroupDescription() );
			# Add rules
			$rules = $group->getRules();
			if ( $rules ) {
				$rulesOut = $ruleheader;
				foreach ( $rules as $rule ) {
					$fromport = $rule->getFromPort();
					$toport = $rule->getToPort();
					$ipprotocol = $rule->getIPProtocol();
					$ruleOut = Html::element( 'td', array(), $fromport );
					$ruleOut .= Html::element( 'td', array(), $toport );
					$ruleOut .= Html::element( 'td', array(), $ipprotocol );
					$ranges = $rule->getIPRanges();
					if ( $ranges ) {
						$rangesOut = '';
						foreach ( $ranges as $range ) {
							$rangesOut .= Html::element( 'li', array(), $range );
						}
						$rangesOut = Html::rawElement( 'ul', array(), $rangesOut );
						$ruleOut .= Html::rawElement( 'td', array(), $rangesOut );
					} else {
						$ruleOut .= Html::rawElement( 'td', array(), '' );
					}
					$sourcegroups = $rule->getGroups();
					$groupinfo = array();
					if ( $sourcegroups ) {
						$sourcegroupsOut = '';
						foreach ( $sourcegroups as $sourcegroup ) {
							$groupinfo[] = $sourcegroup['groupname'] . ':' . $sourcegroup['project'];
							$sourcegroupinfo = $sourcegroup['groupname'] . ' (' . $sourcegroup['project'] . ')';
							$sourcegroupsOut .= Html::element( 'li', array(), $sourcegroupinfo );
						}
						$sourcegroupsOut = Html::rawElement( 'ul', array(), $sourcegroupsOut );
						$ruleOut .= Html::rawElement( 'td', array(), $sourcegroupsOut );
					} else {
						$ruleOut .= Html::rawElement( 'td', array(), '' );
					}
					$actions = '';
					if ( $this->userLDAP->inRole( 'netadmin', $project ) ) {
						$msg = wfMsgHtml( 'openstackmanager-removerule-action' );
						$args = array(  'action' => 'removerule',
								'project' => $project,
								'groupname' => $groupname,
								'fromport' => $fromport,
								'toport' => $toport,
								'protocol' => $ipprotocol,
								'ranges' => implode( ',', $ranges ),
								'groups' => implode( ',', $groupinfo ) );
						$link = Linker::link( $this->getTitle(), $msg, array(), $args );
						$actions = Html::rawElement( 'li', array(), $link );
						$actions = Html::rawElement( 'ul', array(), $actions );
					}
					$ruleOut .= Html::rawElement( 'td', array(), $actions );
					$rulesOut .= Html::rawElement( 'tr', array(), $ruleOut );
				}
				$rulesOut = Html::rawElement( 'table', array( 'id' => 'novasecuritygrouplist', 'class' => 'wikitable sortable collapsible' ), $rulesOut );
				$groupOut .= Html::rawElement( 'td', array(), $rulesOut );
			} else {
				$groupOut .= Html::rawElement( 'td', array(), '' );
			}
			$actions = '';
			if ( $this->userLDAP->inRole( 'netadmin', $project ) ) {
				$msg = wfMsgHtml( 'openstackmanager-delete' );
				$link = Linker::link( $this->getTitle(), $msg, array(),
									  array( 'action' => 'delete',
										   'project' => $project,
										   'groupname' => $group->getGroupName() ) );
				$actions = Html::rawElement( 'li', array(), $link );
				#$msg = wfMsgHtml( 'openstackmanager-configure' );
				#$link = Linker::link( $this->getTitle(), $msg, array(),
				#					   array( 'action' => 'configure',
				#							'project' => $project,
				#							'groupname' => $group->getGroupName() ) );
				#$actions .= Html::rawElement( 'li', array(), $link );
				$msg = wfMsgHtml( 'openstackmanager-addrule-action' );
				$link = Linker::link( $this->getTitle(), $msg, array(),
									   array( 'action' => 'addrule',
											'project' => $project,
											'groupname' => $group->getGroupName() ) );
				$actions .= Html::rawElement( 'li', array(), $link );
				$actions = Html::rawElement( 'ul', array(), $actions );
			}
			$groupOut .= Html::rawElement( 'td', array(), $actions );
			if ( isset( $projectArr["$project"] ) ) {
				$projectArr["$project"] .= Html::rawElement( 'tr', array(), $groupOut );
			} else {
				$projectArr["$project"] = Html::rawElement( 'tr', array(), $groupOut );
			}
		}
		foreach ( $userProjects as $project ) {
			$action = '';
			if ( $this->userLDAP->inRole( 'netadmin', $project ) ) {
				$action = Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-createnewsecuritygroup' ), array(),
				array( 'action' => 'create', 'project' => $project ) );
				$action = Html::rawElement( 'span', array( 'id' => 'novaaction' ), "[$action]" );
			}
			$projectName = Html::rawElement( 'span', array( 'class' => 'mw-customtoggle-' . $project, 'id' => 'novaproject' ), $project );
			$out .= Html::rawElement( 'h2', array(), "$projectName $action" );
			if ( isset( $projectArr["$project"] ) ) {
				$projectOut = $groupheader;
				$projectOut .= $projectArr["$project"];
				$projectOut = Html::rawElement( 'table', array( 'id' => 'novainstancelist', 'class' => 'wikitable sortable' ), $projectOut );
			}
			$out .= Html::rawElement( 'div', array( 'class' => 'mw-collapsible', 'id' => 'mw-customcollapsible-' . $project ), $projectOut );
		}

		$this->getOutput()->addHTML( $out );
		return true;
	}

	/**
	 * @return bool
	 */
	function addRule() {


		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-addrule' ) );

		$project = $this->getRequest()->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'netadmin', $project ) ) {
			$this->notInRole( 'netadmin' );
			return false;
		}

		$info = array();
		$securityGroups = $this->adminNova->getSecurityGroups();
		foreach ( $securityGroups as $securityGroup ) {
			$securityGroupName = $securityGroup->getGroupName();
			$securityGroupProject = $securityGroup->getOwner();
			$info["$securityGroupProject"]["$securityGroupName"] = $securityGroupName . ':' . $securityGroupProject;
		}
		$group_keys = $info;
		$securitygroupname = $this->getRequest()->getText( 'groupname' );
		$securityGroupInfo = array();
		$securityGroupInfo['groupname'] = array(
			'type' => 'hidden',
			'default' => $securitygroupname,
			'name' => 'groupname',
		);
		$securityGroupInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
			'section' => 'rule/singlerule',
			'name' => 'project',
		);
		$securityGroupInfo['fromport'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-securitygrouprule-fromport',
			'default' => '',
			'section' => 'rule/singlerule',
			'name' => 'fromport',
		);
		$securityGroupInfo['toport'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-securitygrouprule-toport',
			'default' => '',
			'section' => 'rule/singlerule',
			'name' => 'toport',
		);
		$securityGroupInfo['protocol'] = array(
			'type' => 'select',
			'label-message' => 'openstackmanager-securitygrouprule-protocol',
			'options' => array( '' => '', 'icmp' => 'icmp', 'tcp' => 'tcp', 'udp' => 'udp' ),
			'section' => 'rule/singlerule',
			'name' => 'protocol',
		);
		$securityGroupInfo['ranges'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-securitygrouprule-ranges',
			'help-message' => 'openstackmanager-securitygrouprule-ranges-help',
			'default' => '',
			'section' => 'rule/singlerule',
			'name' => 'ranges',
		);
		$securityGroupInfo['groups'] = array(
			'type' => 'multiselect',
			'label-message' => 'openstackmanager-securitygrouprule-groups',
			'help-message' => 'openstackmanager-securitygrouprule-groups-help',
			'options' => $group_keys,
			'section' => 'rule/group',
			'name' => 'groups',
		);
		$securityGroupInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'addrule',
			'name' => 'action',
		);
		$securityGroupForm = new SpecialNovaSecurityGroupForm( $securityGroupInfo, 'openstackmanager-novasecuritygroup' );
		$securityGroupForm->setTitle( SpecialPage::getTitleFor( 'NovaSecurityGroup' ) );
		$securityGroupForm->addHeaderText( wfMsg( 'openstackmanager-securitygrouprule-group-exclusive' ), 'rule' );
		$securityGroupForm->setSubmitID( 'novainstance-form-removerulesubmit' );
		$securityGroupForm->setSubmitCallback( array( $this, 'tryAddRuleSubmit' ) );
		$securityGroupForm->show();

		return true;
	}

	/**
	 * @return bool
	 */
	function removeRule() {


		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-removerule' ) );

		$project = $this->getRequest()->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'netadmin', $project ) ) {
			$this->notInRole( 'netadmin' );
			return false;
		}
		$securitygroupname = $this->getRequest()->getText( 'groupname' );
		if ( ! $this->getRequest()->wasPosted() ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-removerule-confirm', $securitygroupname );
		}
		$securityGroupInfo = array();
		$securityGroupInfo['groupname'] = array(
			'type' => 'hidden',
			'default' => $securitygroupname,
			'name' => 'groupname',
		);
		$securityGroupInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
			'name' => 'project',
		);
		$securityGroupInfo['fromport'] = array(
			'type' => 'hidden',
			'default' => $this->getRequest()->getText( 'fromport' ),
			'name' => 'fromport',
		);
		$securityGroupInfo['toport'] = array(
			'type' => 'hidden',
			'default' => $this->getRequest()->getText( 'toport' ),
			'name' => 'toport',
		);
		$securityGroupInfo['protocol'] = array(
			'type' => 'hidden',
			'default' => $this->getRequest()->getText( 'protocol' ),
			'name' => 'protocol',
		);
		if ( $this->getRequest()->getText( 'ranges' ) ) {
			$securityGroupInfo['ranges'] = array(
				'type' => 'hidden',
				'default' => $this->getRequest()->getText( 'ranges' ),
				'name' => 'ranges',
			);
		}
		if ( $this->getRequest()->getText( 'groups' ) ) {
			$securityGroupInfo['groups'] = array(
				'type' => 'hidden',
				'default' => $this->getRequest()->getText( 'groups' ),
				'name' => 'groups',
			);
		}
		$securityGroupInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'removerule',
			'name' => 'action',
		);
		$securityGroupForm = new SpecialNovaSecurityGroupForm( $securityGroupInfo, 'openstackmanager-novasecuritygroup' );
		$securityGroupForm->setTitle( SpecialPage::getTitleFor( 'NovaSecurityGroup' ) );
		$securityGroupForm->setSubmitID( 'novainstance-form-removerulesubmit' );
		$securityGroupForm->setSubmitCallback( array( $this, 'tryRemoveRuleSubmit' ) );
		$securityGroupForm->show();

		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryCreateSubmit( $formData, $entryPoint = 'internal' ) {
		$project = $formData['project'];
		$groupname = $formData['groupname'];
		$description = $formData['description'];
		$userCredentials = $this->userLDAP->getCredentials();
		$this->userNova = new OpenStackNovaController( $userCredentials, $project );
		$securitygroup = $this->userNova->createSecurityGroup( $groupname, $description );
		if ( $securitygroup ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-createdsecuritygroup' );
		} else {
			$this->getOutput()->addWikiMsg( 'openstackmanager-createsecuritygroupfailed' );
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backsecuritygrouplist' ) );

		$this->getOutput()->addHTML( $out );
		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryDeleteSubmit( $formData, $entryPoint = 'internal' ) {
		$project = $formData['project'];
		$userCredentials = $this->userLDAP->getCredentials();
		$this->userNova = new OpenStackNovaController( $userCredentials, $project );
		$securitygroup = $this->adminNova->getSecurityGroup( $formData['groupname'], $project );
		if ( !$securitygroup ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-nonexistantsecuritygroup' );
			return true;
		}
		$groupname = $securitygroup->getGroupName();
		$success = $this->userNova->deleteSecurityGroup( $groupname );
		if ( $success ) {
			# TODO: Ensure group isn't being used
			$this->getOutput()->addWikiMsg( 'openstackmanager-deletedsecuritygroup' );
		} else {
			$this->getOutput()->addWikiMsg( 'openstackmanager-deletesecuritygroupfailed' );
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backsecuritygrouplist' ) );

		$this->getOutput()->addHTML( $out );
		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryConfigureSubmit( $formData, $entryPoint = 'internal' ) {
		$project = $formData['project'];
		$groupname = $formData['groupname'];
		$description = $formData['description'];
		$group = $this->adminNova->getSecurityGroup( $groupname, $project );
		if ( $group ) {
			# This isn't a supported function in the API for now. Leave this action out for now
			$success = $this->userNova->modifySecurityGroup( $groupname, array( 'description' => $description ) );
			if ( $success ) {
				$this->getOutput()->addWikiMsg( 'openstackmanager-modifiedgroup' );
			} else {
				$this->getOutput()->addWikiMsg( 'openstackmanager-modifygroupfailed' );
			}
		} else {
			$this->getOutput()->addWikiMsg( 'openstackmanager-nonexistantgroup' );
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backsecuritygrouplist' ) );

		$this->getOutput()->addHTML( $out );
		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryAddRuleSubmit( $formData, $entryPoint = 'internal' ) {
		$project = $formData['project'];
		$fromport = $formData['fromport'];
		$toport = $formData['toport'];
		$protocol = $formData['protocol'];
		if ( isset( $formData['ranges'] ) && $formData['ranges'] ) {
			$ranges = explode( ',', $formData['ranges'] );
		} else {
			$ranges = array();
		}
		$groups = array();
		foreach ( $formData['groups'] as $group ) {
			$group = explode( ':', $group );
			$groups[] = array( 'groupname' => $group[0], 'project' => $group[1] );
		}
		$userCredentials = $this->userLDAP->getCredentials();
		$this->userNova = new OpenStackNovaController( $userCredentials, $project );
		$securitygroup = $this->adminNova->getSecurityGroup( $formData['groupname'], $project );
		if ( ! $securitygroup ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-nonexistantsecuritygroup' );
			return false;
		}
		$groupname = $securitygroup->getGroupName();
		$success = $this->userNova->addSecurityGroupRule( $groupname, $fromport, $toport, $protocol, $ranges, $groups );
		if ( $success ) {
			# TODO: Ensure group isn't being used
			$this->getOutput()->addWikiMsg( 'openstackmanager-addedrule' );
		} else {
			$this->getOutput()->addWikiMsg( 'openstackmanager-addrulefailed' );
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backsecuritygrouplist' ) );

		$this->getOutput()->addHTML( $out );
		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryRemoveRuleSubmit( $formData, $entryPoint = 'internal' ) {
		$project = $formData['project'];
		$fromport = $formData['fromport'];
		$toport = $formData['toport'];
		$protocol = $formData['protocol'];
		if ( isset( $formData['ranges'] ) ) {
			$ranges = explode( ',', $formData['ranges'] );
		} else {
			$ranges = array();
		}
		$groups = array();
		if ( isset( $formData['groups'] ) ) {
			$rawgroups = explode( ',', $formData['groups'] );
			foreach ( $rawgroups as $rawgroup ) {
				$rawgroup = explode( ':', $rawgroup );
				$groups[] = array( 'groupname' => $rawgroup[0], 'project' => $rawgroup[1] );
			}
		}
		$userCredentials = $this->userLDAP->getCredentials();
		$this->userNova = new OpenStackNovaController( $userCredentials, $project );
		$securitygroup = $this->adminNova->getSecurityGroup( $formData['groupname'], $project );
		if ( ! $securitygroup ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-nonexistantsecuritygroup' );
			return false;
		}
		$groupname = $securitygroup->getGroupName();
		$success = $this->userNova->removeSecurityGroupRule( $groupname, $fromport, $toport, $protocol, $ranges, $groups );
		if ( $success ) {
			# TODO: Ensure group isn't being used
			$this->getOutput()->addWikiMsg( 'openstackmanager-removedrule' );
		} else {
			$this->getOutput()->addWikiMsg( 'openstackmanager-removerulefailed' );
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backsecuritygrouplist' ) );

		$this->getOutput()->addHTML( $out );
		return true;
	}
}

class SpecialNovaSecurityGroupForm extends HTMLForm {
}
