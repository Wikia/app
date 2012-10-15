<?php

abstract class SpecialNova extends SpecialPage {

	/**
	 * @return void
	 */
	function notLoggedIn() {
		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-notloggedin' ) );
		$this->getOutput()->addWikiMsg( 'openstackmanager-mustbeloggedin' );
	}

	/**
	 * @return void
	 */
	function noCredentials() {
		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-nonovacred' ) );
		$this->getOutput()->addWikiMsg( 'openstackmanager-nonovacred-admincreate' );
	}

	/**
	 * @return void
	 */
	function notInProject() {
		$this->setHeaders();
		$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-noaccount' ) );
		$this->getOutput()->addWikiMsg( 'openstackmanager-noaccount2' );
	}

	/**
	 * @param  $role
	 * @return void
	 */
	function notInRole( $role ) {
		$this->setHeaders();
		if ( $role == 'sysadmin' ) {
			$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-needsysadminrole' ) );
			$this->getOutput()->addWikiMsg( 'openstackmanager-needsysadminrole2' );
		} elseif ( $role == 'netadmin' ) {
			$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-neednetadminrole' ) );
			$this->getOutput()->addWikiMsg( 'openstackmanager-neednetadminrole2' );
		} elseif ( $role == 'cloudadmin' ) {
			$this->getOutput()->setPagetitle( wfMsg( 'openstackmanager-needcloudadminrole' ) );
			$this->getOutput()->addWikiMsg( 'openstackmanager-needcloudadminrole2' );
		}
	}

	/**
	 * @param  $resourcename
	 * @param  $error
	 * @param  $alldata
	 * @return bool|string
	 */
	function validateText( $resourcename, $alldata ) {
		if ( ! preg_match( "/^[a-z][a-z0-9-]*$/", $resourcename ) ) {
			return Xml::element( 'span', array( 'class' => 'error' ), wfMsg( 'openstackmanager-badresourcename' ) );
		} else {
			return true;
		}
	}

	/**
	 * @param  $resourcename
	 * @param  $error
	 * @param  $alldata
	 * @return bool|string
	 */
	function validateDomain( $resourcename, $alldata ) {
		if ( ! preg_match( "/^[a-z\*][a-z0-9\-]*$/", $resourcename ) ) {
			return Xml::element( 'span', array( 'class' => 'error' ), wfMsg( 'openstackmanager-badresourcename' ) );
		} else {
			return true;
		}
	}

}
