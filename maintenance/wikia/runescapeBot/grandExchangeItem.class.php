<?php

class GrandExchangeItem {

	private $timeStamp;
	private $price;
	private $id;

	public function __construct( $timeStamp, $price, $id ) {
		$this->timeStamp = $timeStamp;
		$this->price = $price;
		$this->id = $id;
	}

	public function getTimeStamp() {
		return $this->timeStamp;
	}

	public function getPrice() {
		return $this->price;
	}

	public function getId() {
		return $this->id;
	}
}
