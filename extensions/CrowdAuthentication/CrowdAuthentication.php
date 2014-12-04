<?php
/* Copyright (c) 2007 River Tarnell <river@wikimedia.org>.        */
/**
 * Permission is granted to anyone to use this software for any purpose,
 * including commercial applications, and to alter it and redistribute it
 * freely. This software is provided 'as-is', without any express or implied
 * warranty.
 */
/* $Id: CrowdAuthentication.php 106136 2011-12-13 23:49:33Z brion $ */
/**
 * AuthPlugin that authenticates users against Atlassian Crowd.
 *
 * To use it, add something like this to LocalSettings.php:
 *
 *    require_once("$IP/extensions/CrowdAuthentication/CrowdAuthentication.php");
 *    $caApplicationName = 'mediawiki';
 *    $caApplicationPassword = 'whatever';
 *    $caCrowdServerUrl = 'http://localhost:8095/crowd/services';
 *    $caDefaultGroups = array("jira-users", "confluence-users");
 *    $caImportGroups = true;
 *    $caOverwriteLocalGroups = false;
 *    $wgAuth = new CrowdAuthenticator();
 *
 */

$wgExtensionCredits['other'][] = array(
	'path'           => __FILE__,
	'name'           => 'Crowd Authentication Plugin',
	'author'         => 'River Tarnell',
	'version'        => '1.1',
	'descriptionmsg' => 'crowdauthentication-desc',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:CrowdAuthentication'
);

$wgExtensionMessagesFiles['CrowdAuthentication'] = dirname( __FILE__ ) . '/CrowdAuthentication.i18n.php';

$caApplicationName = 'mediawiki';
$caApplicationPassword = '';
$caCrowdServerUrl = 'http://localhost:8095/crowd/services';
$caDefaultGroups = array("jira-users", "confluence-users");
$caImportGroups = true;
$caOverwriteLocalGroups = false;

// $caAddUserToCrowd = true;

class caPasswordCredential {
	/**
	 * @var string
	 */
	public $credential;
}

class caAuthenticatedToken {
}

class caPrincipal {
}

class caSearchRestriction {
}

class caSOAPGroup {
}

class caSOAPAttribute {

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var array
	 */
	public $values;

	/**
	 * @param $name string
	 * @param $value string
	 */
	public function __construct( $name, $value ) {
		$this->name = $name;
		$this->values = array( $value );
	}
}

class caApplicationAuthenticationContext {
	/**
	 * @var PasswordCredential
	 */
	public $credential;

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var array
	 */
	public $validationFactors = null;
}

class caPrincipalAuthenticationContext {
	public $application;

	/**
	 * @var PasswordCredential
	 */
	public $credential;

	/**
	 * @var string
	 */
	public $name;

	/**
	 * @var array
	 */
	public $validationFactors = null;
}

class CrowdAuthenticator extends AuthPlugin {

	/**
	 * @var null|SoapClient
	 */
	private $crowd = null;
	private $token = null;

	/**
	 * @return SoapClient
	 */
	private function getCrowd() {
		global $caCrowdServerUrl, $caApplicationName, $caApplicationPassword;

		if ( is_null( $this->crowd ) ) {
			$this->crowd = new SoapClient( $caCrowdServerUrl . '/SecurityServer?wsdl',
					array( 'classmap' =>
						array(
							'ApplicationAuthenticationContext' => 'caApplicationAuthenticationContext',
							'PrincipalAuthenticationContext' => 'caPrincipalAuthenticationContext',
							'PasswordCredential' => 'caPasswordCredential',
							'AuthenticatedToken' => 'caAuthenticatedToken',
							'SOAPPrincipal' => 'caPrincipal',
							'SOAPAttribute' => 'caSOAPAttribute',
							'SearchRestriction' => 'caSearchRestriction',
							'SOAPGroup' => 'caSOAPGroup',
						),
					)
				);
			$cred = new caPasswordCredential();
			$cred->credential = $caApplicationPassword;
			$authctx = new caApplicationAuthenticationContext();
			$authctx->credential = $cred;
			$authctx->name = $caApplicationName;
			$t = $this->crowd->authenticateApplication( array( "in0" => $authctx ) );
			$this->token = $t->out;
		}

		return $this->crowd;
	}

	/**
	 * @param $name string
	 * @return string|null
	 */
	private function findUsername( $name ) {
		/*
		 * Need to check several variations, e.g. lowercase initial letter,
		 * _ instead of ' ', etc.
		 */
		$variations = array(
			$name,
			strtolower( $name[0] ) . substr( $name, 1 ),
			str_replace( " ", "_", $name ),
		);

		$crowd = $this->getCrowd();
		foreach ( $variations as $v ) {
			try {
				$crowd->findPrincipalByName( array( "in0" => $this->token, "in1" => $v ) );
				return $v;
			} catch ( Exception $e ) {
				continue;
			}
		}

		return null;
	}

	/**
	 * @param $name string
	 * @return bool
	 */
	public function userExists( $name ) {
		return !is_null( $this->findUsername( $name ) );
	}

	/**
	 * @param $username string
	 * @param $password string
	 * @return bool
	 */
	public function authenticate( $username, $password ) {
		global $caApplicationName;

		$crowd = $this->getCrowd();
		$cred = new caPasswordCredential();
		$cred->credential = $password;
		$authctx = new caPrincipalAuthenticationContext();
		$authctx->name = $this->findUsername( $username );
		$authctx->credential = $cred;
		$authctx->application = $caApplicationName;

		try {
			$crowd->authenticatePrincipal( array( "in0" => $this->token, "in1" => $authctx ) );
			return true;
		} catch ( Exception $e ) {
			return false;
		}
	}

	/**
	 * @param $user User
	 * @return bool
	 */
	public function updateUser( &$user ) {
		global $caImportGroups, $caOverwriteLocalGroups;

		if ( !$caImportGroups ) {
			return true;
		}

		/*
		 * Find the groups this user is a member of.
		 */

		$groups = $this->crowd->findGroupMemberships( array( "in0" => $this->token, "in1" => $user->getName() ) );
		$groups = $groups->out->string;

		$dbw = wfGetDB( DB_MASTER );
		if ( $caOverwriteLocalGroups ) {
			$dbw->delete( 'user_group', array( 'ug_user' => $user->getId() ) );
		}

		foreach ( $groups as $group ) {
			$user->addGroup( $group );
		}
		return true;
	}

	/**
	 * @return bool
	 */
	public function autoCreate() {
		return true;
	}

	/**
	 * @return bool
	 */
	public function strict() {
		return true;
	}

	/**
	 * @return bool
	 */
	public function allowPasswordChange() {
		return true;
	}

	/**
	 * @param $user User
	 * @param $password string
	 * @return bool
	 */
	public function setPassword( $user, $password ) {
		$newcred = new caPasswordCredential;
		$newcred->credential = $password;
		$username = $this->findUsername( $user->getName() );
		$crowd = $this->getCrowd();
		try {
			$crowd->updatePrincipalCredential( array(
						"in0" => $this->token,
						"in1" => $username,
						"in2" => $newcred ) );
			return true;
		} catch ( Exception $e ) {
			return false;
		}
	}

	/**
	 * @return bool
	 */
	public function canCreateAccounts() {
		return true;
	}

	/**
	 * @param $user User
	 * @param $password string
	 * @param $email string
	 * @param $realname string
	 * @return bool
	 */
	public function addUser( $user, $password, $email = '', $realname = '' ) {
		// global $caAddUserToCrowd;
		// if ( !$caAddUserToCrowd ) {
		// 	return true;
		// }

		global $caDefaultGroups;
		$crowd = $this->getCrowd();
		$nameparts = split( " ", $realname, 2 );
		$firstname = $user->getName();
		$lastname = "";
		if ( count( $nameparts ) > 0 && strlen( $nameparts[0] ) ) {
			$firstname = $nameparts[0];

			if ( count( $nameparts ) > 1 ) {
				$lastname = $nameparts[1];
			}
		}
		$cred = new caPasswordCredential();
		$cred->credential = $password;
		$principal = new caPrincipal();
		$principal->name = $user->getName();
		$principal->attributes = array(
			new caSOAPAttribute( "mail", $email ),
			new caSOAPAttribute( "givenName", $firstname ),
			new caSOAPAttribute( "sn", $lastname ),
			// new caSOAPAttribute( "invalidPasswordAttempts", 0 ),
			// new caSOAPAttribute( "lastAuthenticated", 0 ),
			// new caSOAPAttribute( "passwordLastChanged", 0 ),
			// new caSOAPAttribute( "requiresPasswordChange", 0 ),
		);
		$principal->active = true;
		$principal->conception = 0;
		$principal->lastModified = 0;

		try {
			$crowd->addPrincipal( array( "in0" => $this->token,
					"in1" => $principal,
					"in2" => $cred
				)
			);
			foreach ( $caDefaultGroups as $group ) {
				// XXX hack from Toolserver
				try {
					$crowd->addPrincipalToGroup( array( "in0" => $this->token, "in1" => $user->getName(), "in2" => $group ) );
				} catch (Exception $e) { }
			}

			return true;
		} catch ( Exception $e ) {
			return false;
		}
	}
}
