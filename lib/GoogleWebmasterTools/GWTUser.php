<?php
/**
 * Created by JetBrains PhpStorm.
 * User: artur
 * Date: 15.04.13
 * Time: 17:56
 * To change this template use File | Settings | File Templates.
 */

class GWTUser {
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


	public function setPassword($password)
	{
		$this->password = $password;
	}

	public function getPassword()
	{
		return $this->password;
	}

	public function setEmail($email)
	{
		$this->email = $email;
	}

	public function getEmail()
	{
		return $this->email;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public function getId()
	{
		return $this->id;
	}

	public function setCount($count)
	{
		$this->count = $count;
	}

	public function getCount()
	{
		return $this->count;
	}
}
