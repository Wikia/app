<?php
class SpecialNovaSudoer extends SpecialNova {

	var $userLDAP;

	function __construct() {
		parent::__construct( 'NovaSudoer', 'manageproject' );

		$this->userLDAP = new OpenStackNovaUser();
	}

	function execute( $par ) {
		if ( !$this->getUser()->isLoggedIn() ) {
			$this->notLoggedIn();
			return;
		}
		if ( !$this->userLDAP->exists() ) {
			$this->noCredentials();
			return;
		}

		$action = $this->getRequest()->getVal( 'action' );
		if ( $action == "delete" ) {
			$this->deleteSudoer();
		} elseif ( $action == "modify" ) {
			$this->modifySudoer();
		} else {
			$this->listSudoers();
		}
	}

	/**
	 * @return bool
	 */
	function deleteSudoer() {


		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-deletesudoer' ) );

		$sudoername = $this->getRequest()->getText( 'sudoername' );
		if ( ! $this->getRequest()->wasPosted() ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-deletesudoer-confirm', $sudoername );
		}
		$sudoerInfo = array();
		$sudoerInfo['sudoername'] = array(
			'type' => 'hidden',
			'default' => $sudoername,
			'name' => 'sudoername',
		);
		$sudoerInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'delete',
			'name' => 'action',
		);
		$sudoerForm = new SpecialNovaSudoerForm( $sudoerInfo, 'openstackmanager-novasudoer' );
		$sudoerForm->setTitle( SpecialPage::getTitleFor( 'NovaSudoer' ) );
		$sudoerForm->setSubmitID( 'novasudoer-form-deletesudoersubmit' );
		$sudoerForm->setSubmitCallback( array( $this, 'tryDeleteSubmit' ) );
		$sudoerForm->show();

		return true;
	}

	/**
	 * @return bool
	 */
	function modifySudoer() {


		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-modifysudoer' ) );

		$sudoername = $this->getRequest()->getText( 'sudoername' );
		$sudoer = OpenStackNovaSudoer::getSudoerByName( $sudoername );
		$users = implode( ',', $sudoer->getSudoerUsers() );
		$hosts = implode( ',', $sudoer->getSudoerHosts() );
		$commands = implode( ',', $sudoer->getSudoerCommands() );
		$options = implode( ',', $sudoer->getSudoerOptions() );
		$sudoerInfo = array();
		$sudoerInfo['sudoernameinfo'] = array(
			'type' => 'info',
			'label-message' => 'openstackmanager-sudoername',
			'default' => $sudoername,
			'section' => 'sudoer',
			'name' => 'sudoernameinfo',
		);
		$sudoerInfo['sudoername'] = array(
			'type' => 'hidden',
			'default' => $sudoername,
			'name' => 'sudoername',
		);
		$sudoerInfo['users'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-sudoerusers',
			'default' => $users,
			'section' => 'sudoer',
			'help-message' => 'openstackmanager-commadelimiter',
			'name' => 'users',
		);
		$sudoerInfo['hosts'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-sudoerhosts',
			'default' => $hosts,
			'section' => 'sudoer',
			'help-message' => 'openstackmanager-commadelimiter',
			'name' => 'hosts',
		);
		$sudoerInfo['commands'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-sudoercommands',
			'default' => $commands,
			'section' => 'sudoer',
			'help-message' => 'openstackmanager-commadelimiter',
			'name' => 'commands',
		);
		$sudoerInfo['options'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-sudoeroptions',
			'default' => $options,
			'section' => 'sudoer',
			'help-message' => 'openstackmanager-commadelimiter',
			'name' => 'options',
		);
		$sudoerInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'modify',
			'name' => 'action',
		);

		$sudoerForm = new SpecialNovaSudoerForm( $sudoerInfo, 'openstackmanager-novasudoer' );
		$sudoerForm->setTitle( SpecialPage::getTitleFor( 'NovaSudoer' ) );
		$sudoerForm->setSubmitID( 'novasudoer-form-createsudoersubmit' );
		$sudoerForm->setSubmitCallback( array( $this, 'tryModifySubmit' ) );
		$sudoerForm->show();

		return true;
	}

	/**
	 * @return void
	 */
	function listSudoers() {
		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-sudoerlist' ) );

		$sudoerInfo = array();
		$sudoerInfo['sudoername'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-sudoername',
			'default' => '',
			'section' => 'sudoer',
			'name' => 'sudoername',
		);
		$sudoerInfo['users'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-sudoerusers',
			'default' => '',
			'section' => 'sudoer',
			'name' => 'users',
		);
		$sudoerInfo['hosts'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-sudoerhosts',
			'default' => '',
			'section' => 'sudoer',
			'name' => 'hosts',
		);
		$sudoerInfo['commands'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-sudoercommands',
			'default' => '',
			'section' => 'sudoer',
			'name' => 'commands',
		);
		$sudoerInfo['options'] = array(
			'type' => 'text',
			'label-message' => 'openstackmanager-sudoeroptions',
			'default' => '',
			'section' => 'sudoer',
			'name' => 'options',
		);
		$sudoerInfo['action'] = array(
			'type' => 'hidden',
			'default' => 'create',
			'name' => 'action',
		);

		$sudoerForm = new SpecialNovaSudoerForm( $sudoerInfo, 'openstackmanager-novasudoer' );
		$sudoerForm->setTitle( SpecialPage::getTitleFor( 'NovaSudoer' ) );
		$sudoerForm->setSubmitID( 'novasudoer-form-createsudoersubmit' );
		$sudoerForm->setSubmitCallback( array( $this, 'tryCreateSubmit' ) );
		$sudoerForm->show();

		$out = '';
		$sudoersOut = Html::element( 'th', array(), wfMsg( 'openstackmanager-sudoername' ) );
		$sudoersOut .= Html::element( 'th', array(), wfMsg( 'openstackmanager-sudoerusers' ) );
		$sudoersOut .= Html::element( 'th', array(), wfMsg( 'openstackmanager-sudoerhosts' ) );
		$sudoersOut .= Html::element( 'th', array(), wfMsg( 'openstackmanager-sudoercommands' ) );
		$sudoersOut .= Html::element( 'th', array(), wfMsg( 'openstackmanager-sudoeroptions' ) );
		$sudoersOut .= Html::element( 'th', array(), wfMsg( 'openstackmanager-actions' ) );
		$sudoers = OpenStackNovaSudoer::getAllSudoers();
		foreach ( $sudoers as $sudoer ) {
			$sudoerName = $sudoer->getSudoerName();
			$sudoerOut = Html::element( 'td', array(), $sudoerName );
			$users = $sudoer->getSudoerUsers();
			$sudoerUsers = '';
			foreach ( $users as $user ) {
				$sudoerUsers .= Html::element( 'li', array(), $user );
			}
			$sudoerUsers = Html::rawElement( 'ul', array(), $sudoerUsers );
			$sudoerOut .= Html::rawElement( 'td', array(), $sudoerUsers );
			$hosts = $sudoer->getSudoerHosts();
			$sudoerHosts = '';
			foreach ( $hosts as $host ) {
				$sudoerHosts .= Html::element( 'li', array(), $host );
			}
			$sudoerHosts = Html::rawElement( 'ul', array(), $sudoerHosts );
			$sudoerOut .= Html::rawElement( 'td', array(), $sudoerHosts );
			$commands = $sudoer->getSudoerCommands();
			$sudoerCommands = '';
			foreach ( $commands as $command ) {
				$sudoerCommands .= Html::element( 'li', array(), $command );
			}
			$sudoerCommands = Html::rawElement( 'ul', array(), $sudoerCommands );
			$sudoerOut .= Html::rawElement( 'td', array(), $sudoerCommands );
			$options = $sudoer->getSudoerOptions();
			$sudoerOptions = '';
			foreach ( $options as $option ) {
				$sudoerOptions .= Html::element( 'li', array(), $option );
			}
			$sudoerOptions = Html::rawElement( 'ul', array(), $sudoerOptions );
			$sudoerOut .= Html::rawElement( 'td', array(), $sudoerOptions );
			$msg = wfMsgHtml( 'openstackmanager-modify' );
			$link = Linker::link( $this->getTitle(), $msg, array(),
							   array( 'action' => 'modify', 'sudoername' => $sudoerName ) );
			$actions = Html::rawElement( 'li', array(), $link );
			$msg = wfMsgHtml( 'openstackmanager-delete' );
			$link = Linker::link( $this->getTitle(), $msg, array(),
							   array( 'action' => 'delete', 'sudoername' => $sudoerName ) );
			$actions .= Html::rawElement( 'li', array(), $link );
			$actions = Html::rawElement( 'ul', array(), $actions );
			$sudoerOut .= Html::rawElement( 'td', array(), $actions );
			$sudoersOut .= Html::rawElement( 'tr', array(), $sudoerOut );
		}
		if ( $sudoers ) {
			$out .= Html::rawElement( 'table', array( 'class' => 'wikitable sortable collapsible' ), $sudoersOut );
		}

		$this->getOutput()->addHTML( $out );
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryCreateSubmit( $formData, $entryPoint = 'internal' ) {
		if ( $formData['users'] ) {
			$users = explode( ',', $formData['users'] );
		} else {
			$users = array();
		}
		if ( $formData['hosts'] ) {
			$hosts = explode( ',', $formData['hosts'] );
		} else {
			$hosts = array();
		}
		if ( $formData['commands'] ) {
			$commands = explode( ',', $formData['commands'] );
		} else {
			$commands = array();
		}
		if ( $formData['options'] ) {
			$options = explode( ',', $formData['options'] );
		} else {
			$options = array();
		}
		$success = OpenStackNovaSudoer::createSudoer( $formData['sudoername'], $users, $hosts, $commands, $options );
		if ( ! $success ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-createsudoerfailed' );
			return false;
		}
		$this->getOutput()->addWikiMsg( 'openstackmanager-createdsudoer' );

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-addadditionalsudoer' ) );
		$this->getOutput()->addHTML( $out );

		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryDeleteSubmit( $formData, $entryPoint = 'internal' ) {

		$success = OpenStackNovaSudoer::deleteSudoer( $formData['sudoername'] );
		if ( $success ) {
			$this->getOutput()->addWikiMsg( 'openstackmanager-deletedsudoer' );
		} else {
			$this->getOutput()->addWikiMsg( 'openstackmanager-failedeletedsudoer' );
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backsudoerlist' ) );
		$this->getOutput()->addHTML( $out );

		return true;
	}

	/**
	 * @param  $formData
	 * @param string $entryPoint
	 * @return bool
	 */
	function tryModifySubmit( $formData, $entryPoint = 'internal' ) {
		$sudoer = OpenStackNovaSudoer::getSudoerByName( $formData['sudoername'] );
		if ( $sudoer ) {
			if ( $formData['users'] ) {
				$users = explode( ',', $formData['users'] );
			} else {
				$users = array();
			}
			if ( $formData['hosts'] ) {
				$hosts = explode( ',', $formData['hosts'] );
			} else {
				$hosts = array();
			}
			if ( $formData['commands'] ) {
				$commands = explode( ',', $formData['commands'] );
			} else {
				$commands = array();
			}
			if ( $formData['options'] ) {
				$options = explode( ',', $formData['options'] );
			} else {
				$options = array();
			}
			$success = $sudoer->modifySudoer( $users, $hosts, $commands, $options );
			if ( ! $success ) {
				$this->getOutput()->addWikiMsg( 'openstackmanager-modifysudoerfailed' );
				return true;
			}
			$this->getOutput()->addWikiMsg( 'openstackmanager-modifiedsudoer' );
		} else {
			$this->getOutput()->addWikiMsg( 'openstackmanager-nonexistantsudoer' );
		}

		$out = '<br />';
		$out .= Linker::link( $this->getTitle(), wfMsgHtml( 'openstackmanager-backsudoerlist' ) );
		$this->getOutput()->addHTML( $out );

		return true;
	}

}

class SpecialNovaSudoerForm extends HTMLForm {
}
