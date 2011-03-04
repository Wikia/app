<?php

class UAD {

	public function __construct() {

	}

	public function createToken() {
		return md5(rand(0,1000));
	}

}