<?php
class SpecialNovaInstance extends SpecialNova {

	/**
	 * @var OpenStackNovaController
	 */
	var $adminNova, $userNova;

	/**
	 * @var OpenStackNovaUser
	 */
	var $userLDAP;

	function __construct() {
		parent::__construct( 'NovaInstance' );
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
		$project = $this->getRequest()->getVal( 'project' );
		$userCredentials = $this->userLDAP->getCredentials();
		$this->userNova = new OpenStackNovaController( $userCredentials, $project );
		$adminCredentials = $wgOpenStackManagerNovaAdminKeys;
		$this->adminNova = new OpenStackNovaController( $adminCredentials );

		$action = $this->getRequest()->getVal( 'action' );

		if ( $action == "create" ) {
			if ( ! $this->userLDAP->inProject( $project ) ) {
				$this->notInProject();
				return;
			}
			$this->createInstance();
		} elseif ( $action == "delete" ) {
			if ( ! $this->userLDAP->inProject( $project ) ) {
				$this->notInProject();
				return;
			}
			$this->deleteInstance();
		} elseif ( $action == "configure" ) {
			if ( ! $this->userLDAP->inProject( $project ) ) {
				$this->notInProject();
				return;
			}
			$this->configureInstance();
		} elseif ( $action == "reboot" ) {
			if ( ! $this->userLDAP->inProject( $project ) ) {
				$this->notInProject();
				return;
			}
			$this->rebootInstance();
		} elseif ( $action == "consoleoutput" ) {
			if ( ! $this->userLDAP->inProject( $project ) ) {
				$this->notInProject();
				return;
			}
			$this->getConsoleOutput();
		} else {
			$this->listInstances();
		}
	}

	/**
	 * @return bool
	 */
	function createInstance() {

		global $wgOpenStackManagerPuppetOptions;
		global $wgOpenStackManagerInstanceDefaultImage;

		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-createinstance' ) );

		$project = $this->getRequest()->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'sysadmin', $project ) ) {
			$this->notInRole( 'sysadmin' );
			return false;
		}
		$instanceInfo = array();
		$instanceInfo['instancename'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-instancename',
			'validation-callback' => array( $this, 'validateText' ),
			'default' => '',
			'section' => 'info',
			'name' => 'instancename',
		);

		$instanceTypes = $this->adminNova->getInstanceTypes();
		$instanceType_keys = array();
		foreach ( $instanceTypes as $instanceType ) {
			$instanceTypeName = $instanceType->getInstanceTypeName();
			$cpus = $instanceType->getNumberOfCPUs();
			$ram = $instanceType->getMemorySize();
			$storage = $instanceType->getStorageSize();
			$instanceLabel = $instanceTypeName . ' (' . wfMsgExt( 'openstackmanager-instancetypelabel', 'parsemag', $cpus, $ram, $storage ) . ')';
			$instanceType_keys["$instanceLabel"] = $instanceTypeName;
		}
		$instanceInfo['instanceType'] = array(
			'type' => 'select',
			'label-message' => 'openstackmanager-instancetype',
			'section' => 'info',
			'options' => $instanceType_keys,
			'name' => 'instanceType',
		);

		# Availability zone names can't be translated. Get the keys, and make an array
		# where the name points to itself as a value
		$availabilityZones = $this->adminNova->getAvailabilityZones();
		$availabilityZone_keys = array();
		foreach ( array_keys( $availabilityZones ) as $availabilityZone_key ) {
			$availabilityZone_keys["$availabilityZone_key"] = $availabilityZone_key;
		}
		$instanceInfo['availabilityZone'] = array(
			'type' => 'select',
			'section' => 'info',
			'options' => $availabilityZone_keys,
			'label-message' => 'openstackmanager-availabilityzone',
			'name' => 'availabilityZone',
		);

		# Image names can't be translated. Get the image, and make an array
		# where the name points to itself as a value
		$images = $this->adminNova->getImages();
		$image_keys = array();
		$default = "";
		foreach ( $images as $image ) {
			if ( ! $image->imageIsPublic() ) {
				continue;
			}
			if ( $image->getImageState() != "available" ) {
				continue;
			}
			if ( $image->getImageType() != "machine" ) {
				continue;
			}
			$imageName = $image->getImageName();
			if ( $imageName == '' ) {
				continue;
			}
			$imageLabel = $imageName . ' (' . $image->getImageArchitecture() . ')';
			if ( $image->getImageId() == $wgOpenStackManagerInstanceDefaultImage ) {
				$default = $imageLabel;
			}
			$image_keys["$imageLabel"] = $image->getImageId();
		}
		if ( isset( $image_keys["$default"] ) ) {
			$default = $image_keys["$default"];
		}
		$instanceInfo['imageType'] = array(
			'type' => 'select',
			'section' => 'info',
			'options' => $image_keys,
			'default' => $default,
			'label-message' => 'openstackmanager-imagetype',
			'name' => 'imageType',
		);

		# Keypair names can't be translated. Get the keys, and make an array
		# where the name points to itself as a value
		# TODO: get keypairs as the user, not the admin
		# $keypairs = $this->userNova->getKeypairs();
		# $keypair_keys = array();
		# foreach ( array_keys( $keypairs ) as $keypair_key ) {
		#	$keypair_keys["$keypair_key"] = $keypair_key;
		# }
		# $instanceInfo['keypair'] = array(
		#	'type' => 'select',
		#	'section' => 'info',
		#	'options' => $keypair_keys,
		#	'label-message' => 'keypair',
		# );

		$domains = OpenStackNovaDomain::getAllDomains( 'local' );
		$domain_keys = array();
		foreach ( $domains as $domain ) {
			$domainname = $domain->getDomainName();
			$domain_keys["$domainname"] = $domainname;
		}
		$instanceInfo['domain'] = array(
			'type' => 'select',
			'section' => 'info',
			'options' => $domain_keys,
			'label-message' => 'openstackmanager-dnsdomain',
			'name' => 'domain',
		);

		$securityGroups = $this->adminNova->getSecurityGroups();
		$group_keys = array();
		$defaults = array();
		foreach ( $securityGroups as $securityGroup ) {
			if ( $securityGroup->getOwner() == $project ) {
				$securityGroupName = $securityGroup->getGroupName();
				$group_keys["$securityGroupName"] = $securityGroupName;
				if ( $securityGroupName == "default" ) {
					$defaults["default"] = "default";
				}
			}
		}
		$instanceInfo['groups'] = array(
			'type' => 'multiselect',
			'section' => 'info',
			'options' => $group_keys,
			'default' => $defaults,
			'label-message' => 'openstackmanager-securitygroups',
			'name' => 'groups',
		);

		$instanceInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
			'name' => 'project',
		);

		if ( $wgOpenStackManagerPuppetOptions['enabled'] ) {
			$this->setPuppetInfo( $instanceInfo );
		}

		$instanceInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'create',
			'name' => 'action',
		);

		$instanceForm = new SpecialNovaInstanceForm( $instanceInfo, 'openstackmanager-novainstance' );
		$instanceForm->setTitle( SpecialPage::getTitleFor( 'NovaInstance' ) );
		$instanceForm->addHeaderText( wfMsg( 'openstackmanager-createinstancepuppetwarning' ) . '<div class="mw-collapsible mw-collapsed">', 'puppetinfo' );
		$instanceForm->addFooterText( '</div>', 'puppetinfo' );
		$instanceForm->setSubmitID( 'openstackmanager-novainstance-createinstancesubmit' );
		$instanceForm->setSubmitCallback( array( $this, 'tryCreateSubmit' ) );
		$instanceForm->show();

		return true;
	}

	/**
	 * @return bool
	 */
	function configureInstance() {

		global $wgOpenStackManagerPuppetOptions;

		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-configureinstance' ) );

		$project = $this->getRequest()->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'sysadmin', $project ) ) {
			$this->notInRole( 'sysadmin' );
			return false;
		}
		$instanceid = $this->getRequest()->getText( 'instanceid' );
		$instanceInfo = array();
		$instanceInfo['instanceid'] = array(
			'type' => 'hidden',
			'default' => $instanceid,
			'name' => 'instanceid',
		);
		$instanceInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
			'name' => 'project',
		);

		if ( $wgOpenStackManagerPuppetOptions['enabled'] ) {
			$host = OpenStackNovaHost::getHostByInstanceId( $instanceid );
			if ( ! $host ) {
				$this->getOutput()->addWikiMsg( 'openstackmanager-nonexistenthost' );
				return false;
			}
			$puppetinfo = $host->getPuppetConfiguration();

			$this->setPuppetInfo( $instanceInfo, $puppetinfo );
		}

		$instanceInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'configure',
			'name' => 'action',
		);

		$instanceForm = new SpecialNovaInstanceForm( $instanceInfo, 'openstackmanager-novainstance' );
		$instanceForm->setTitle( SpecialPage::getTitleFor( 'NovaInstance' ) );
		$instanceForm->setSubmitID( 'novainstance-form-configureinstancesubmit' );
		$instanceForm->setSubmitCallback( array( $this, 'tryConfigureSubmit' ) );
		$instanceForm->show();

		return true;
	}

	function setPuppetInfo( &$instanceInfo, $puppetinfo=array() ) {
		$project = $instanceInfo['project']['default'];
		$projectGroups = OpenStackNovaPuppetGroup::getGroupList( $project );
		$this->setPuppetInfoByGroups( $instanceInfo, $puppetinfo, $projectGroups );
		$globalGroups = OpenStackNovaPuppetGroup::getGroupList();
		$this->setPuppetInfoByGroups( $instanceInfo, $puppetinfo, $globalGroups );
	}

	function setPuppetInfoByGroups( &$instanceInfo, $puppetinfo, $puppetGroups ) {
		foreach ( $puppetGroups as $puppetGroup ) {
			$classes = array();
			$defaults = array();
			$puppetgroupname = $puppetGroup->getName();
			$puppetgroupproject = $puppetGroup->getProject();
			if ( $puppetgroupproject ) {
				$section = 'puppetinfo/project';
			} else {
				$section = 'puppetinfo/global';
			}
			foreach ( $puppetGroup->getClasses() as $class ) {
				$classname = $class["name"];
				$classes["$classname"] = $classname;
				if ( $puppetinfo && in_array( $classname, $puppetinfo['puppetclass'] ) ) {
					$defaults["$classname"] = $classname;
				}
			}
			$instanceInfo["${puppetgroupname}"] = array(
				'type' => 'info',
				'section' => $section,
				'label' => Html::element( 'h3', array(), "$puppetgroupname:" ),
			);
			$instanceInfo["${puppetgroupname}-puppetclasses"] = array(
				'type' => 'multiselect',
				'section' => $section,
				'options' => $classes,
				'default' => $defaults,
				'name' => "${puppetgroupname}-puppetclasses",
			);
			foreach ( $puppetGroup->getVars() as $variable ) {
				$variablename = $variable["name"];
				$default = '';
				if ( $puppetinfo && array_key_exists( $variablename, $puppetinfo['puppetvar'] ) ) {
					$default = $puppetinfo['puppetvar']["$variablename"];
				}
				$instanceInfo["${puppetgroupname}-${variablename}"] = array(
					'type' => 'text',
					'section' => $section,
					'label' => $variablename,
					'default' => $default,
					'name' => "${puppetgroupname}-${variablename}",
				);
			}
		}
	}

	/**
	 * @return bool
	 */
	function deleteInstance() {


		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-deleteinstance' ) );

		$project = $this->getRequest()->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'sysadmin', $project ) ) {
			$this->notInRole( 'sysadmin' );
			return false;
		}
		$instanceid = $this->getRequest()->getText( 'instanceid' );
		if ( ! $this->getRequest()->wasPosted() ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-deleteinstancequestion', $instanceid );
		}
		$instanceInfo = array();
		$instanceInfo['instanceid'] = array(
			'type' => 'hidden',
			'default' => $instanceid,
			'name' => 'instanceid',
		);
		$instanceInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
			'name' => 'project',
		);
		$instanceInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'delete',
			'name' => 'action',
		);
		$instanceForm = new SpecialNovaInstanceForm( $instanceInfo, 'openstackmanager-novainstance' );
		$instanceForm->setTitle( SpecialPage::getTitleFor( 'NovaInstance' ) );
		$instanceForm->setSubmitID( 'novainstance-form-deleteinstancesubmit' );
		$instanceForm->setSubmitCallback( array( $this, 'tryDeleteSubmit' ) );
		$instanceForm->show();

		return true;
	}

	/**
	 * @return bool
	 */
	function rebootInstance() {


		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-rebootinstance' ) );

		$project = $this->getRequest()->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'sysadmin', $project ) ) {
			$this->notInRole( 'sysadmin' );
			return false;
		}
		$instanceid = $this->getRequest()->getText( 'instanceid' );
		if ( ! $this->getRequest()->wasPosted() ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-rebootinstancequestion', $instanceid );
		}
		$instanceInfo = array();
		$instanceInfo['instanceid'] = array(
			'type' => 'hidden',
			'default' => $instanceid,
			'name' => 'instanceid',
		);
		$instanceInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
			'name' => 'project',
		);
		$instanceInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'reboot',
			'name' => 'action',
		);
		$instanceForm = new SpecialNovaInstanceForm( $instanceInfo, 'openstackmanager-novainstance' );
		$instanceForm->setTitle( SpecialPage::getTitleFor( 'NovaInstance' ) );
		$instanceForm->setSubmitID( 'novainstance-form-deleteinstancesubmit' );
		$instanceForm->setSubmitCallback( array( $this, 'tryRebootSubmit' ) );
		$instanceForm->show();

		return true;
	}
	/**
	 * @return bool
	 */
	function getConsoleOutput() {


		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-consoleoutput' ) );

		$project = $this->getRequest()->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'sysadmin', $project ) ) {
			$this->notInRole( 'sysadmin' );
			return;
		}
		$instanceid = $this->getRequest()->getText( 'instanceid' );
		$consoleOutput = $this->userNova->getConsoleOutput( $instanceid );
		$out = Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backinstancelist' ) );
		$out .= Html::element( 'pre', array(), $consoleOutput );
		$this->getOutput()->addHTML( $out );
	}

	/**
	 * @return void
	 */
	function listInstances() {
		$this->setHeaders();
		$this->getOutput()->addModuleStyles( 'ext.openstack' );
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-instancelist' ) );

		$userProjects = $this->userLDAP->getProjects();

		$out = '';
		$instances = $this->adminNova->getInstances();
		$header = Html::element( 'th', array(), wfMsg( 'openstackmanager-instancename' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-instanceid' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-instancestate' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-instancetype' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-instanceip' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-instancepublicip' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-securitygroups' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-availabilityzone' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-imageid' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-launchtime' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-actions' ) );
		$projectArr = array();

		/**
		 * @var $instance OpenStackNovaInstance
		 */
		foreach ( $instances as $instance ) {
			$project = $instance->getOwner();
			if ( ! in_array( $project, $userProjects ) ) {
				continue;
			}
			$instanceOut = Html::element( 'td', array(), $instance->getInstanceName() );
			$instanceId = $instance->getInstanceId();
			$instanceId = htmlentities( $instanceId );
			$title = Title::newFromText( $instanceId, NS_NOVA_RESOURCE );
			$instanceIdLink = Linker::link( $title, $instanceId );
			$instanceOut .= Html::rawElement( 'td', array(), $instanceIdLink );
			$instanceOut .= Html::element( 'td', array(), $instance->getInstanceState() );
			$instanceOut .= Html::element( 'td', array(), $instance->getInstanceType() );
			$privateip = $instance->getInstancePrivateIP();
			$publicip = $instance->getInstancePublicIP();
			$instanceOut .= Html::element( 'td', array(), $privateip );
			if ( $privateip != $publicip ) {
				$instanceOut .= Html::element( 'td', array(), $publicip );
			} else {
				$instanceOut .= Html::element( 'td', array(), '' );
			}
			$groupsOut = '';
			foreach ( $instance->getSecurityGroups() as $group ) {
				$groupsOut .= Html::element( 'li', array(), $group );
			}
			$groupsOut = Html::rawElement( 'ul', array(), $groupsOut );
			$instanceOut .= Html::rawElement( 'td', array(), $groupsOut );
			$instanceOut .= Html::element( 'td', array(), $instance->getAvailabilityZone() );
			$instanceOut .= Html::element( 'td', array(), $instance->getImageId() );
			$instanceOut .= Html::element( 'td', array(), $instance->getLaunchTime() );
			$actions = '';
			if ( $this->userLDAP->inRole( 'sysadmin', $project ) ) {
				$msg = wfMsgHtml( 'openstackmanager-delete' );
				$link = Linker::link( $this->getTitle(), $msg, array(),
								  array( 'action' => 'delete',
									   'project' => $project,
									   'instanceid' => $instance->getInstanceId() ) );
				$actions = Html::rawElement( 'li', array(), $link );
				$msg = wfMsgHtml( 'openstackmanager-reboot' );
				$link = Linker::link( $this->getTitle(), $msg, array(),
								   array( 'action' => 'reboot',
										'project' => $project,
										'instanceid' => $instance->getInstanceId() ) );
				$actions .= Html::rawElement( 'li', array(), $link );
				$msg = wfMsgHtml( 'openstackmanager-configure' );
				$link = Linker::link( $this->getTitle(), $msg, array(),
								   array( 'action' => 'configure',
										'project' => $project,
										'instanceid' => $instance->getInstanceId() ) );
				$actions .= Html::rawElement( 'li', array(), $link );
				$msg = wfMsgHtml( 'openstackmanager-getconsoleoutput' );
				$link = Linker::link( $this->getTitle(), $msg, array(),
								   array( 'action' => 'consoleoutput',
										'project' => $project,
										'instanceid' => $instance->getInstanceId() ) );
				$actions .= Html::rawElement( 'li', array(), $link );
				$actions = Html::rawElement( 'ul', array(), $actions );
			}
			$instanceOut .= Html::rawElement( 'td', array(), $actions );
			if ( isset( $projectArr["$project"] ) ) {
				$projectArr["$project"] .= Html::rawElement( 'tr', array(), $instanceOut );
			} else {
				$projectArr["$project"] = Html::rawElement( 'tr', array(), $instanceOut );
			}
		}
		foreach ( $userProjects as $project ) {
			$action = '';
			if ( $this->userLDAP->inRole( 'sysadmin', $project ) ) {
				$action = Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-createinstance' ), array(), array( 'action' => 'create', 'project' => $project ) );
				$action = Html::rawElement( 'span', array( 'id' => 'novaaction' ), "[$action]" );
			}
			$projectName = Html::rawElement( 'span', array( 'class' => 'mw-customtoggle-' . $project, 'id' => 'novaproject' ), $project );
			$out .= Html::rawElement( 'h2', array(), "$projectName $action" );
			$projectOut = '';
			if ( isset( $projectArr["$project"] ) ) {
				$projectOut .= $header;
				$projectOut .= $projectArr["$project"];
				$projectOut = Html::rawElement( 'table', array( 'id' => 'novainstancelist', 'class' => 'wikitable sortable' ), $projectOut );
			}
			$out .= Html::rawElement( 'div', array( 'class' => 'mw-collapsible', 'id' => 'mw-customcollapsible-' . $project ), $projectOut );
		}

		$this->getOutput()->addHTML( $out );
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryCreateSubmit( $formData, $entryPoint = 'internal' ) {
		$domain = OpenStackNovaDomain::getDomainByName( $formData['domain'] );
		if ( !$domain ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-invaliddomain' );
			return true;
		}
		$instance = $this->userNova->createInstance( $formData['instancename'], $formData['imageType'], '', $formData['instanceType'], $formData['availabilityZone'], $formData['groups'] );
		if ( $instance ) {
			$host = OpenStackNovaHost::addHost( $instance, $domain, $this->getPuppetInfo( $formData ) );

			if ( $host ) {
				$title = Title::newFromText( $this->getOutput()->getPageTitle() );
				$job = new OpenStackNovaHostJob( $title, array( 'instanceid' => $instance->getInstanceId() ) );
				$job->insert();
				$this->getOutput()->addWikiMsg( 'openstackmanager-createdinstance', $instance->getInstanceID(),
					$instance->getImageId(), $host->getFullyQualifiedHostName() );
			} else {
				$this->userNova->terminateInstance( $instance->getInstanceId() );
				$this->getOutput()->addWikiMsg( 'openstackmanager-createfailedldap' );
			}
			# TODO: also add puppet
		} else {
			$this->getOutput()->addWikiMsg( 'openstackmanager-createinstancefailed' );
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backinstancelist' ) );

		$this->getOutput()->addHTML( $out );
		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryDeleteSubmit( $formData, $entryPoint = 'internal' ) {
		$instance = $this->adminNova->getInstance( $formData['instanceid'] );
		if ( ! $instance ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-nonexistanthost' );
			return true;
		}
		$instancename = $instance->getInstanceName();
		$instanceid = $instance->getInstanceId();
		$success = $this->userNova->terminateInstance( $instanceid );
		if ( $success ) {
			$instance->deleteArticle();
			$success = OpenStackNovaHost::deleteHostByInstanceId( $instanceid );
			if ( $success ) {
				$this->getOutput()->addWikiMsg( 'openstackmanager-deletedinstance', $instanceid );
			} else {
				$this->getOutput()->addWikiMsg( 'openstackmanager-deletedinstance-faileddns', $instancename, $instanceid );
			}
		} else {
			$this->getOutput()->addWikiMsg( 'openstackmanager-deleteinstancefailed' );
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backinstancelist' ) );

		$this->getOutput()->addHTML( $out );
		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryRebootSubmit( $formData, $entryPoint = 'internal' ) {
		$instanceid = $formData['instanceid'];
		$success = $this->userNova->rebootInstance( $instanceid );
		if ( $success ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-rebootedinstance', $instanceid );
		} else {
			$this->getOutput()->addWikiMsg( 'openstackmanager-rebootinstancefailed' );
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backinstancelist' ) );

		$this->getOutput()->addHTML( $out );
		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryConfigureSubmit( $formData, $entryPoint = 'internal' ) {
		$instance = $this->adminNova->getInstance( $formData['instanceid'] );
		$host = $instance->getHost();
		if ( $host ) {
			$success = $host->modifyPuppetConfiguration( $this->getPuppetInfo( $formData ) );
			if ( $success ) {
				$instance->editArticle();
				$this->getOutput()->addWikiMsg( 'openstackmanager-modifiedinstance' );
			} else {
				$this->getOutput()->addWikiMsg( 'openstackmanager-modifyinstancefailed' );
			}
		} else {
			$this->getOutput()->addWikiMsg( 'openstackmanager-nonexistanthost' );
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backinstancelist' ) );

		$this->getOutput()->addHTML( $out );
		return true;
	}

	function getPuppetInfo( $formData ) {
		global $wgOpenStackManagerPuppetOptions;

		$puppetinfo = array();
		if ( $wgOpenStackManagerPuppetOptions['enabled'] ) {
			$puppetGroups = OpenStackNovaPuppetGroup::getGroupList( $formData['project'] );
			$this->getPuppetInfoByGroup( $puppetinfo, $puppetGroups, $formData );
			$puppetGroups = OpenStackNovaPuppetGroup::getGroupList();
			$this->getPuppetInfoByGroup( $puppetinfo, $puppetGroups, $formData );
		}
		return $puppetinfo;
	}

	function getPuppetInfoByGroup( &$puppetinfo, $puppetGroups, $formData ) {
		foreach ( $puppetGroups as $puppetGroup ) {
			$puppetgroupname = $puppetGroup->getName();
			foreach ( $puppetGroup->getClasses() as $class ) {
				if ( in_array( $class["name"], $formData["$puppetgroupname-puppetclasses"] ) ) {
					$classname = $class["name"];
					if ( !in_array( $classname, $puppetinfo['classes'] ) ) {
						$puppetinfo['classes'][] = $classname;
					}
				}
			}
			foreach ( $puppetGroup->getVars() as $variable ) {
				$variablename = $variable["name"];
				if ( isset ( $formData["$puppetgroupname-$variablename"] ) && trim( $formData["$puppetgroupname-$variablename"] ) ) {
					$puppetinfo['variables']["$variablename"] = $formData["$puppetgroupname-$variablename"];
				}
			}
		}
	}

}

class SpecialNovaInstanceForm extends HTMLForm {
}
