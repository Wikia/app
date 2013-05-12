<?php

class GWTUser implements IGoogleCredentials {
	private $id;
	private $email;
	private $password;
	private $count;

	function __construct( $id, $email, $password, $count )
	{
		$this->email = $email;
		$this->id = $id;
		$this->password = $password;
		$this->count = $count;
	}


	public function setPassword($password) {
		$this->password = $password;
	}

	public function getPassword() {
		return $this->password;
	}

	public function setEmail($email) {
		$this->email = $email;
	}

	public function getEmail() {
		return $this->email;
	}

	public function setId($id) {
		$this->id = $id;
	}

	public function getId() {
		return $this->id;
	}

	public function setCount($count) {
		$this->count = $count;
	}

	public function getCount() {
		return $this->count;
	}
}
