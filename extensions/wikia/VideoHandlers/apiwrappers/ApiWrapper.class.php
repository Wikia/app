<?php

abstract class ApiWrapper {

	private $videoId;
	
	public function __construct( $videoId ) {
		$this->videoId = $videoId;
	}

	abstract function getMetaData();

	abstract function getTitle();
	
	abstract function getDescription();
	
	abstract function getThumbnailUrl();
}