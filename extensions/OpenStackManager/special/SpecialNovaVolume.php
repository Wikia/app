<?php
class SpecialNovaVolume extends SpecialNova {

	/**
	 * @var OpenStackNovaController
	 */
	var $adminNova, $userNova;

	/**
	 * @var OpenStackNovaUser
	 */
	var $userLDAP;

	function __construct() {
		parent::__construct( 'NovaVolume' );
	}

	function execute( $par ) {
		global $wgOpenStackManagerNovaAdminKeys;

		if ( !$this->getUser()->isLoggedIn() ) {
			$this->notLoggedIn();
			return;
		}
		$this->userLDAP = new OpenStackNovaUser();
		if ( !$this->userLDAP->exists() ) {
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
			$this->createVolume();
		} elseif ( $action == "delete" ) {
			if ( ! $this->userLDAP->inProject( $project ) ) {
				$this->notInProject();
				return;
			}
			$this->deleteVolume();
		} elseif ( $action == "attach" ) {
			if ( ! $this->userLDAP->inProject( $project ) ) {
				$this->notInProject();
				return;
			}
			$this->attachVolume();
		} elseif ( $action == "detach" ) {
			if ( ! $this->userLDAP->inProject( $project ) ) {
				$this->notInProject();
				return;
			}
			$this->detachVolume();
		} else {
			$this->listVolumes();
		}
	}

	/**
	 * @return bool
	 */
	function createVolume() {
		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-createvolume' ) );

		$project = $this->getRequest()->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'sysadmin', $project ) ) {
			$this->notInRole( 'sysadmin' );
			return false;
		}
		$volumeInfo = array();
		$volumeInfo['volumename'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-volumename',
			'validation-callback' => array( $this, 'validateText' ),
			'default' => '',
			'section' => 'volume/info',
			'name' => 'volumename',
		);
		$volumeInfo['volumedescription'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-volumedescription',
			'default' => '',
			'section' => 'volume/info',
			'name' => 'volumedescription',
		);


		# Availability zone names can't be translated. Get the keys, and make an array
		# where the name points to itself as a value
		$availabilityZones = $this->adminNova->getAvailabilityZones();
		$availabilityZone_keys = array();
		foreach ( array_keys( $availabilityZones ) as $availabilityZone_key ) {
			$availabilityZone_keys["$availabilityZone_key"] = $availabilityZone_key;
		}
		$volumeInfo['availabilityZone'] = array(
			'type' => 'select',
			'section' => 'volume/info',
			'options' => $availabilityZone_keys,
			'label-message' => 'openstackmanager-availabilityzone',
			'name' => 'availabilityZone',
		);

		$volumeInfo['volumeSize'] = array(
			'type' => 'int',
			'section' => 'volume/info',
			'label-message' => 'openstackmanager-volumesize',
			'name' => 'volumeSize',
		);

		$volumeInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
			'name' => 'project',
		);
		$volumeInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'create',
			'name' => 'action',
		);

		$volumeForm = new SpecialNovaVolumeForm( $volumeInfo, 'openstackmanager-novavolume' );
		$volumeForm->setTitle( SpecialPage::getTitleFor( 'NovaVolume' ) );
		$volumeForm->setSubmitID( 'openstackmanager-novavolume-createvolumesubmit' );
		$volumeForm->setSubmitCallback( array( $this, 'tryCreateSubmit' ) );
		$volumeForm->show();

		return true;
	}

	/**
	 * @return bool
	 */
	function deleteVolume() {


		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-deletevolume' ) );

		$project = $this->getRequest()->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'sysadmin', $project ) ) {
			$this->notInRole( 'sysadmin' );
			return false;
		}
		$volumeid = $this->getRequest()->getText( 'volumeid' );
		if ( ! $this->getRequest()->wasPosted() ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-deletevolumequestion', $volumeid );
		}
		$volumeInfo = array();
		$volumeInfo['volumeid'] = array(
			'type' => 'hidden',
			'default' => $volumeid,
			'name' => 'volumeid',
		);
		$volumeInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
			'name' => 'project',
		);
		$volumeInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'delete',
			'name' => 'action',
		);
		$volumeForm = new SpecialNovaVolumeForm( $volumeInfo, 'openstackmanager-novavolume' );
		$volumeForm->setTitle( SpecialPage::getTitleFor( 'NovaVolume' ) );
		$volumeForm->setSubmitID( 'novavolume-form-deletevolumesubmit' );
		$volumeForm->setSubmitCallback( array( $this, 'tryDeleteSubmit' ) );
		$volumeForm->show();

		return true;
	}

	/**
	 * @return bool
	 */
	function attachVolume() {


		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-attachvolume' ) );

		$project = $this->getRequest()->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'sysadmin', $project ) ) {
			$this->notInRole( 'sysadmin' );
			return false;
		}
		$instances = $this->userNova->getInstances();
		$instance_keys = array();
		foreach ( $instances as $instance ) {
			if ( $instance->getOwner() == $project ) {
				$instancename = $instance->getInstanceName();
				$instanceid = $instance->getInstanceId();
				$instance_keys["$instancename"] = $instanceid;
			}
		}
		$volumeInfo = array();
		$volumeInfo['volumeinfo'] = array(
			'type' => 'info',
			'label-message' => 'openstackmanager-volumename',
			'default' => $this->getRequest()->getText( 'volumeid' ),
			'section' => 'volume/info',
			'name' => 'volumeinfo',
		);
		$volumeInfo['volumeid'] = array(
			'type' => 'hidden',
			'default' => $this->getRequest()->getText( 'volumeid' ),
			'name' => 'volumeid',
		);
		$volumeInfo['volumedescription'] = array(
			'type' => 'info',
			'label-message' => 'openstackmanager-volumedescription',
			'section' => 'volume/info',
			'name' => 'volumedescription',
		);
		$volumeInfo['instanceid'] = array(
			'type' => 'select',
			'label-message' => 'openstackmanager-instancename',
			'options' => $instance_keys,
			'section' => 'volume/info',
			'name' => 'instanceid',
		);
		$volumeInfo['device'] = array(
			'type' => 'select',
			'label-message' => 'openstackmanager-device',
			'options' => $this->getDrives(),
			'section' => 'volume/info',
			'name' => 'device',
		);
		$volumeInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
			'name' => 'project',
		);
		$volumeInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'attach',
			'name' => 'action',
		);
		$volumeForm = new SpecialNovaVolumeForm( $volumeInfo, 'openstackmanager-novavolume' );
		$volumeForm->setTitle( SpecialPage::getTitleFor( 'NovaVolume' ) );
		$volumeForm->setSubmitID( 'novavolume-form-attachvolumesubmit' );
		$volumeForm->setSubmitCallback( array( $this, 'tryAttachSubmit' ) );
		$volumeForm->show();

		return true;
	}

	/**
	 * @return bool
	 */
	function detachVolume() {


		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-detachvolume' ) );

		$project = $this->getRequest()->getText( 'project' );
		if ( ! $this->userLDAP->inRole( 'sysadmin', $project ) ) {
			$this->notInRole( 'sysadmin' );
			return false;
		}
		$volumeInfo = array();
		$volumeInfo['volumeinfo'] = array(
			'type' => 'info',
			'label-message' => 'openstackmanager-volumename',
			'default' => $this->getRequest()->getText( 'volumeid' ),
			'section' => 'volume/info',
			'name' => 'volumeinfo',
		);
		$volumeInfo['force'] = array(
			'type' => 'toggle',
			'label-message' => 'openstackmanager-forcedetachment',
			'help-message' => 'openstackmanager-forcedetachmenthelp',
			'section' => 'volume/info',
			'name' => 'volumeinfo',
		);
		$volumeInfo['volumeid'] = array(
			'type' => 'hidden',
			'default' => $this->getRequest()->getText( 'volumeid' ),
			'name' => 'volumeid',
		);
		$volumeInfo['project'] = array(
			'type' => 'hidden',
			'default' => $project,
			'name' => 'project',
		);
		$volumeInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'detach',
			'name' => 'action',
		);
		$volumeForm = new SpecialNovaVolumeForm( $volumeInfo, 'openstackmanager-novavolume' );
		$volumeForm->setTitle( SpecialPage::getTitleFor( 'NovaVolume' ) );
		$volumeForm->setSubmitID( 'novavolume-form-detachvolumesubmit' );
		$volumeForm->setSubmitCallback( array( $this, 'tryDetachSubmit' ) );
		$volumeForm->show();

		return true;
	}
	/**
	 * @return void
	 */
	function listVolumes() {
		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-volumelist' ) );

		$userProjects = $this->userLDAP->getProjects();

		$out = '';
		$volumes = $this->adminNova->getVolumes();
		$header = Html::element( 'th', array(), wfMsg( 'openstackmanager-volumename' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-volumeid' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-volumedescription' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-volumestate' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-volumeattachmentinstance' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-volumeattachmentdevice' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-volumeattachmentstatus' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-volumesize' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-volumedeleteonvolumedelete' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-availabilityzone' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-volumecreationtime' ) );
		$header .= Html::element( 'th', array(), wfMsg( 'openstackmanager-actions' ) );
		$projectArr = array();
		foreach ( $volumes as $volume ) {
			$project = $volume->getOwner();
			if ( ! in_array( $project, $userProjects ) ) {
				continue;
			}
			$volumeOut = Html::element( 'td', array(), $volume->getVolumeName() );
			$volumeId = $volume->getVolumeId();
			$volumeId = htmlentities( $volumeId );
			$title = Title::newFromText( $volumeId, NS_NOVA_RESOURCE );
			$volumeIdLink = Linker::link( $title, $volumeId );
			$volumeOut .= Html::rawElement( 'td', array(), $volumeIdLink );
			$volumeOut .= Html::element( 'td', array(), $volume->getVolumeDescription() );
			$volumeOut .= Html::element( 'td', array(), $volume->getVolumeStatus() );
			$volumeOut .= Html::element( 'td', array(), $volume->getAttachedInstanceId() );
			$volumeOut .= Html::element( 'td', array(), $volume->getAttachedDevice() );
			$volumeOut .= Html::element( 'td', array(), $volume->getAttachmentStatus() );
			$volumeOut .= Html::element( 'td', array(), $volume->getVolumeSize() );
			$volumeOut .= Html::element( 'td', array(), $volume->deleteOnInstanceDeletion() );
			$volumeOut .= Html::element( 'td', array(), $volume->getVolumeAvailabilityZone() );
			$volumeOut .= Html::element( 'td', array(), $volume->getVolumeCreationTime() );
			$msg = wfMsgHtml( 'openstackmanager-delete' );
			$link = Linker::link( $this->getTitle(), $msg, array(),
								  array( 'action' => 'delete',
									   'project' => $project,
									   'volumeid' => $volume->getVolumeId() ) );
			$actions = Html::rawElement( 'li', array(), $link );
			#$msg = wfMsgHtml( 'openstackmanager-rename' );
			#$actions .= Linker::link( $this->getTitle(), $msg, array(),
			#					   array( 'action' => 'rename',
			#							'project' => $project,
			#							'volumeid' => $volume->getVolumeId() ) );
			$msg = wfMsgHtml( 'openstackmanager-attach' );
			$link = Linker::link( $this->getTitle(), $msg, array(),
								   array( 'action' => 'attach',
										'project' => $project,
										'volumeid' => $volume->getVolumeId() ) );
			$actions .= Html::rawElement( 'li', array(), $link );
			$msg = wfMsgHtml( 'openstackmanager-detach' );
			$link = Linker::link( $this->getTitle(), $msg, array(),
								   array( 'action' => 'detach',
										'project' => $project,
										'volumeid' => $volume->getVolumeId() ) );
			$actions .= Html::rawElement( 'li', array(), $link );
			$actions = Html::rawElement( 'ul', array(), $actions );
			$volumeOut .= Html::rawElement( 'td', array(), $actions );
			if ( isset( $projectArr["$project"] ) ) {
				$projectArr["$project"] .= Html::rawElement( 'tr', array(), $volumeOut );
			} else {
				$projectArr["$project"] = Html::rawElement( 'tr', array(), $volumeOut );
			}
		}
		foreach ( $userProjects as $project ) {
			$out .= Html::element( 'h2', array(), $project );
			$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-createvolume' ), array(),
							   array( 'action' => 'create', 'project' => $project ) );
			if ( isset( $projectArr["$project"] ) ) {
				$projectOut = $header;
				$projectOut .= $projectArr["$project"];
				$out .= Html::rawElement( 'table',
										  array( 'id' => 'novavolumelist', 'class' => 'wikitable sortable collapsible' ), $projectOut );
			}
		}

		$this->getOutput()->addHTML( $out );
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryCreateSubmit( $formData, $entryPoint = 'internal' ) {
		$volume = $this->userNova->createVolume( $formData['availabilityZone'], $formData['volumeSize'], $formData['volumename'], $formData['volumedescription'] );
		if ( $volume ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-createdvolume', $volume->getVolumeID() );
		} else {
			$this->getOutput()->addWikiMsg( 'openstackmanager-createevolumefailed' );
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backvolumelist' ) );

		$this->getOutput()->addHTML( $out );
		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryDeleteSubmit( $formData, $entryPoint = 'internal' ) {
		$volume = $this->adminNova->getVolume( $formData['volumeid'] );
		if ( ! $volume ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-nonexistantvolume' );
			return true;
		}
		$volumeid = $volume->getVolumeId();
		$success = $this->userNova->deleteVolume( $volumeid );
		if ( $success ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-deletedvolume', $volumeid );
		} else {
			$this->getOutput()->addWikiMsg( 'openstackmanager-deletevolumefailed' );
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backvolumelist' ) );

		$this->getOutput()->addHTML( $out );
		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryAttachSubmit( $formData, $entryPoint = 'internal' ) {
		$success = $this->userNova->attachVolume( $formData['volumeid'], $formData['instanceid'], $formData['device'] );
		if ( $success ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-attachedvolume' );
		} else {
			$this->getOutput()->addWikiMsg( 'openstackmanager-attachvolumefailed' );
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backvolumelist' ) );

		$this->getOutput()->addHTML( $out );
		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryDetachSubmit( $formData, $entryPoint = 'internal' ) {
		if ( isset( $formData['force'] ) && $formData['force'] ) {
			$force = true;
		} else {
			$force = false;
		}
		$success = $this->userNova->detachVolume( $formData['volumeid'], $force );
		if ( $success ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-detachedvolume' );
		} else {
			$this->getOutput()->addWikiMsg( 'openstackmanager-detachvolumefailed' );
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backvolumelist' ) );

		$this->getOutput()->addHTML( $out );
		return true;
	}

	/**
	 * Return an array of drive devices
	 *
	 * @return string
	 */
	function getDrives() {
		$drives = array();
		foreach ( range('a', 'z') as $letter ) {
			$drive = '/dev/vd' . $letter;
			$drives["$drive"] = $drive;
		}
		foreach ( range('a', 'z') as $letter ) {
			$drive = '/dev/vda' . $letter;
			$drives["$drive"] = $drive;
		}

		return $drives;
	}
}

class SpecialNovaVolumeForm extends HTMLForm {
}
