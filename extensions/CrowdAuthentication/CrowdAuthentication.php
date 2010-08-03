<?php
/* Copyright (c) 2007 River Tarnell <river@wikimedia.org>.        */
/*
 * Permission is granted to anyone to use this software for any purpose,
 * including commercial applications, and to alter it and redistribute it
 * freely. This software is provided 'as-is', without any express or implied
 * warranty.
 */
/* $Id: CrowdAuthentication.php 37969 2008-07-23 19:25:48Z simetrical $ */
/*
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
	'name'           => 'Crowd Authentication Plugin',
	'svn-date'       => '$LastChangedDate: 2008-07-23 21:25:48 +0200 (śro, 23 lip 2008) $',
	'svn-revision'   => '$LastChangedRevision: 37969 $',
	'author'         => 'River Tarnell',
	'description'    => 'Authentication plugin for Atlassian Crowd',
	'descriptionmsg' => 'crowdauthentication-desc',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:CrowdAuthentication'
);

$wgExtensionMessagesFiles['CrowdAuthentication'] = dirname(__FILE__) . '/CrowdAuthentication.i18n.php';

require_once("AuthPlugin.php");

class caPasswordCredential {
	public /*string*/ $credential;
};

class caAuthenticatedToken {
};

class caPrincipal {
};

class caSearchRestriction {
};

class caSOAPGroup {
};

class caSOAPAttribute {
	public /*string*/ $name;
	public /*string[]*/ $values;

	public function __construct(/*string*/ $name, /*string*/ $value) {
		$this->name = $name;
		$this->values = array($value);
	}
};

class caApplicationAuthenticationContext {
	public /*PasswordCredential*/ $credential;
	public /*string*/ $name;
	public /*ValidationFactor[]*/ $validationFactors = null;
};

class caPrincipalAuthenticationContext {
	public /*string*/ $application;
	public /*PasswordCredential*/ $credential;
	public /*string*/ $name;
	public /*ValidationFactor[]*/ $validationFactors = null;
};

class CrowdAuthenticator extends AuthPlugin {
	private $crowd = null;
	private $token = null;

	private function /*SoapClient*/ getCrowd() {
	global	$caCrowdServerUrl, $caApplicationName, $caApplicationPassword;

		if (is_null($this->crowd)) {
			$this->crowd = new SoapClient($caCrowdServerUrl . '/SecurityServer?wsdl',
					array('classmap' =>
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
			$t = $this->crowd->authenticateApplication(array("in0" => $authctx));
			$this->token = $t->out;
		}

		return $this->crowd;
	}

	private function /*bool*/ findUsername(/*string*/ $name) {
		/*
		 * Need to check several variations, e.g. lowercase initial letter,
		 * _ instead of ' ', etc.
		 */
		$variations = array(
			$name,
			strtolower($name[0]) . substr($name, 1),
			str_replace(" ", "_", $name),
		);

		$crowd = $this->getCrowd();
		foreach ($variations as $v) {
			try {
				$crowd->findPrincipalByName(array("in0" => $this->token, "in1" => $v));
				return $v;
			} catch (Exception $e) {
				continue;
			}
		}

		return null;
	}

	public function /*bool*/ userExists(/*string*/ $name) {
		return !is_null($this->findUsername($name));
	}

	public function /*bool*/ authenticate(/*string*/ $username, /*string*/ $password) {
	global	$caApplicationName, $caImportGroups, $caOverwriteLocalGroups;

		$crowd = $this->getCrowd();
		$cred = new caPasswordCredential();
		$cred->credential = $password;
		$authctx = new caPrincipalAuthenticationContext();
		$authctx->name = $this->findUsername($username);
		$authctx->credential = $cred;
		$authctx->application = $caApplicationName;

		try {
			$crowd->authenticatePrincipal(array("in0" => $this->token, "in1" => $authctx));
			return true;
		} catch (Exception $e) {
			return false;
		}
	}

	public function /*void*/ updateUser(/*User*/ &$user) {
	global	$caImportGroups, $caOverwriteLocalGroups;

		if (!$caImportGroups)
			return true;

		/*
		 * Find the groups this user is a member of.
		 */

		$restr = new caSearchRestriction();
		$restr->name = "group.principal.member";
		$restr->value = $this->findUsername($user->getName());
		$groups = $this->crowd->searchGroups(array("in0" => $this->token, "in1" => array($restr)));
		$groups = $groups->out->SOAPGroup;

		$dbw =& wfGetDB(DB_MASTER);
		if ($caOverwriteLocalGroups)
			$dbw->delete('user_group', array('ug_user' => $user->getId()));

		foreach ($groups as $group) {
			$user->addGroup($group->name);
		}
	}

	public function /*bool*/ autoCreate(/*void*/) {
		return true;
	}

	public function /*bool*/ strict(/*void*/) {
		return true;
	}

	public function /*bool*/ allowPasswordChange(/*void*/) {
		return true;
	}

	public function /*bool*/ setPassword(/*User*/ $user, /*string*/ $password) {
		$newcred = new caPasswordCredential;
		$newcred->credential = $password;
		$username = $this->findUsername($user->getName());
		$crowd = $this->getCrowd();
		try {
			$crowd->updatePrincipalCredential(array(
						"in0" => $this->token,
						"in1" => $username,
						"in2" => $newcred));
			return true;
		} catch (Exception $e) {
			return false;
		}
	}

	public function /*bool*/ canCreateAccounts(/*void*/) {
		return true;
	}

	public function /*bool*/ addUser(/*User*/ $user, /*string*/ $password,
					 /*string*/ $email = '', /*string*/ $realname = '') {
	global	$caDefaultGroups;
		$crowd = $this->getCrowd();
		$nameparts = split(" ", $realname, 2);
		$firstname = $user->getName();
		$lastname = "";
		if (count($nameparts) > 0)
			$firstname = $nameparts[0];
		if (count($nameparts) > 1)
			$lastname = $nameparts[1];
		$cred = new caPasswordCredential();
		$cred->credential = $password;
		$principal = new caPrincipal();
		$principal->name = $user->getName();
		$principal->attributes = array(
			new caSOAPAttribute("mail", $email),
			new caSOAPAttribute("givenName", $firstname),
			new caSOAPAttribute("sn", $lastname),
			new caSOAPAttribute("invalidPasswordAttempts", 0),
			new caSOAPAttribute("lastAuthenticated", 0),
			new caSOAPAttribute("passwordLastChanged", 0),
			new caSOAPAttribute("requiresPasswordChange", 0),
		);
		$principal->active = true;
		$principal->conception = 0;
		$principal->lastModified = 0;

		try {
			$crowd->addPrincipal(array("in0" => $this->token,
						   "in1" => $principal,
						   "in2" => $cred));
			foreach ($caDefaultGroups as $group)
				$crowd->addPrincipalToGroup(array("in0" => $this->token, "in1" => $user->getName(), "in2" => $group));

			return true;
		} catch (Exception $e) {
			return false;
		}
	}
};
