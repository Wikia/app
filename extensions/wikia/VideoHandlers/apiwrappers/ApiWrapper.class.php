<?php

abstract class ApiWrapper {

	protected $videoId;
	
	protected static $API_URL;
	
	public function __construct( $videoId ) {
		$this->videoId = $videoId;
	}

	abstract function getMetadata();

	abstract function getTitle();
	
	abstract function getDescription();
	
	abstract function getThumbnailUrl();
}