<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artur
 * Date: 15.04.13
 * Time: 17:56
 * To change this template use File | Settings | File Templates.
 */

class UserCredentials {
	private $name;
	private $password;
	private $domain;

	public function __construct( $name, $password, $domain = 'gmail.com' ) {
		$this->name = $name;
		$this->password = $password;
		$this->domain = $domain;
	}

	public function getPassword() {
		return $this->password;
	}

	public function getName() {
		return $this->name;
	}

	public function getDomain() {
		return $this->domain;
	}

	public function getEmail() {
		return $this->getName() . "@" . $this->getDomain();
	}
}
